<?php

namespace App\Controller;

use App\Dto\UploadEntryDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class UploadController  extends AbstractController {

    #[Route('/upload',name:"upload",methods:"POST")]    
    public function uploadAction(
        #[MapRequestPayload] UploadEntryDto $uploadEntryDto
    ) :  JsonResponse {
        return new JsonResponse([
            "success" =>  $uploadEntryDto->name
        ]);
    }

    // #[Route('/upload/list', name: "upload_list")]
    // public function uploadListAction(Request $request) {

    // }

}