<?php

namespace App\Helpers;
use Illuminate\Http\JsonResponse;
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
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param $data
     * @param array $header
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data,$header = [])
    {
        return new JsonResponse($data,$this->getStatusCode(),$header);
    }

    /**
     * @param $status
     * @param array $data
     * @param null $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function status($status, array $data, $code = null)
    {
        if ($code)
            $this->setStatusCode($code);
        $status = [
            'status' => $status,
            'code' => $this->statusCode
        ];
        $data = array_merge($status,$data);
        return $this->respond($data);
    }

    /**
     * @param string $message
     * @param int $code
     * @param string $status
     * @return JsonResponse
     */
    public function failed($message = '', $code = FoundationResponse::HTTP_BAD_REQUEST, $status = 'error')
    {
        return $this->setStatusCode($code)->message($message,$status);
    }

    /**
     * @param string $message
     * @param string $status
     * @return JsonResponse
     */
    public function message($message = '',$status = 'success')
    {
        return $this->status($status,[
            'message' => $message
        ]);
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function internalError($message = "Internal Error!")
    {
        return $this->failed($message,FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function created($message = "created")
    {
        return $this->setStatusCode(FoundationResponse::HTTP_CREATED)
            ->message($message);
    }

    /**
     * @param array $data
     * @param string $status
     * @return JsonResponse
     */
    public function success($data = [],$status = 'success')
    {
        return $this->status($status,compact('data'));
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function notFond($message = "Not Fond")
    {
        return $this->failed($message,FoundationResponse::HTTP_NOT_FOUND);
    }
}