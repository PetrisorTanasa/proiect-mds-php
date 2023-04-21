<?php

namespace App\Controller;

use App\Service\AccountService;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /*
     * Request example:
     * {
     * "username":"AlexSmecherul",
     * "password":"alexESmecher1!A",
     * "email":"alex@yahoo.com",
     * "phone_number":"0770123456",
     * "name":"Popescu",
     * "surname":"Alexandru",
     * "age":18
     * }
     */
    #[Route('/v1/register', name: 'app_register')]
    public function registerAccount(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $account_info = json_decode($request->getContent(),true);

        $response = (new AccountService())->checkFields($account_info, $managerRegistry);

        if($response["response"]){
            (new AccountService())->saveAccount($account_info, $managerRegistry);
        }

        return new JsonResponse($response);
    }
}
