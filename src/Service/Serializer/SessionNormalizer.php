<?php

namespace App\Service\Serializer;

use App\Entity\Session;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SessionNormalizer implements ContextAwareNormalizerInterface {

    
    private $normalizer;
    private $mediaDirUrl;

    public function __construct( ObjectNormalizer $normalizer, string $mediaDirUrl )
    {

        $this->normalizer = $normalizer;
        $this->mediaDirUrl = $mediaDirUrl;
    }

    public function normalize($session, string $format = null, array $context = [])
    {

        $this->normalizer->setSerializer(new Serializer([new DateTimeNormalizer()]));

        $data = $this->normalizer->normalize($session, $format, $context);
       
        $data["mediaUrl"] = $this->mediaDirUrl . $data["filename"];

        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Session;
    }

}