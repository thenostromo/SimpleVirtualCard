<!DOCTYPE html>
<html>

<head>
    <?php include_once 'embed/html_head.php' ?>
</head>

<body>
<div class="container">
    <?php include_once 'embed/header.php' ?>
    <main role="main" class="container">
        <?php if (count($orderList) > 0): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card flex-md-row mb-4 shadow-sm">
                        <div class="card-body d-flex flex-column align-items-start">
                            <strong class="d-inline-block mb-2 text-primary">Your Orders:</strong>
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Total price</th>
                                        <th scope="col">Transport type</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orderList as $order): ?>
                                        <tr >
                                            <td>
                                                <?php echo $order->id; ?>
                                            </td>
                                            <td>
                                                <?php echo $order->totalPrice; ?>$
                                            </td>
                                            <td>
                                                <?php echo $form["transportTypeChoice"][$order->transportType]; ?>
                                            </td>
                                            <td>
                                                <?php echo $form["orderStatusChoice"][$order->status]; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card flex-md-row mb-4 shadow-sm">
                    <div class="card-body d-flex flex-column align-items-start">
                        <strong class="d-inline-block mb-2 text-primary">Your Cart:</strong>
                        <div class="alert alert-primary" id="warningCartIsEmpty" role="alert" <?php if (count($cartItemList) > 0): ?>style="display: none;"<?php endif;?>>
                            Your cart is empty.
                        </div>
                        <?php if (count($cartItemList) > 0): ?>
                            <table class="table" id="tableCartItems">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Price per unit</th>
                                        <th scope="col">Total price</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $iteration = 1; ?>
                                    <?php $totalPrice = 0; ?>
                                    <?php foreach ($cartItemList as $cartItem): ?>
                                        <tr id="<?php echo "itemRow_" . $cartItem->productId; ?>">
                                            <td>
                                                <?php echo $cartItem->productName; ?>
                                            </td>
                                            <td>
                                                <span id="<?php echo "indicatorQuantity_" . $cartItem->productId; ?>">
                                                    <?php echo $cartItem->quantity; ?>
                                                </span>
                                                <button type="button" class="btn btn-primary btn-sm" onclick="addUnit('<?php echo $cartItem->productId; ?>')">+</button>
                                                <button type="button" class="btn btn-light btn-sm" onclick="removeUnit('<?php echo $cartItem->productId; ?>')">-</button>
                                            </td>
                                            <td>
                                                <span id="<?php echo "pricePerUnit_" . $cartItem->productId; ?>">
                                                    <?php echo $cartItem->price; ?>
                                                </span>$
                                            </td>
                                            <td>
                                                <?php
                                                    $itemPrice = floatval($cartItem->price) * $cartItem->quantity;
                                                    $totalPrice += $itemPrice;
                                                ?>
                                                <span id="<?php echo "indicatorItemPrice_" . $cartItem->productId; ?>">
                                                    <?php echo $itemPrice; ?>
                                                </span>$
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-link" onclick="removeCartItem('<?php echo $cartItem->productId; ?>')">x</button>
                                            </td>
                                        </tr>
                                        <?php $iteration += 1; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="alert alert-danger" id="warningNotEnoughFunds" style="display: none;">
                                There are not enough funds in your account for this cart.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if (count($cartItemList) > 0): ?>
            <form action="<?php echo $url["makeOrder"]; ?>" method="POST" id="form">
                <div class="row" id="blockTransportType">
                    <div class="col-md-12">
                        <div class="card flex-md-row mb-4 shadow-sm">
                            <div class="card-body d-flex flex-column align-items-start">
                                <strong class="d-inline-block mb-2 text-primary">Choose transport type:</strong>
                                <select name="transportType" id="transportType" class="form-control" onchange="changeTransportType()">
                                    <option disabled selected>- choose transport type -</option>
                                    <?php foreach ($form["transportTypeChoice"] as $key => $title): ?>
                                        <option value="<?php echo $key; ?>">
                                            <?php echo $title; ?>

                                            <?php $price = $form["transportTypePrice"][$key]; ?>
                                            <?php if ($price == 0): ?>
                                                (free)
                                            <?php else: ?>
                                                (+ <?php echo $price; ?>$)
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="text-danger" id="warningEmptyTransportType" style="display: none;">Please, choose transport type.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="blockTotalPrice">
                    <div class="col-md-12">
                        <div class="card flex-md-row mb-4 shadow-sm">
                            <div class="card-body d-flex flex-column align-items-start">
                                <strong>Total price:
                                    <span id="totalPrice">
                                    <?php echo $totalPrice; ?>
                                </span>$</strong>
                                <button type="button" onclick="pay()" class="btn btn-primary">Pay</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </main>
</div>

