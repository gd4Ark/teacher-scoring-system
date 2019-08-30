<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Throwable;

class ApiException extends \Exception
{
    use ApiResponse;
    protected $message;
    protected $code;

    /**
     * ApiException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = $message;
        $this->code = $code;
    }

    /**
     * report
     */
    public function report()
    {
        // Do something
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        $message = $this->getMessage() ?: 'Server Error';
        return $this->setStatusCode($this->code)->message($message);
    }
}
