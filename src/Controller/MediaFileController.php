<?php 
namespace App\Controller;

use App\Entity\Media;
use App\Form\MediaFileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Routing\Annotation\Route;

class MediaFileController extends AbstractController {

    /**
     * @Route("/api/upload", name="app_upload", methods={"POST"} )
     */
    public function uploadAudio(Request $request, SluggerInterface $slugger) {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $media = new Media();

        $form = $this->createForm(MediaFileType::class, $media);

        $data = array_merge($request->request->all(), ["mediaFile" => $request->files->get("mediaFile")]);
        
        $form->submit( $data  );

       

        if($form->isValid()) {

            $mediaFile = $form->get("mediaFile")->getData();

            if($mediaFile) {
                
                $originalFileName = pathinfo($mediaFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName =  $slugger->slug($originalFileName);
                $newFileName = $safeFileName . "-" . uniqid() . "-" . $media->getUploadedAt()->format("Y-m-d") . "." . $mediaFile->guessExtension();

                try {
                    $mediaFile->move(
                        $this->getParameter("media_directory"),
                        $newFileName
                    );
                } catch( FileException $e) {
                    return new Response($e->getMessage(), 500);
                }

                $media->setFilename($newFileName);
                
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();

            return new Response("File correctly uploaded", 201);
        }

        return new Response("Bad form : " . $form->getErrors(), 400);

        

    }

}