<?php

namespace App\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

final class PessoaValidator extends BaseValidator
{
    public function valid($data)
    {
        $errors = [];
        $messages = [
            'nome'      => 'Campo obrigatório.',
            'matricula' => 'Campo obrigatório.',
        ];

        try {
            v::key('nome', v::stringType()->notEmpty())
                ->key('matricula', v::stringType()->notEmpty())
                ->assert($data);
        } catch (NestedValidationException $e) {
            $messagesException = $e->findMessages($messages);
            $errors = $this->createArrayMessage($data, $messagesException);
        }
        
        return $errors;
    }
}
