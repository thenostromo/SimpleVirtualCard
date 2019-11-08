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

    public function __construct()
    {
        $this->id = null;
        $this->password = null;
        $this->fullname = null;
        $this->email = null;
    }
}
