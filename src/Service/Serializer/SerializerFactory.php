<?php

namespace App\Service\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializerFactory implements ISerializerFactory {

    /**
     * For creating serializer
     * 
     * @return Serializer
     */
    public function create() : Serializer
    {
        $encoders = [ new XmlEncoder(), new JsonEncoder()];
        $normalizer = [ new ObjectNormalizer()];
        
        return new Serializer($normalizer, $encoders);
    }

}