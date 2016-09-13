<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Hello', $crawler->text());
    }

    /**
     * @dataProvider provideTestContact
     */
    public function testContact(Contact $contact, $failMessage)
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contact');

        $this->assertContains('Contact us!', $crawler->filter('body')->text());

        $form = $crawler->selectButton('Send')->form();

        $client->submit($form, [
            'contact[subject]' => $contact->getSubject(),
            'contact[content]' => $contact->getContent(),
            'contact[email]' => $contact->getEmail(),
        ]);

        $this->assertSame($failMessage == false, $client->getResponse()->isRedirection());
        if ($failMessage) {
            $this->assertContains($failMessage, $client->getResponse()->getContent());
        }

        $result = $client->getContainer()
            ->get('doctrine')
            ->getRepository(Contact::class)
            ->findBy([
                'subject' => $contact->getSubject(),
                'content' => $contact->getContent(),
                'email' => $contact->getEmail()
            ]);

        $this->assertCount($failMessage ? 0 : 1, $result);
        if (!$failMessage) {
            $client->getContainer()->get('doctrine')->getManagerForClass(Contact::class)->remove($contact);
        }
    }

    public function provideTestContact()
    {
        $validContact = new Contact();
        $validContact->setSubject('foo');
        $validContact->setContent('foobarfoobarfoobarfoobarfoobarfoobar');
        $validContact->setEmail('foo@bar.com');

        $invalidForContentContact = new Contact();
        $invalidForContentContact->setSubject('foo');
        $invalidForContentContact->setContent('foo');
        $invalidForContentContact->setEmail('foo@bar.com');

        return [
            [$validContact, false],
            [$invalidForContentContact, '16 characters']
        ];
    }
}
