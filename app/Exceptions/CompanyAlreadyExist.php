<?php

namespace Spatie\Permission\Exceptions;

use InvalidArgumentException;

class CompanyAlreadyExist extends InvalidArgumentException
{
    public static function named(string $companyName)
    {
        return new static('There is already a company named `{$companyName}`.');
    }
}
