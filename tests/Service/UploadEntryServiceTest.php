<?php

namespace App\Tests\Service;

use App\Repository\UploadEntryRepositoryInterface;
use App\Service\UploadEntryServiceInterface;
use App\Dto\UploadEntryDto;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UploadEntryServiceTest extends KernelTestCase
{
    public function testUpload(): void
    {
        $uploadRepository = $this->createMock(UploadEntryRepositoryInterface::class);
        $uploadRepository->expects(self::once())->method('save')->willReturn(true);
        
        $container = $this->getContainer();
        $container->set(UploadEntryRepositoryInterface::class,$uploadRepository);

        /**
         * @var UploadEntryServiceInterface $uploadService
         */
        $uploadService = $container->get(UploadEntryServiceInterface::class);
        $result = $uploadService->uploadEntry(new UploadEntryDto("testName","testSurname"));

        $this->assertTrue($result);
    }
}
