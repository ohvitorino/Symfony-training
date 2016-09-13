<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $name = $request->get('name', 'empty');

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'name' => $name,
        ]);
    }

    /**
     * @Route("/birthday/{day}/{month}/{year}",
     *     defaults={"year": 2016},
     *     requirements={
     *          "day": "\d{1,2}",
     *          "month": "\d{1,2}",
     *          "year": "\d{4}"
     *      }
     *     )
     *
     * @param $day
     * @param $month
     * @param $year
     *
     * @return Response
     * @internal param Request $request
     */
    public function birthdayAction($day, $month, $year)
    {
        $year = $year ?: date('Y');

        $birthday = new DateTime();
        $birthday->setDate($year, $month, $day);

        return new Response(sprintf('In %s your birthday will be on a %s.', $year, $birthday->format('l')));
    }

    /**
     * @Route("/contact", name="app_contact")
     * @param Request $request
     * @return Response
     */
    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact, [
            'action' => $this->generateUrl('app_contact')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.notifier.contact')->notify($contact);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('contact.html.twig', [
            'contact_form' => $form->createView()
        ]);
    }
}
