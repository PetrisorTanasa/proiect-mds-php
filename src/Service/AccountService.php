<?php

namespace App\Service;


use App\Entity\Account;
use App\Repository\AccountRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;

class AccountService
{
    /*
     *      * {
     * "username":"AlexSmecherul",
     * "password":"alexESmecher1!A",
     * "phone_number":"0770123456",
     * "name":"Popescu",
     * "surname":"Alexandru",
     * "age":18
     * }
     */
    public function checkFields(array $account_fields, ManagerRegistry $managerRegistry){

        $check = $this->validateRequest($account_fields, $managerRegistry);

        $response = [
            "response" => !$check["response"],
            "error" => $check["error"]
        ];


        return $response;
    }

    public function validateRequest(array $account_fields, ManagerRegistry $managerRegistry){
        $response = "Check fields:";
        $error = false;

        if(!isset($account_fields["username"]) or empty($account_fields["username"])){
            $response .= "username;";
            $error = true;
        }
        if(!isset($account_fields["password"]) or empty($account_fields["password"])){
            $response .= "password;";
            $error = true;
        }else if(!$this->validatePassword($account_fields["password"])){
            $response .= "Your password is not strong enough;";
            $error = true;
        }
        if(!isset($account_fields["phone_number"]) or empty($account_fields["phone_number"])){
            $response .= "phone_number;";
            $error = true;
        }
        if(!isset($account_fields["name"]) or empty($account_fields["name"])){
            $response .= "name;";
            $error = true;
        }
        if(!isset($account_fields["surname"]) or empty($account_fields["surname"])){
            $response .= "surname;";
            $error = true;
        }
        if(!isset($account_fields["age"]) or empty($account_fields["age"])){
            $response .= "age;";
            $error = true;
        }elseif ($account_fields["age"] < 18){
            $response = "You're too young to gamble;";
            $error = true;
        }

        if((new AccountRepository($managerRegistry))->checkExistence($account_fields)){
            $response = "You already have an account with us;";
            $error = true;
        }

        return [
            "response" => $error,
            "error"    => $error == true ? $response : ""
            ];
    }

    function validatePassword($password) {
        $pattern = '/^(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{8,}$/';

        if (preg_match($pattern, $password)) {
            return true; // Password is valid
        } else {
            return false; // Password is invalid
        }
    }

    public function saveAccount(array $account_fields, ManagerRegistry $managerRegistry){
        (new AccountRepository($managerRegistry))->addAccount($account_fields);
    }

    public function checkAccount(array $account_fields, ManagerRegistry $managerRegistry){
        return (new AccountRepository($managerRegistry))->loginAccount($account_fields);
    }
}