<?php

namespace App\Service\Serializer;

use Symfony\Component\Serializer\Serializer;

interface ISerializerFactory {
    public function create() : Serializer;
}