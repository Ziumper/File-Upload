<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

        $this->assertEquals(422,$client->getResponse()->getStatusCode());
    }

    public function testUploadSuccess(): void 
    {
        $myfile = fopen("newfile.jpg","w");
        fwrite($myfile,"dasasasdaddddasddasdasdasdasasddasdasda");

        $file = new UploadedFile("newfile.jpg","newFile.jpg",null,null,true);
        
        var_dump($file->getClientOriginalName());
        $client = static::createClient();
        
        $client->request('POST','/upload',
        [
            "name" => 'TestName',
            "surname" => "TestSurname",
            "mimeType"=> "image/jpeg"
        ],[
            "file" => $file
        ]);

        $response = $client->getResponse();
        
        $this->assertEquals(200,$response->getStatusCode(),$response->getContent());
    }

    public function testFileUploadWithWrongExtension(): void {
        $myfile = fopen("newfile.txt", "w");
        fwrite($myfile,"testing john doe");
        fclose($myfile);

        $file = new UploadedFile("newfile.txt","newFile","txt",null,true);

        $client = static::createClient();
        $client->request('POST','/upload',
        [
            "name" => 'TestName',
            "surname" => "TestSurname",
        ],[
            "file" => $file
        ]);

        $this->assertEquals(422,$client->getResponse()->getStatusCode());
        unlink($file->getRealPath());
    }
}