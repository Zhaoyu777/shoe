<?php
namespace app\demo\controller;

use think\Request;
use app\demo\controller\GeneralController;
//use app\demo\controller\Base;

class Test extends GeneralController
{
	public function getModel()
	{
		return model('Material');
	}
}