<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use App\Service\UploadEntryServiceInterface;

class UploadControllerTest extends WebTestCase
{

    public function testUploadsListAction(): void {
        $entriesAmount = 10;
        $entries = $this->createReturnUploadEntries($entriesAmount);
        $client = static::createClient();
        $container = $this->getContainer();
        $uploadService = $this->createMock(UploadEntryServiceInterface::class);
        $uploadService->expects(self::once())->method('getAllEntries')->willReturn($entries);
        $container->set(UploadEntryServiceInterface::class,$uploadService);
        
        $client->request("GET", "/uploadsList");
        $this->assertResponseIsSuccessful();
        
        $response = $client->getResponse();
        $content = $response->getContent();
        $objects = json_decode($content)->data;
        $this->assertCount($entriesAmount,$objects);
        
        for($i=0; $i<$entriesAmount; $i++) {
            $object = $objects[$i];
            $entry = $entries[$i];
            $this->assertEquals($object->name,$entry->name);
            $this->assertEquals($object->surname,$entry->surname);
            $this->assertEquals($object->fileName,$entry->fileName);
        }
    }
    
    private function createReturnUploadEntries($entriesAmount): array {
        $entries = [];
        for($i = 0; $i < $entriesAmount; $i++) {
            $entry = new \App\Dto\ReturnUploadEntryDto("testName$i","testSurname$i","testFileName$i.jpg");
            $entries[] = $entry;
        }
        return $entries;
    }

    public function testUploadEntry(): void
    {
        $client = static::createClient();
        $this->mockUploadServiceAndUploadEntryMethod();
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
        $imageManager = new ImageManager(new ImagickDriver());
        $tempFilePath = sys_get_temp_dir() . '/sample_image.jpg';
        $imageManager->create(100,100)->save($tempFilePath);
        $file = new UploadedFile($tempFilePath,"sample_image.jpg",null,null,true);
        $client = static::createClient();
        $this->mockUploadServiceAndUploadEntryMethod();        
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
        unlink($tempFilePath);
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
        unlink("newfile.txt");
    }
    
    private function mockUploadServiceAndUploadEntryMethod() {
        $container = $this->getContainer();

        $uploadService = $this->createMock(UploadEntryServiceInterface::class);
        $uploadService->expects(self::once())->method('uploadEntry')->willReturn(true);
        $container->set(UploadEntryServiceInterface::class,$uploadService);
    }
}