<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserCreation(): void
    {
        $user = new User();
        $user->setUsername('testuser')
            ->setEmail('testuser@example.com')
            ->setPassword('password');

        $this->assertEquals('testuser', $user->getUsername());
        $this->assertEquals('testuser@example.com', $user->getEmail());
        $this->assertEquals('password', $user->getPassword());
    }

    public function testUserRoles(): void
    {
        $user = new User();
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $this->assertContains('ROLE_USER', $user->getRoles());
        $this->assertContains('ROLE_ADMIN', $user->getRoles());
    }

    public function testUserIsAdmin(): void
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);

        $this->assertTrue($user->isAdmin());
    }
}
