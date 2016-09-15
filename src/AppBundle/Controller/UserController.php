<?php
/**
 * User: brunop
 * Date: 14/09/2016
 * Time: 10:23
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\UserRegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @Route("/register", name="app_user_register")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);
        $form->add('send', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Set the salt
            $user->setSalt(sha1(random_bytes(16)));

            // Encode password
            $hashedPassword = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            // Persist user
            $em = $this->get('doctrine')->getManagerForClass(User::class);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('user/register.html.twig', [
            'registerForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="app_user_login")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        return $this->render('user/login.html.twig', [
            'errors' => $this->get('security.authentication_utils')->getLastAuthenticationError(),
            'last_username' => $this->get('security.authentication_utils')->getLastUsername()
        ]);
    }
}