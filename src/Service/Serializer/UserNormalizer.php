<?php

namespace App\Service\Serializer;

use App\Entity\User;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UserNormalizer implements ContextAwareNormalizerInterface {

    private $normalizer;

    public function __construct(ObjectNormalizer $objectNormalizer)
    {
        $this->normalizer = $objectNormalizer;
    }
    
    public function normalize($user, ?string $format = null, array $context = [])
    {
        $dateCallback = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            return $innerObject instanceof \DateTime ? $innerObject->format(\DateTime::ISO8601) : '';
        };

        $defaultContext = [
            AbstractNormalizer::CALLBACKS => [
                'createdAt' => $dateCallback,
            ],
        ];

        $this->normalizer->setSerializer(new Serializer([]));
       

        return $this->normalizer->normalize($user, $format, $defaultContext);
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof User;
    }
}