<?php include_once 'embed/html_scripts.php' ?>
<script>
    let urlCartApiAddProductUnit = '<?php echo $url['cartApiAddProductUnit']; ?>';
    let cartApiRemoveProductUnit = '<?php echo $url['cartApiRemoveProductUnit']; ?>';
    let cartApiRemoveProduct = '<?php echo $url['cartApiRemoveProduct']; ?>';
    let transportTypePriceChoice = JSON.parse('<?php echo json_encode($form["transportTypePrice"]); ?>');
    let totalPriceItems = <?php echo $totalPrice; ?>;
    let totalPriceGeneral = totalPriceItems;
    let itemsCount = <?php echo count($cartItemList); ?>;

    function pay()
    {
        let formIsValid = true;
        let transportType = document.getElementById("transportType");
        let transportTypeValue = transportType.options[transportType.selectedIndex].value;

        if (transportTypeValue === "- choose transport type -") {
            document.getElementById("warningEmptyTransportType").style.display = "block";
            formIsValid = false;
        } else {
            document.getElementById("warningEmptyTransportType").style.display = "none";
        }

        let currentBalance = parseFloat(document.getElementById("userBalance").innerText);
        if (currentBalance < totalPriceGeneral) {
            document.getElementById("warningNotEnoughFunds").style.display = "block";
            formIsValid = false;
        }

        if (formIsValid) {
            document.getElementById("form").submit();
        }
    }

    function changeTransportType()
    {
        let transportTypeValue = transportType.options[transportType.selectedIndex].value;

        if (transportTypeValue !== "- choose transport type -") {
            increaseTotalPrice(transportTypePriceChoice[transportTypeValue]);
        }
    }

    function increaseTotalPrice(value)
    {
        let currentBalance = parseFloat(totalPriceItems);
        let newBalance = currentBalance + parseFloat(value);

        totalPriceGeneral = parseFloat(newBalance.toFixed(2));
        setNewTotalPrice(totalPriceGeneral);
    }

    function setNewTotalPrice(price)
    {
        document.getElementById('totalPrice').innerText = price;
    }

    function addUnit(productId)
    {
        let pricePerUnit = parseFloat(document.getElementById('pricePerUnit_' + productId).innerText);
        let itemPrice = parseFloat(document.getElementById('indicatorItemPrice_' + productId).innerText);
        let newItemPrice = itemPrice + pricePerUnit;

        let unitQuantity = Number(document.getElementById('indicatorQuantity_' + productId).innerText);
        let newUnitQuantity = unitQuantity + 1;

        $.ajax({
            url: urlCartApiAddProductUnit,
            type: "POST",
            data: {
                productId: productId,
                quantityValue: newUnitQuantity
            },
            success: function(){
                totalPriceGeneral = totalPriceGeneral + parseFloat(pricePerUnit);
                setNewTotalPrice(totalPriceGeneral.toFixed(2));

                document.getElementById('indicatorItemPrice_' + productId).innerText = newItemPrice.toFixed(2);
                document.getElementById('indicatorQuantity_' + productId).innerText = newUnitQuantity;
            },
            error: function(){
                console.log('Failed.');
            }
        });
    }

    function removeUnit(productId)
    {
        let pricePerUnit = parseFloat(document.getElementById('pricePerUnit_' + productId).innerText);
        let itemPrice = parseFloat(document.getElementById('indicatorItemPrice_' + productId).innerText);
        let newItemPrice = itemPrice - pricePerUnit;

        let unitQuantity = Number(document.getElementById('indicatorQuantity_' + productId).innerText);
        let newUnitQuantity = unitQuantity - 1;

        $.ajax({
            url: cartApiRemoveProductUnit,
            type: "POST",
            data: {
                productId: productId,
                quantityValue: newUnitQuantity
            },
            success: function(){
                totalPriceGeneral = totalPriceGeneral - pricePerUnit;
                setNewTotalPrice(totalPriceGeneral.toFixed(2));

                if (unitQuantity === 1) {
                    document.getElementById('itemRow_' + productId).style.display = "none";
                    itemsCount = itemsCount - 1;
                    showCartIsEmpty(itemsCount);
                } else {
                    document.getElementById('indicatorItemPrice_' + productId).innerText = newItemPrice.toFixed(2);
                    document.getElementById('indicatorQuantity_' + productId).innerText = newUnitQuantity;
                }
            },
            error: function(){
                console.log('Failed.');
            }
        });
    }

    function removeCartItem(productId)
    {
        let itemPrice = parseFloat(document.getElementById('indicatorItemPrice_' + productId).innerText);

        $.ajax({
            url: cartApiRemoveProduct,
            type: "POST",
            data: {
                productId: productId,
                quantityValue: 0
            },
            success: function(){
                totalPriceGeneral = totalPriceGeneral - itemPrice;
                setNewTotalPrice(totalPriceGeneral.toFixed(2));

                document.getElementById('itemRow_' + productId).style.display = "none";
                itemsCount = itemsCount - 1;
                showCartIsEmpty(itemsCount);
            },
            error: function(){
                console.log('Failed.');
            }
        });
    }

    function showCartIsEmpty(itemsCount)
    {
        if (itemsCount === 0) {
            document.getElementById("warningCartIsEmpty").style.display = "block";
            document.getElementById("blockTransportType").style.display = "none";
            document.getElementById("blockTotalPrice").style.display = "none";
            document.getElementById("tableCartItems").style.display = "none";
        }
    }
</script>
</body>

</html>