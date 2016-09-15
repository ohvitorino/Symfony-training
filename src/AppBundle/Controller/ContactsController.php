<?php
/**
 * User: brunop
 * Date: 14/09/2016
 * Time: 17:01
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactsController
 * @package AppBundle\Controller
 *
 * @Route("/contacts")
 */
class ContactsController extends Controller
{
    /**
     * @Route("/list", name="app_contacts_list")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $contacts = $this->get('doctrine')
            ->getRepository(Contact::class)
            ->findAll();
        return $this->render('contacts/list.html.twig', [
            'contacts' => $contacts
        ]);
    }

    /**
     * @Route("/edit/{id}", name="app_contacts_edit")
     * @param Request $request
     * @param Contact $contact
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editContactAction(Request $request, Contact $contact)
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->add('send', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->get('doctrine')->getManagerForClass(Contact::class);
            $em->persist($contact);
            $em->flush();
        }

        return $this->render('contacts/edit.html.twig', [
            'edit_form' => $form->createView()
        ]);
    }

}