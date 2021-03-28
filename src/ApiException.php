<?php

namespace SoftDD\ApiException;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use function OpenApi\scan;

class ApiException  extends HttpException
{
    /**
     * ApiException constructor.
     * @param $error array 结构为：
     * [
     * 'code'=>110,
     * 'msg'=>'msg',
     * 'httpCode'=>400,
     * 'headers'=>[]
     * ]
     * @param string $msg
     * @param array $detail
     * @param null $previous
     */
    protected $detail;
    public function __construct($error, $msg='',$detail=[],$previous=null)
    {
        $msg = $msg?:$error['msg'];
        $this->detail = $detail;
        parent::__construct($error['httpCode'], $msg, $previous, $error['headers'], $error['code']);
    }
    public function render(Request $request): ?JsonResponse
    {
        if ($request->expectsJson()){
            $body = [
                'code'=>$this->getCode(),
                'msg'=>$this->getMessage()
            ];
            if ($this->detail){
                $body['detail'] = $this->detail;
            }
            return new JsonResponse(
                [
                    'status'=>0,
                    'data'=>$body
                ],
                $this->getStatusCode() ,
                $this->getHeaders(),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            );
        }
        return null;
    }
}
