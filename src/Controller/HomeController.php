<?php

namespace App\Controller;

use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        Request $request,
    ): Response {
        $form = $this->createForm(ProductType::class);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {         
            // Do something with the uploaded file
        }

        return $this->render('home/index.html.twig', [
            'form' => $form,
        ]);
    }
}
