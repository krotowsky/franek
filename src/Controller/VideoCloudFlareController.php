<?php
declare(strict_types=1);

// src/Controller/VideoController.php

namespace App\Controller;

use App\Form\VideoUploadType;
use App\Service\CloudflareStreamService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoCloudFlareController extends AbstractController
{
    private  $streamService;
    public function __construct(CloudflareStreamService $streamService)
    {
        $this->streamService = $streamService;
    }

    #[Route('/upload/cloudflare/video', name: 'upload_video_cloduflare')]
    public function uploadCloudflare(Request $request): Response
    {
        $form = $this->createForm(VideoUploadType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $videoFile = $form->get('video')->getData();
            if ($videoFile) {
                $videoId = $this->streamService->uploadVideo($videoFile);

                if ($videoId) {
                    // Handle success, e.g., redirect or show a success message
                    return $this->redirectToRoute('app_index');
                } else {
                    // Handle error, e.g., show an error message
                    $this->addFlash('error', 'There was a problem uploading your video.');
                }
            }
        }

        return $this->render('video/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
