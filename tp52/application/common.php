<?php

// +----------------------------------------------------------------------
// | fileName:公共方法
// +----------------------------------------------------------------------
// | time:2018-06-01
// +----------------------------------------------------------------------
// | Author: kuangxi(774921903@qq.com)
// +----------------------------------------------------------------------

// 应用公共文件



	/**
	 * 随机字符串生成
	 *
	 * @param [string] $forNum [长度]
	 *
	 * @return [string] 随机生成的编码
	 */

	function randomNumStr($forNum =  4)
	{
		//用来存放生成的随机字符串 
		$randNum = '';    

		//随机字符串
		$str = '0123456789'; 

		//生成随机码
		for($i = 0; $i < $forNum; $i++ ){ 
			$rndcode   = rand(0,9); 
			$randNum  .= $str[$rndcode]; 
		}

		return $randNum;
	}

	/**
	 * 随机字符串生成
	 *
	 * @param [string] $type [类型]
	 *
	 * @return [string] 随机生成的编码
	 */

	function randomCreateID($type){

		//用来存放生成的随机字符串 
		$randNum = '';    

		//随机字符串
		$str = '0123456789'; 

		//区分8位还是4位随机
		$numArr = ['roleID','managerID','teacherID','subjectID','categoryID'];

		if ( in_array($type, $numArr) ) {
			$forNum = 4;
		}else{
			$forNum = 8;
		}

		//生成随机码
		for($i = 0; $i < $forNum; $i++ ){ 
			$rndcode   = rand(0,9); 
			$randNum  .= $str[$rndcode]; 
		} 

		//编码
		$createID = '';

		switch ($type) {

			case 'prodID':
				$createID = 'P'.date('Ym',time()).$randNum;
				break;
			case 'documentID':
				$createID = 'D'.date('Ym',time()).$randNum;
				break;
			case 'docAttachID':
				$createID =  date('Ymd',time()).$randNum;
				break;
			case 'teacherID':
				$createID = 'T'.date('Y',time()).$randNum;
				break;	
			case 'subjectID':
				$createID = 'D'.date('Y',time()).$randNum;
				break;	
			case 'orderID':
				$createID = 'O'.time().$randNum;
				break;	
			case 'refundID':
				$createID = 'R'.time().$randNum;
				break;	
			case 'studentID':
				$createID = 'S'.date('Ym',time()).$randNum;
				break;	
			case 'managerID':
				$createID = 'M'.date('Y',time()).$randNum;
				break;	
			case 'roleID':
				$createID = 'R'.date('Y',time()).$randNum;
				break;	
			case 'categoryID':
				$createID = 'C'.date('Y',time()).$randNum;
				break;	
			case 'couponID':
				$createID = 'C'.date('Y',time()).$randNum;
				break;
			case 'questionID':
				$createID = 'Q'.date('Y',time()).$randNum;
				break;	
		}

		return $createID;

	}


	/**
	 * 随机字符串
	 *
	 * @return [string] 随机生成的编码
	 */

	function randomNum($forNum =  8){

		//用来存放生成的随机字符串 
		$randNum = '';    

		//随机字符串
		$str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 

		//生成随机码
		for($i = 0; $i < $forNum; $i++ ){ 
			$rndcode   = mt_rand(0,61); 
			$randNum  .= $str[$rndcode]; 
		} 

		return $randNum;

	}




	/**
	 * Datatables
	 * 筛选排序条件
	 *
	 * @param [array] $data       [排序数组]
	 * @param [array] $orderField [列数组]
	 *
	 * @return [array] 排序数组
	 * 
	 */
	function filterOrder($data,$orderField)
	{
		//排序
        $order=[];

        foreach ($data as $k => $v) {
            if (in_array($k, $orderField) && !empty($v)) {
                $order[$k] = $v; 
            }
        }

        return $order;

	}


	/**
	 * Datatables
	 * 筛选条件字段
	 * 从前端传的参数中筛选过滤需要的条件字段
	 * 
	 * @param  [array] $data       [参数]
	 * @param  [array] $whereField [目标字段]
	 * 
	 * @return [array] 条件数组
	 */
	function filterWhere($data, $whereField)
	{

		//存放条件
		$where = array();

        foreach ($data as $k => $v) {
            if (in_array($k, $whereField) && !empty($v)) {
                if (is_array($v)) {
                	$where[$k] = array('in',$v);
                }else{
                	$where[$k] = $v; 
                }
            }
        }

        return $where;

	}


	/**
	 * 分页
	 * 
	 * @param  [string] $page         [页码]
	 * @param  [string] $num          [每页数量]
	 * @param  [string] $last_page    [最大页码]
	 * @param  [int]    $total        [总数]
	 * 
	 * @return [array]
	 */
	function pageToNum($page, $num, $last_page, $total)
	{

		$arr=[];

        $arr['firstPage'] = ($page == 1) ? 'true' : 'false' ;
        $arr['lastPage']  = ($page >= $last_page ) ? 'true' : 'false' ;
        $arr['limit']     = $num;
        $arr['page']      = $page;
        $arr['total']     = (string)$total;

        return $arr;

	}




    /**
    * 检查数组有无空值
    * 
    * @param  [array] $data  需要检查的数组
    * @param  [array] $arr   检查标准数组
    *
    * @return [boolean]
    * 
    */
    function arrayIsEmpty($data, $arr)
    {

    	//存放一维数组
        $newdata = array();

        //二维数组化为一维数组
        foreach ($data as $k => $v) {
            $newdata[] = $k;
        }

        //检查是否存在并且是否为空
        foreach ($arr as $k => $v) { 

            if (!in_array($v, $newdata) || $data[$v] == null || $data[$v] == '' ) {
               return array('isCheck' => true, 'position' => $k);
            }

        }
        
        return array('isCheck' => false, 'position' => '');

    }




	/**
	 * 测试打印
	 *
	 * @param  [mixed] $data [打印的数组或者字符串]
	 *
	 * @return [void]
	 * 
	 */

	function test($data)
	{

		//判断是否数组
		var_dump($data);

		//中止
		die();

	}


	
	/**
	 * 打印日志
	 * 
	 * @param  [array]   $array [数组]
	 * @param  [string]  $ps    [额外命名,默认为空]
	 *
	 * @return [void]
	 * 
	 */
	function echoFile($array, $ps = '')
	{
		
		/*打印数组存储在本地查看*/
		$test_data      = $array;//获取需要打印的数组或者字符串
		$str            = var_export($test_data , true);//与var_dump类似

		//实例化
		$request        = \think\Request::instance();

		//获取控制器和方法名称
		$controllerName = $request->controller();
		$actionName     = $request->action();

	    if ($ps == '') {
	    	$addres = 'C:/testfile/'.$controllerName.'-'.$actionName.'-'.date('H.i.s',time()).'.txt';//打印出来的文件命名
	    }else{
	    	$addres = 'C:/testfile/'.$controllerName.'-'.$actionName.'-'.date('H.i.s',time()).'-'.$ps.'.txt';//打印出来的文件命名
	    }
	    
	    //执行
	    file_put_contents($addres,$str);

	}


	/**
	 * 移除指定字段以外的参数
	 *
	 * @param  [array]  $field [指定地址]
	 * @param  [array]  $data  [需要筛选的数组]
	 *
	 * @return [array]
	 * 
	 */
	function unsetDesign($field,$data)
	{
		if ( !empty($field) && !empty($data) ) {
			if ( is_array($field) && is_array($data) ) {

				foreach ($data as $k => $v) {
					if (!in_array($k, $field)) {
						unset($v);
					}
				}
				
				$data = array_values($data);

				return $data;
			}
		}
	}


	/**
	 * 检查是否存在以及是否为空
	 * 
	 */
	function setNotEmpty($data)
	{
		if (isset($data)) {
			if (!empty($data)) {
				return $data;
			}
		}

		return false;
	}


	/**
	 * 模拟请求
	 * @param  [type]  $url    [description]
	 * @param  [type]  $params [description]
	 * @param  string  $method [description]
	 * @param  array   $header [description]
	 * @param  boolean $multi  [description]
	 * @return [type]          [description]
	 */
    function http($url, $params, $method = 'GET', $header = array(), $multi = false){  
	    $opts = array(  
	            CURLOPT_TIMEOUT        => 30,  
	            CURLOPT_RETURNTRANSFER => 1,  
	            CURLOPT_SSL_VERIFYPEER => false,  
	            CURLOPT_SSL_VERIFYHOST => false,  
	            CURLOPT_HTTPHEADER     => $header  
	    );  
	    /* 根据请求类型设置特定参数 */  
	    switch(strtoupper($method)){  
	        case 'GET':  
	            $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);  
	            break;  
	        case 'POST':  
	            //判断是否传输文件  
	            $params = $multi ? $params : http_build_query($params);  
	            $opts[CURLOPT_URL] = $url;  
	            $opts[CURLOPT_POST] = 1;  
	            $opts[CURLOPT_POSTFIELDS] = $params;  
	            break;  
	        default:  
	            throw new Exception('不支持的请求方式！');  
	    }  
	    /* 初始化并执行curl请求 */  
	    $ch = curl_init();  
	    curl_setopt_array($ch, $opts);  
	    $data  = curl_exec($ch);  
	    $error = curl_error($ch);  
	    curl_close($ch);  
	    if($error) throw new Exception('请求发生错误：' . $error);  
	    return  $data;  
	} 




	/**
	 * 数组变成模糊查询数组
	 * 
	 */
	function likeArr($data)
	{

		$arr = [];

        foreach ($data as $k => $v) {
            $arr[] = '%'.$v.'%'; 
        }

        return $arr;
	}

	/**
	 * 阿里云OSS用到的方法
	 * 
	 */
	function gmt_iso8601($time)
	{
	    $dtStr = date("c", $time);
	    $mydatetime = new DateTime($dtStr);
	    $expiration = $mydatetime->format(DateTime::ISO8601);
	    $pos = strpos($expiration, '+');
	    $expiration = substr($expiration, 0, $pos);
	    return $expiration . "Z";
	}



	/**
	 * base64编码
	 * 
	 */
	function base64urlEncode($data) { 
	  return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
	} 

	/**
	 * base64解码
	 * 
	 */
	function base64urlDecode($data) { 
	  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
	}


	/**
	 * 二维数组去重
	 * $arr 数组
	 * $key 键值
	 */

    function arrayUnsetRe($arr,$key){     
        //建立一个目标数组  
        $res = array();        
        foreach ($arr as $value) {           
            //查看有没有重复项  

            if(isset($res[$value[$key]])){  
            //有：销毁  

                unset($value[$key]);  

            }  
            else{  

                $res[$value[$key]] = $value;  
            }  
  
        }  
        return $res;  
    } 


    /**
     * 打印最后一条执行的sql语句
     * 
     */
    function testsql()
    {
		$Db = new think\Db;
    	test($Db::getlastsql());
    }


    /**
     * 转化数组
     * 
     */
    function testarray($data)
    {
		
    	test(collection($data)->toArray());
    }


    function getDays($date1, $date2)
    {
    $time1 = strtotime($date1);
    $time2 = (!empty($date2)) ? strtotime($date2) : 0;

    $ret = ($time1-$time2)/86400;
    return intval($ret);
    }

    /**
     * 错误信息弹出json
     * 
     */
    function createExceptionResponse($message = '系统异常', $code = 500)
    {
        throw new \think\exception\HttpException($code, $message);
    }

    /**
     * json格式数据返回
     * 
     */
    function createJsonResponse($data = null, $status = 200, $message = '')
    {
        $result = [
            'code' => $status,
            'msg' => getMessage($status, $message),
        ];

        return json(array_merge($data, $result));
    }

    function getMessage($status = 200, $message = '')
    {
        if (!empty($message)) {
            return $message;
        }

        $msgs = array(
            '200' => '请求成功', 
            '201' => '请求查询不到信息',
            '202' => '请求修改失败',
            '208' => '请求参数格式错误',
            '209' => '请求参数为缺失',
            '303' => '请求方式错误',
            '305' => '请求地址错误,不存在此地址',
            '400' => '语法错误',
            '401' => '未登录',
            '403' => '禁止访问',
            '404' => '找不到该文件或资源'
        );

        $msg = "外星错误，请联系管理员";

        if (array_key_exists($status, $msgs)) {
            $msg = $msgs[$status];
        }

        return $msg;
    }



    function parents_children($mkey, $ret, $pid = 0, $pkey='parentID', $listName='list') {

        $list = array();

        foreach ($ret as $row) {
            if ($row[$pkey] == $pid ) {

                $list[$row[$mkey]] = $row;

                $children = parents_children($mkey,$ret, $row[$mkey],$pkey,$listName);

                $children =!empty($children) ? $children : array() ;

                $children && $list[$row[$mkey]][$listName] = array_merge($children);

            }
        }

        return array_merge($list);
    }

	function isMobile1() {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
            return true;
        
        //此条摘自TPM智能切换模板引擎，适合TPM开发
        if(isset ($_SERVER['HTTP_CLIENT']) &&'PhoneClient'==$_SERVER['HTTP_CLIENT'])
            return true;
        //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']))
            //找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
        //判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array(
                'nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile'
            );
            //从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        //协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }


