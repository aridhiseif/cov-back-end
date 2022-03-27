<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function index(Request $req): Response
    {
        $user = new User();
        $param = json_decode($req->getContent(), true);

        $user->setEmail($param["email"]);

        $hashedpass = password_hash($param["password"], PASSWORD_BCRYPT);
        $user->setPassword($hashedpass);

        $user->setNom($param["nom"]);
        $user->setPrenom($param["prenom"]);
        $user->setRoles(["ROLE_USER"]);
        $user->setIsActive($param["isActive"]);

        $db = $this->getDoctrine()->getManager();
        $db->persist($user);
        $db->flush();

        return $this->json(["message" => "this is register controller", "status" => "ok"]);
    }
}
