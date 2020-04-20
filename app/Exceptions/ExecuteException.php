<?php
/**
 * Created by PhpStorm.
 * User: hoang
 * Date: 12/31/19
 * Time: 10:54 AM
 */

namespace App\Exceptions;

use Exception;
use Throwable;

class ExecuteException extends Exception
{
    public function __construct($message = "", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
