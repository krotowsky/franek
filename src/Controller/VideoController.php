<?php


namespace App\Controller;

use App\Form\VideoUploadType;
use App\Service\BunnyCDNStorageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
    private $bunnyCDNStorage;

    public function __construct(BunnyCDNStorageService $bunnyCDNStorage)
    {
        $this->bunnyCDNStorage = $bunnyCDNStorage;
    }

    #[Route('/upload/video', name: 'upload_video')]
    public function upload(Request $request): Response
    {
        $form = $this->createForm(VideoUploadType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $videoFile = $form->get('video')->getData();

            if ($videoFile) {
                $uploadPath = '/' . $videoFile->getClientOriginalName();

                // Use the BunnyCDN service to upload the file
                $uploadSuccess = $this->bunnyCDNStorage->uploadFile($videoFile, $uploadPath);
                if ($uploadSuccess) {
                    $this->addFlash('success', 'Video uploaded successfully to BunnyCDN.');
                    return $this->redirectToRoute('app_index');
                } else {
                    $this->addFlash('error', 'Failed to upload video to BunnyCDN.');
                }
            }
        }

        return $this->render('video/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
