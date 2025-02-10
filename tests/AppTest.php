<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;

class AppTest extends WebTestCase
{
    public function testHomePage()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }

    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/note');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
    }

    public function testShow(): void
    {
        $client = static::createClient();
        $client->request('GET', '/note/1');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
    }

    public function testGetNotesByUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/note/user/1');

        $this->assertResponseIsSuccessful();
    }

    public function testGetNotesByTag(): void
    {
        $client = static::createClient();
        $client->request('GET', '/note/tag/Important');

        $this->assertResponseIsSuccessful();
    }

    public function testGetLatestNotes(): void
    {
        $client = static::createClient();
        $client->request('GET', '/note/latest/5');

        $this->assertResponseIsSuccessful();
    }

    public function testCreate(): void
    {
        $client = static::createClient();
        $client->loginUser($this->getAdminUser());

        $client->request('POST', '/note/create', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'title' => 'Test Note',
            'content' => 'This is a test note.',
        ]));

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testDelete(): void
    {
        $client = static::createClient();
        $client->loginUser($this->getAdminUser());

        $client->request('DELETE', '/note/1');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    private function getAdminUser()
    {
        return static::getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['email' => 'admin@example.com']);
    }
}
