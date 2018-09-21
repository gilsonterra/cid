<?php

namespace App\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

final class LoginValidator extends BaseValidator
{
    public function valid(array $data)
    {
        $errors = [];
        $messages = [
            'login'      => 'Campo obrigatório.',
            'senha'      => 'Campo obrigatório.',
        ];

        try {
            v::key('login', v::stringType()->notEmpty())
                 ->key('senha', v::stringType()->notEmpty())
                 ->assert($data);
        } catch (NestedValidationException $e) {
            $messagesException = $e->findMessages($messages);
            $errors = $this->createArrayMessage($data, $messagesException);
        }        
        
        return $errors;
    }
}
