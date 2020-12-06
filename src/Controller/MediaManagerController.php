<?php 
namespace App\Controller;

use App\Entity\Media;
use App\Form\MediaFileType;
use App\Service\FileUploader;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MediaManagerController extends AbstractController {
    

    private $fileUploader;


    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
        
        
    }

    /**
     * @Route("/api/auth/upload", name="app_upload", methods={"POST"} )
     */
    public function uploadMedia( Request $request) {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $mediaFileName = "";

        try 
        {
            $media = new Media();
        
            $form = $this->createForm(MediaFileType::class, $media);
   
            $data = array_merge( $request->request->all(), ["mediaFile" => $request->files->get("mediaFile")]);
            
            $form->submit( $data );
            
            if(!$form->isValid()) {
                throw new InvalidTypeException($form->getErrors(true));
            }

            $mediaFile = $form->get("mediaFile")->getData(); 
        
            $mediaFileName = $this->fileUploader->upload($mediaFile);
            $media->setFilename($mediaFileName);  

            $em = $this->getDoctrine()->getManager();
            
            $em->persist($media);
            $em->flush();
            
            
            return new Response("File uploaded with success", HTTP_CREATED);

        }
        catch (UploadException $e) 
        {

            return new Response($e->getMessage(), HTTP_SERVER_ERROR);

        }
        catch(InvalidTypeException $e) 
        {
            return new Response( $e, HTTP_BAD_REQUEST);
        }
        catch(Exception $e) 
        {

            $this->fileUploader->deleteFile($mediaFileName);

            return new Response($e->getMessage(), HTTP_SERVER_ERROR);

        }
        
        
    }

    /**
     * @Route("/api/auth/upload/{mediaId}", name="app_upload_put", methods={"POST"})
     */
    public function updateMedia ($mediaId, Request $request, ValidatorInterface $validator) {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        try 
        {
            $data = array_merge( $request->request->all(), ["mediaFile" => $request->files->get("mediaFile")]);

            $media =  $this->getDoctrine()->getRepository(Media::class)->find($mediaId);

            if(!$media) {
                return new Response("The media doesn't already exist", HTTP_NOT_FOUND);
            }

            $form = $this->createForm(MediaFileType::class, $media);

            $form->submit($data);
   
            if(!$form->isValid()) {
                throw new InvalidTypeException($form->getErrors(true));
            }
           
            $mediaFile = $form->get("mediaFile")->getData(); 

            if($mediaFile) {
                $mediaFileName = $this->fileUploader->upload($mediaFile);
                $this->fileUploader->deleteFile($media->getFilename());
                $media->setFilename($mediaFileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return new Response("Successful update", HTTP_SUCCESS);

        } 
        catch(UploadException $e) 
        {
            return new Response($e->getMessage(), HTTP_SERVER_ERROR);
        }
        catch(IOException $e) 
        {
            return new Response($e->getMessage(), HTTP_SERVER_ERROR);
        }
        catch(InvalidTypeException $e) 
        {
            return new Response($e->getMessage(), HTTP_BAD_REQUEST);
        }


    }


}