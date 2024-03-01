<?php

// src/Controller/HomeController.php
namespace App\Controller;

use App\Service\UploadEntryServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(private readonly UploadEntryServiceInterface $uploadEntryServiceInterface) {}

    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('home/home.html.twig');
    }
    
    #[Route("/list", name:'list')]
    public function list(): Response {
        return $this->render("home/list.html.twig",[
            "entries" => $this->uploadEntryServiceInterface->getAllEntries()
        ]);
    }
}