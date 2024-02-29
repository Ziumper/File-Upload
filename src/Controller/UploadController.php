<?php

namespace App\Controller;

use App\Dto\UploadEntryDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use App\Resolver\UploadEntryValueResolver;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

class UploadController  extends AbstractController {

    #[Route('/upload',name:"upload",methods:"POST")]    
    public function uploadAction(#[ValueResolver(UploadEntryValueResolver::class)] UploadEntryDto $uploadEntryDto) :  JsonResponse {
        return new JsonResponse([
            "success" =>  $uploadEntryDto->name
        ]);
    }

}