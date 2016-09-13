<?php
/**
 * User: brunop
 * Date: 13/09/2016
 * Time: 11:59
 */

namespace AppBundle\Notifier;


use AppBundle\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bridge\Monolog\Logger;

class ContactNotifier
{
    /**
     * @var Logger
     */
    private $logger;
    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * ContactNotifier constructor.
     * @param $doctrine
     */
    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function notify(Contact $contact)
    {
        // log
        if ($this->logger) {
            $this->logger->addDebug('New contact from the website');
        }

        // persist in database
        $em = $this->doctrine->getManagerForClass(Contact::class);
        $em->persist($contact);
        $em->flush();

        return true;
    }
}