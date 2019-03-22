<?php

namespace app\common;

use think\exception\Handle;
use think\exception\HttpException;
use think\exception\ErrorException;
use think\Log;

/**
 * 
 * 报错提示
 * 
 */
class http extends Handle
{

    public function render(\Exception $e){

        if ($e instanceof HttpException) {
            $statusCode = $e->getStatusCode();
        }

        //日志
        //Log::record('错误原因:'.$e->getMessage().',行数:'.$e->getLine().',错误地方:'.$e->getFile(), 'info');
        //Log::record($_POST, 'info');

        //报错
        return json(['data'=>'','code'=>400,'msg'=>$e->getMessage(),'msgInfo'=>'错误原因:'.$e->getMessage().',行数:'.$e->getLine().',错误地方:'.$e->getFile()]);
    }

}

?>