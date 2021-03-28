<?php

namespace SoftDD\ApiException;

use Symfony\Component\HttpKernel\Exception\HttpException;
use function OpenApi\scan;

class ApiException  extends HttpException
{
    public static function build(){
        $openapi = scan(config('softDDDocMaker.apiScanPath',app_path()."/Api"));;
        if (config('softDDDocMaker.docType',"json") == 'yaml') {
            header('Content-Type: application/x-yaml');
            $content = $openapi->toYaml();
        }else{
            header('Content-Type: application/json');
            $content = $openapi->toJson();
        }
        $file = config("softDDDocMaker.docPath",storage_path('docs')."/doc.json");
        $docRoot = dirname($file);
        if (!is_dir($docRoot)){
            mkdir($docRoot,true);
        }
        if (is_dir($docRoot)){
            file_put_contents($file,$content);
        }
        return 0;
    }
}
