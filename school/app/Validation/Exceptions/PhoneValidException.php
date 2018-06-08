<?php

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class PhoneValidException extends ValidationException
{
    public static $defaultTemplates = [
     self::MODE_DEFAULT => [
      self::STANDARD =>'Please enter a valid phone number format - (0xx-xxx-xxxx) Or (0x-xxx-xxxx)',
     ],
    ];
}
