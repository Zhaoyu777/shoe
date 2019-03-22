<?php
// +----------------------------------------------------------------------
// | fileName:基类
// +----------------------------------------------------------------------
namespace app\demo\controller;

use think\Response;
use think\Controller;
use think\exception\HttpException;
use think\exception\HttpResponseException;

$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

$allow_origin = array(  
    'http://hlsjy.seevin.com',  
    'http://localhost:8484',
    'http://localhost:8080',
    'http://192.168.1.112:8080', 
);   

if(in_array($origin, $allow_origin)){  
    header('Access-Control-Allow-Credentials:true');
    header('Access-Control-Allow-Origin:'.$origin);
    header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization, Cookie");
    
}

class Base extends Controller
{

	protected $num = '10';

    //构造函数

    public function _initialize()
    {

    }
    /**
     * 前端传递的参数判断
     * 
     */

    protected function checkDataEmpty($data,$checkArr,$checkArrField){

        //判断参数是否为空
        $checkRet=arrayIsEmpty($data,$checkArr);

        //判断参数格式是否错误
        if ($checkRet['isCheck']) {

            $response = Response::create(
                array(
                    'data'=>['name'=>$checkArr[$checkRet['position']]],
                    'code'=>'209',
                    'msg'=>$checkArrField[$checkRet['position']].'填入不能为空'
                ), 
                'json'
            );
            throw new HttpResponseException($response);
        }
    }

}
