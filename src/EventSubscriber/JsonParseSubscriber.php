<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class JsonParseSubscriber implements EventSubscriberInterface {


    public function onControllerEventRequest(ControllerEvent $event) {
        
        $req = $event->getRequest();

        if($req->getContentType() !== "json" || !$req->getContent() ) {
            return ;
        }

        $jsonParse = json_decode($req->getContent(), true);

        if(json_last_error() !== JSON_ERROR_NONE) {
            throw new HttpException("Invalid json body : " . json_last_error_msg() );
        }

        $req->request->replace(is_array($jsonParse) ? $jsonParse : []);
        
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => "onControllerEventRequest"
        ];
    }


}