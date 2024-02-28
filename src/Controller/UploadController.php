<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class UploadController  extends AbstractController {

    #[Route('/upload',name:"upload",methods:"POST")]    
    public function uploadAction(Request $request) :  JsonResponse {
        return new JsonResponse([
            "success" => true
        ]);
    }

    // #[Route('/upload/list', name: "upload_list")]
    // public function uploadListAction(Request $request) {

    // }

}