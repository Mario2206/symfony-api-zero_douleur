<?php 

namespace App\EventSubscriber;

use App\Http\ApiResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface {


    public function onKernelException(ExceptionEvent $event) {

        $exception = $event->getThrowable();
    
        $res = $this->createApiResponse($exception);
        $event->setResponse($res);
       
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => "onKernelException"
        ];
    }

    private function createApiResponse(\Exception $exception) {
        $statusCode = $exception instanceof HttpException ? $exception->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
        $errors = [$exception->getMessage()];

        return new ApiResponse($exception->getMessage(), null, $errors, $statusCode);
    }


    

}