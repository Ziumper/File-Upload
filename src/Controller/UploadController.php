<?php

namespace App\Controller;

use App\Dto\UploadEntryDto;
use App\Service\UploadEntryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use App\Resolver\UploadEntryValueResolver;

class UploadController  extends AbstractController {

    public function __construct(
        private UploadEntryServiceInterface $uploadEntryService,
    ) {}

    #[Route('/upload',name:"upload",methods:"POST")]    
    public function uploadAction(#[ValueResolver(UploadEntryValueResolver::class)] UploadEntryDto $uploadEntryDto) :  JsonResponse {
        return new JsonResponse([
            "success" =>  $this->uploadEntryService->uploadEntry($uploadEntryDto)    
        ]);
    }
}