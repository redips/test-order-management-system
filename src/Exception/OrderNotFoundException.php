<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class OrderNotFoundException extends \Exception
{
    protected $code = Response::HTTP_NOT_FOUND;
}
