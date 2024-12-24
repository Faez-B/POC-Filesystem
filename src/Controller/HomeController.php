<?php

namespace App\Controller;

use App\Form\ProductType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        Request $request,
        SluggerInterface $slugger,
        #[Autowire('%upload_dir%')] string $uploadDir,
    ): Response {
        $filesystem = new Filesystem();

        if(!$filesystem->exists($uploadDir)) {
            $filesystem->mkdir($uploadDir);
        }

        $form = $this->createForm(ProductType::class);
        
        $base64Image = '';

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {         
            /** @var UploadedFile $file */   
            $file = $form->get('file')->getData();

            $base64Image = base64_encode(file_get_contents($file->getPathname()));

            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $file->move($uploadDir, $newFilename);
                $this->addFlash('success', 'File uploaded successfully!');
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
                $this->addFlash('error', 'An error occurred while uploading the file!');
            }
        }

        return $this->render('home/index.html.twig', [
            'form' => $form,
            'base64' => $base64Image,
        ]);
    }

    #[Route('/base64', name: 'base64')]
    public function saveImageContent(
        SluggerInterface $slugger,
        #[Autowire('%upload_dir%')] string $uploadDir,
    ): Response {
        $filesystem = new Filesystem();

        if(!$filesystem->exists($uploadDir . '/base64')) {
            $filesystem->mkdir($uploadDir . '/base64');
        }

        /**
         * @var string $base64Image
         */
        $base64Image = $this->getParameter('base64');

        try {
            $filesystem->dumpFile($uploadDir . '/base64/' . uniqid() . '.png', base64_decode($base64Image));

            // Same as above
            // file_put_contents($uploadDir . '/base64/' . uniqid() . '.png', base64_decode($base64Image));
        } catch (IOException $e) {
            throw $e;
        }

        return new Response('Image is saved !', Response::HTTP_OK);
    }
}
