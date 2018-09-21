<?php

namespace App\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

final class UsuarioValidator extends BaseValidator
{
    public function valid($data)
    {
        $errors = [];
        $messages = [
            'nome'  => 'Campo obrigatório.',
            'login' => 'Campo obrigatório.',
            'senha'  => 'Senha não confere com a confirmação.',
        ];

        try {
            v::key('nome', v::stringType()->notEmpty())
                ->key('login', v::stringType()->notEmpty())
                ->key('senha', v::equals($data['confirmar_senha']))
                ->assert($data);
        } catch (NestedValidationException $e) {
            $messagesException = $e->findMessages($messages);
            $errors = $this->createArrayMessage($data, $messagesException);
        }
        
        return $errors;
    }
}
