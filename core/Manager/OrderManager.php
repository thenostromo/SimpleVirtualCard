<?php
namespace Manager;

use DTO\CartItemPriceModel;
use DTO\CartItemViewModel;
use DTO\OrderItemModel;
use DTO\OrderItemPriceModel;
use DTO\OrderModel;
use Entity\CartItem;
use Entity\Order;
use Entity\OrderItem;
use Entity\User;
use Exception\CouldNotUpdateTableException;
use Exception\NotEnoughMoneyException;
use Maker\DTOMaker;
use Provider\OrderProvider;
use Repository\CartItemRepository;
use Repository\OrderItemRepository;
use Repository\OrderRepository;
use Repository\UserRepository;

class OrderManager
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var CartItemRepository
     */
    private $cartItemRepository;

    /**
     * @var OrderItemRepository
     */
    private $orderItemRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct()
    {
        $databaseManager = new DatabaseManager();

        $this->orderRepository = new OrderRepository($databaseManager->getConnection());
        $this->cartItemRepository = new CartItemRepository($databaseManager->getConnection());
        $this->orderItemRepository = new OrderItemRepository($databaseManager->getConnection());
        $this->userRepository = new UserRepository($databaseManager->getConnection());
    }

    /**
     * @param array $sessionUser
     * @return CartItemViewModel[]
     */
    public function getCartItemViewList(array $sessionUser): array
    {
        return $this->cartItemRepository->getCartItemViewListByUser($sessionUser);
    }

    /**
     * @param OrderModel $orderModel
     * @param array $sessionUser
     * @throws CouldNotUpdateTableException
     * @throws NotEnoughMoneyException
     */
    public function makeOrder(OrderModel $orderModel, array $sessionUser)
    {
        $totalPrice = 0;
        $cartItemPriceList = $this->cartItemRepository->getCartItemsPriceByUser($orderModel->userId);

        $orderModel->status = OrderProvider::ORDER_STATUS_IS_BEING_PROCESSED;

        /** @var Order|null $order */
        $order = $this->orderRepository->getLastOrderByUser($orderModel->userId);

        if (!($order instanceof Order) || $order->getIsFormed() === OrderProvider::ORDER_IS_FORMED)
        {
            $this->orderRepository->makeOrder($orderModel);
            $order = $this->orderRepository->getLastOrderByUser($orderModel->userId);
        }

        $transportTypePrice = OrderProvider::getTransportTypePrice()[$orderModel->transportType];
        $totalPrice = floatval($transportTypePrice);

        $user = new User();
        $user->makeFromArray($sessionUser);
        $newBalance = floatval($user->getBalance()) - $totalPrice - $this->getCartItemTotalPrice($cartItemPriceList);
        if ($newBalance < 0)
        {
            throw new NotEnoughMoneyException();
        }

        /** @var CartItemPriceModel $cartItemPrice */
        foreach ($cartItemPriceList as $cartItemPrice)
        {
            $orderItemModel = new OrderItemModel();
            $orderItemModel->orderId = $order->getId();
            $orderItemModel->productId = $cartItemPrice->productId;
            $orderItemModel->quantity = $cartItemPrice->quantity;

            if ($this->orderItemRepository->getOrderItem($orderItemModel) instanceof OrderItem)
            {
                continue;
            }
            if ($this->orderItemRepository->addOrderItem($orderItemModel))
            {
                $cartItem = new CartItem();
                $cartItem->setUserId($cartItemPrice->userId);
                $cartItem->setProductId($cartItemPrice->productId);
                $this->cartItemRepository->removeCartItem($cartItem);
            }
            else
            {
                throw new CouldNotUpdateTableException();
            }
        }

        $_SESSION["balance"] = $newBalance;
        $user->setBalance($newBalance);

        $this->userRepository->updateUserBalance($user);
        $this->orderRepository->setOrderIsFormed($order);
    }

    /**
     * @param CartItemPriceModel[] $cartItemPriceList
     * @return float|int
     */
    private function getCartItemTotalPrice(array $cartItemPriceList)
    {
        $totalPrice = 0;
        foreach ($cartItemPriceList as $cartItemPrice)
        {
            $totalPrice += floatval($cartItemPrice->pricePerUnit) * $cartItemPrice->quantity;
        }
        return $totalPrice;
    }

    /**
     * @param array $sessionUser
     * @return array
     */
    public function getOrderList(array $sessionUser): array
    {
        $result = [];
        $orderList = $this->orderRepository->getOrderList($sessionUser["id"]);
        $orderModelList = DTOMaker::makeOrderViewModelList($orderList);

        foreach ($orderModelList as $orderModel)
        {
            $totalPrice = 0;
            $orderItemList = $this->orderItemRepository->getOrderItemPriceList($orderModel->id);

            /** @var OrderItemPriceModel $orderItem */
            foreach ($orderItemList as $orderItem)
            {
                $totalPrice += intval($orderItem->quantity) * floatval($orderItem->pricePerUnit);
            }
            $transportTypePrice = OrderProvider::getTransportTypePrice()[$orderModel->transportType];
            $totalPrice += floatval($transportTypePrice);
            $orderModel->totalPrice = $totalPrice;
            $result[] = $orderModel;
        }
        return $result;
    }
}