<?php

require_once __SITE_PATH . '/app/database/db.class.php';

class UserService
{
    static function getUserByUsername($registrationSequence)
    {
        $db = DB::getConnection();
        try{
            $sql = "SELECT * FROM projekt_users";
            $sql .= " WHERE username = :username;";
            $st = $db->prepare($sql);
            $st->execute(array("username" => $registrationSequence ));
            $st->execute();
            $result = $st->fetchAll();
            if (empty($result)) return 0;
            return 1;
        } catch (PDOException $e) {
            exit("PDO error [select projekt_hotels]: " . $e->getMessage());
        }
    }


    static function saveUser($user)
    {
        return $user;
    }  

    static function updateUser($user)
    {
        $db = DB::getConnection();
        try{
            $sql = "UPDATE projekt_users";
            $sql .= " SET id = :id, ";
            $sql .= " username = :username, ";
            $sql .= " name = :name, ";
            $sql .= " lastname = :lastname, ";
            $sql .= " email = :email ";
            $sql .= " WHERE id = :id;";
            $st = $db->prepare($sql);
            $st->execute(array('username' => $user->getUsername(),'name' => $user->getName(),'lastname' => $user->getLastname(), 'email' => $user->getEmail(), 'id' => $user->getId() ));
            $st->execute();
        } catch (PDOException $e) {
            exit("PDO error [select projekt_hotels]: " . $e->getMessage());
        }
    }
}
