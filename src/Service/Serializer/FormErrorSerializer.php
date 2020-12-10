<?php

namespace App\Service\Serializer;

use Symfony\Component\Form\FormErrorIterator;

class FormErrorSerializer {

    public function serializeToJson(FormErrorIterator $formError) {

        $errors = [];

        while($formError->valid()) {

            $errors[] = $formError->current()->getMessage();
            $formError->next();

        }

        
        return json_encode(["error" => $errors]);

    }

}