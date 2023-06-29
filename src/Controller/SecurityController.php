<?php

namespace App\Controller;

use App\Form\AdminType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/passer-en-admin_{id<\d+>}', name: 'app_passer_en_admin')]
    public function passerEnAdmin($id, Request $request, UserRepository $repo)
    {
        $secret = "123123aA";

        $form = $this->createForm(AdminType::class);
        $form->handleRequest($request); 

        $user = $repo->find($id);

        if (!$user) {
            throw $this->createNotFoundException("impossible de trouver l'utilisateur avec l'id : $id");
        }

        if ($form->isSubmitted() && $form->isValid())
        {
            if($form->get('secret')->getData() == $secret)
            {
                $user->setRoles(["ROLE_ADMIN"]);
            }else{
                throw $this->createNotFoundException("vous n'avez pas le bon code, êtes vous un intrus ?");
            }

            $repo->save($user, 1);

            return $this->redirectToRoute('app_home');
        }

        return $this->render('security/adminForm.html.twig', [
            "user" => $user,
            "formAdmin" => $form->createView()
        ]);
    }
    #[Route(path: '/confirmation-de-compte/{token}', name: 'app_activation')]
    
    public function confirmationCompte($token, UserRepository $repo)
    {
        // on récupère l'utilisateur ayant le token de l'url
        $user = $repo->findOneBy(["token" => $token]);
    
        // on verifie si un utilisateur est trouvé ou pas
        if (!$user) {
            $this->addFlash("error", "aucun utilisateur trouvé !");
            return $this->redirectToRoute('app_login');
        }
    //le token existe et donc l'utilisateur a été trouvé, on lui retire le token et on active son compte
    $user->setToken(null)
         ->setIsValid(true);
    
         $repo->save($user,1);
    
         $this->addFlash("success", "Félicitation, votre compte est maintenant activé, vous pouvez vous connecter.");
    
         return $this->redirectToRoute("app_login");
    
    
    }
}
