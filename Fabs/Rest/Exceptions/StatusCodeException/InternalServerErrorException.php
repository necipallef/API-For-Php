<?php


namespace Fabs\Rest\Exceptions\StatusCodeException;


use Fabs\Rest\Constants\HttpStatusCodes;
use Fabs\Rest\Exceptions\StatusCodeException;

class InternalServerErrorException extends StatusCodeException
{
    /**
     * InternalServerErrorException constructor.
     * @param mixed $error_details
     */
    public function __construct($error_details = null)
    {
        parent::__construct(500, HttpStatusCodes::INTERNAL_SERVER_ERROR, $error_details);
    }
}