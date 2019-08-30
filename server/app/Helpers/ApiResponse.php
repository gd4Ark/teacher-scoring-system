<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

trait ApiResponse
{
    /**
     * @var int
     */
    protected $statusCode = FoundationResponse::HTTP_OK;

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param  $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param  $data
     * @param array $header
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $header = [])
    {
        return Response::json($data, $this->getStatusCode(), $header);
    }

    /**
     * @param  $status
     * @param array $data
     * @param null $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function status($status, array $data, $code = null)
    {
        if ($code) {
            $this->setStatusCode($code);
        }
        $status = [
            'status' => $status,
            'code' => $this->statusCode
        ];
        $data = array_merge($status, $data);
        return $this->respond($data);
    }

    /**
     * 200
     *
     * @param  $message
     * @param string $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function message($message, $status = 'success')
    {
        return $this->status(
            $status,
            [
                'message' => $message
            ]
        );
    }

    /**
     * 400
     *
     * @param  $message
     * @param int $code
     * @param string $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function failed($message, $code = FoundationResponse::HTTP_BAD_REQUEST, $status = 'error')
    {
        return $this->setStatusCode($code)->message($message, $status);
    }

    /**
     * 500
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function internalError($message = "Internal Error!")
    {
        return $this->failed($message, FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * 200
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function created($message = 'created')
    {
        return $this->setStatusCode(FoundationResponse::HTTP_CREATED)->message($message);
    }

    /**
     * 200
     *
     * @param  $data
     * @param string $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data, $status = 'success')
    {
        return $this->status($status, compact('data'));
    }

    /**
     * 404
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function notFound($message = "Not Fond")
    {
        return $this->failed($message, FoundationResponse::HTTP_NOT_FOUND);
    }

    /**
     * 401
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function unauthorized($message = "Unauthorized")
    {
        return $this->failed($message, FoundationResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * 403
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function forbidden($message = 'Forbidden')
    {
        return $this->failed($message, FoundationResponse::HTTP_FORBIDDEN);
    }
}
