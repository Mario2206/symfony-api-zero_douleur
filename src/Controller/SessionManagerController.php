<?php 
namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\CustomerFeelingsRepository;
use App\Repository\SessionRepository;
use App\Service\FileUploader;
use App\Service\Serializer\FormErrorSerializer;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;


class SessionManagerController extends AbstractController {
    

    private $fileUploader;
    private $formErrorSerializer;


    public function __construct(FileUploader $fileUploader, FormErrorSerializer $formErrorSerializer)
    {
        $this->fileUploader = $fileUploader;
        $this->formErrorSerializer = $formErrorSerializer;
  
    }

    /**
     * 
     * @Route("/api/admin/session", name="app_upload_create", methods={"POST"} )
     */
    public function createSession( Request $request) {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $mediaFileName = "";

        try 
        {
            $media = new Session();
        
            $form = $this->createForm(SessionType::class, $media);
   
            $data = array_merge( $request->request->all(), ["mediaFile" => $request->files->get("mediaFile")]);
            
            $form->submit( $data );
            
            if(!$form->isValid()) {
                return new JsonResponse ($this->formErrorSerializer->serializeToJson($form->getErrors(true)));
            }

            $mediaFile = $form->get("mediaFile")->getData(); 
        
            $mediaFileName = $this->fileUploader->upload($mediaFile);
            $media->setFilename($mediaFileName);  

            $em = $this->getDoctrine()->getManager();
            
            $em->persist($media);
            $em->flush();
            
            
            return new JsonResponse(["message" => "File uploaded with success"], HTTP_CREATED);

        }
        catch (UploadException $e) 
        {

            return new JsonResponse($e->getMessage(), HTTP_SERVER_ERROR);

        }
        catch(Exception $e) 
        {

            $this->fileUploader->deleteFile($mediaFileName);

            return new JsonResponse($e->getMessage(), HTTP_SERVER_ERROR);

        }
        
        
    }

    /**
     * @Route("/api/admin/session/{sessionId}", name="app_upload_update", methods={"POST"})
     */
    public function updateSession ($sessionId, Request $request) {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        try 
        {
            $data = array_merge( $request->request->all(), ["mediaFile" => $request->files->get("mediaFile")]);

            $media =  $this->getDoctrine()->getRepository(Session::class)->find($sessionId);

            if(!$media) {
                return new JsonResponse("The media doesn't already exist", HTTP_NOT_FOUND);
            }

            $form = $this->createForm(SessionType::class, $media);

            $form->submit($data);
   
            if(!$form->isValid()) {
                $err = $this->formErrorSerializer->serializeToJson($form->getErrors(true));
                return new JsonResponse( $err , HTTP_BAD_REQUEST);
            }
           
            $mediaFile = $form->get("mediaFile")->getData(); 

            if($mediaFile) {
                $mediaFileName = $this->fileUploader->upload($mediaFile);
                $this->fileUploader->deleteFile($media->getFilename());
                $media->setFilename($mediaFileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return new JsonResponse(["message" => "Successful update"], HTTP_SUCCESS);

        } 
        catch(UploadException $e) 
        {
            return new JsonResponse($e->getMessage(), HTTP_SERVER_ERROR);
        }
        catch(IOException $e) 
        {
            return new JsonResponse($e->getMessage(), HTTP_SERVER_ERROR);
        }


    }

    /**
     * @Route("/api/admin/session/{sessionId}", name="app_upload_delete", methods={"DELETE"})
     */
    public function deleteSession($sessionId, FileUploader $fileUploader, SessionRepository $sessionRepository, CustomerFeelingsRepository $customerFeelingsRepository) {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        try {

            $em = $this->getDoctrine()->getManager();

            $session = $em->find(Session::class, $sessionId );

            if(!$session) {
                return new JsonResponse("The session doesn't exist", \HTTP_BAD_REQUEST);
            }
        
            $fileUploader->deleteFile($session->getFilename());

            $sessionRepository->remove($sessionId);

            $customerFeelingsRepository->removeManyRowAccordingToSession($sessionId);


            return new JsonResponse(["message" => "Session has been removed"], HTTP_SUCCESS);

        } catch( IOException $e) {

            return new JsonResponse($e->getMessage());

        }


    }

    


}