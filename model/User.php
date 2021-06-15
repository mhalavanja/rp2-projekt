<?php


class User extends Model
{
    private $id;
    private $username;
    private $is_admin;
    private $password_hash;
    private $email;
    private $registration_sequence;
    private $has_registered;
    protected static $table = "projekt_users";
    protected static $columns = [];

    public function __construct(){}

    public static function staticInit()
    {
        User::setColumns();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getIsAdmin()
    {
        return $this->is_admin;
    }

    public function setIsAdmin($is_admin): void
    {
        $this->is_admin = $is_admin;
    }

    public function getPassword_hash()
    {
        return $this->password_hash;
    }

    public function setPassword_hash($password_hash)
    {
        $this->password_hash = $password_hash;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getRegistration_sequence()
    {
        return $this->registration_sequence;
    }

    public function setRegistration_sequence($registration_sequence)
    {
        $this->registration_sequence = $registration_sequence;
    }

    public function getHas_registered()
    {
        return $this->has_registered;
    }

    public function setHas_registered($has_registered)
    {
        $this->has_registered = $has_registered;
    }
}

User::staticInit();
