<?php
namespace DTO;

class UserModel
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $fullname;

    /**
     * @var string
     */
    public $balance;

    public function __construct()
    {
        $this->id = null;
        $this->password = null;
        $this->fullname = null;
        $this->email = null;
        $this->balance = null;
    }
}
