<?php

namespace App\Service\Serializer;

use App\Entity\Session;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SessionNormalizer implements ContextAwareNormalizerInterface {

    
    private $normalizer;
    private $mediaDirUrl;
    private $hostname = "";
    private $protocol = "";

    public function __construct( ObjectNormalizer $normalizer, string $mediaDirUrl, $hostname, $protocol )
    {
       
        $this->hostname = $hostname;
        $this->protocol = $protocol;
        $this->normalizer = $normalizer;
        $this->mediaDirUrl = $mediaDirUrl;
    }

    public function normalize($session, string $format = null, array $context = [])
    {

        $this->normalizer->setSerializer(new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]));

        $serializeContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($obj, $fomat, $context) {
                return $obj->getTitle();
            }
        ];

        $data = $this->normalizer->normalize($session, $format, $serializeContext);
      
        $data["mediaUrl"] = $this->protocol . "://" . $this->hostname .  $this->mediaDirUrl . $data["filename"];

        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Session;
    }

    

}