<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UploadControllerTest extends WebTestCase
{
    public function testUploadEntry(): void
    {
        $client = static::createClient();
        $client->request('POST', '/upload',
        [
            'name' => 'Test Name',
            "surname" => "Test Surname"
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testUploadEntryFailNameOrSurnameAreBlank(): void 
    {
        $client = static::createClient();
        $client->request('POST','/upload',
        [
            'name' => '',
            "surname" => ''
        ]
        );
        
        $this->assertNotEquals(200,$client->getResponse()->getStatusCode());
    }
}