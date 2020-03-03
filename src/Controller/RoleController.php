<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleController extends AbstractController
{

    /**
     * @Route("/listUsers", name="lista_usuarios")
     */
    public function mostrarUsuarios(): Response
    {
        $users = [];
        if ($this->getUser()) {
            $user = $this->getUser();
            $entityManager = $this->getDoctrine()->getManager();

            if (in_array('ROLE_ADMIN', $user->getRoles())) {
                $users = $entityManager->getRepository(User::class)->findAll();
            } else if (in_array('ROLE_SUPER', $user->getRoles())) {
                $users = $entityManager->getRepository(User::class)->findByTwoRole('ROLE_SUPER', 'ROLE_USER');
            } else if (in_array('ROLE_USER', $user->getRoles())) {
                $users = $entityManager->getRepository(User::class)->findByRole('ROLE_USER');
            }
        }
        return $this->render('users/show_users.html.twig',[
            'users' => $users
        ]);
    }
}