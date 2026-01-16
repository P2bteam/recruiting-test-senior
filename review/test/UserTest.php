<?php

namespace review\test;

use App\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * Création d'un compte membre.
     */
    public function testMemberCreateAccount(): void
    {
        /**
         *  Injection des valeurs du formulaire
         */
        $tabRequest['userName'] = 'username';
        $tabRequest['userPassword'] = 'password';
        $tabRequest['userMail'] = 'myMail@example.com';
        $tabRequest['REMOTE_ADDR'] = '127.0.0.1';
        $tabRequest['REMOTE_PORT'] = '1234';

        $user = new User();
        $this->assertTrue($user->register($tabRequest));
        $this->assertEquals('mymail@example.com', $user->getEmail(), 'Vérification email');
        $this->assertEquals(3, $user->getId());
        $this->assertEquals('127.0.0.1', $user->getIpInscription());
        $this->assertEquals(User::LEVEL_USER, $user->getRole());
        $this->assertEquals('username', $user->getUserName());
        $this->assertTrue($user->signIn($_POST['userName'], $_POST['userPassword']));
    }
}