<?php

namespace App\Service\Serializer;

use App\Entity\CustomerFeelings;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class CustomerFeelingsNormalizer implements ContextAwareNormalizerInterface {


    private $normalizer;

    public function __construct( ObjectNormalizer $normalizer )
    {
        $this->normalizer = $normalizer;
    }

    public function normalize($session, string $format = null, array $context = [])
    {

        $this->normalizer->setSerializer(new Serializer([new DateTimeNormalizer()]));

        $data = $this->normalizer->normalize($session, $format, $context);
       
        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof CustomerFeelings;
    }

}