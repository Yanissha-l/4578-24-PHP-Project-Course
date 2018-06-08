<?php

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class PhoneValid extends AbstractRule
{
    protected $phone;

    public function validate($input)
    {
        if (!filter_var($input, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/0((\d{1}-)|(\d{2}-))?\d{3}-\d{4}/")))) {
            return false;
        } else {
            return true;
        }

    }
}
