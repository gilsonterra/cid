<?php

namespace App\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

abstract class BaseValidator
{
    public function createArrayMessage(array $data, $messagesException)
    {
        $errors = [];
        if (!empty($messagesException)) {
            foreach ($data as $key => $value) {
                foreach ($messagesException as $k => $v) {
                    if (strpos($k, $key) !== false && !empty($v)) {
                        $errors[$key][] = $v;
                    }
                }
            }
        }

        return $errors;
    }

    protected function _createAndValidateDate($date)
    {
        $dateObject = \DateTime::createFromFormat('d/m/Y', $date);
        if ($dateObject->format('d/m/Y') != $date) {
            $dateObject = null;
        }

        return $dateObject;
    }
}
