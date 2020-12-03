<?php 
namespace App\Controller;

use App\Entity\Media;
use App\Form\MediaFileType;
use App\Service\FileUploader;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

class MediaManagerController extends AbstractController {
    

    private $fileUploader;


    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
        
        
    }

    /**
     * @Route("/api/upload/{httpMethod}", name="app_upload", methods={"POST"} )
     */
    public function uploadMedia(string $httpMethod = "POST", Request $request) {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $requestMethod = $httpMethod;

        $media = new Media();

        //FOR CHECKING IF IT'S A CREATION OR AN UPDATE
        if($requestMethod === "PUT" && $idMedia =  $request->get("id")) {
            //TODO : FIX REPOSITORY BUG
           $media =  $this->getDoctrine()->getRepository(Media::class)->find($idMedia);
           var_dump(Media::class);
           die();
           
        }
    
        $form = $this->createForm(MediaFileType::class, $media);

        $data = array_merge( $request->request->all(), ["mediaFile" => $request->files->get("mediaFile")]);
        
        $form->submit( $data  );

        if($form->isValid()) {

            $mediaFile = $form->get("mediaFile")->getData(); 
            
            try 
            {


                if($requestMethod === "POST") {
                    $mediaFileName = $this->fileUploader->upload($mediaFile, $media);
                    $media->setFilename($mediaFileName);    
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($media);
                $em->flush();
                
                
                return new Response("File uploaded with success", HTTP_CREATED);

            } 
            catch (UploadException $e) 
            {

                return new Response($e->getMessage());

            }
            catch(Exception $e) {

                return new Response($e->getMessage(), HTTP_SERVER_ERROR);

            }

        }
        
        return new Response("Bad form : " . $form->getErrors(true), HTTP_BAD_REQUEST);
    }

    // public function updateMedia (Request $request ) {
    //     $media = new Media();
    //     $form = $this->createForm(MediaFileType::class, $media);
    // }



}