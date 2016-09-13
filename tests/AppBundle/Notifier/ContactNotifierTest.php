<?php
/**
 * User: brunop
 * Date: 13/09/2016
 * Time: 15:46
 */

namespace Tests\AppBundle\Notifier;


use AppBundle\Entity\Contact;
use AppBundle\Notifier\ContactNotifier;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;

class ContactNotifierTest extends \PHPUnit_Framework_TestCase
{
    public function testNotify()
    {
        $contact = new Contact();

        $manager = $this->createMock(EntityManager::class);

        // This is for in depth tests, to insure that
        // the code is really doing something with the
        // $contact and inserting it into the database
        $manager
            ->expects($this->once())
            ->method('persist')
            ->with($contact);

        $manager
            ->expects($this->once())
            ->method('flush');

        $doctrine = $this->createMock(Registry::class);
        $doctrine
            ->expects($this->once())// Other options are 'at', 'greaterThan', etc
            ->method('getManagerForClass')
            ->willReturn($manager);

        $notifier = new ContactNotifier($doctrine);
        $return = $notifier->notify($contact);

        $this->assertTrue($return);
    }
}