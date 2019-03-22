<?php
namespace app\demo\controller;

use think\Request;
use app\demo\controller\Base;

class GeneralController extends Base
{
    public function get(Request $request)
    {
        $ID = $request->get('ID');

        $culture = $this->getModel()->get($ID);

        return createJsonResponse(array('data' => $culture));
    }

    public function create(Request $request)
    {
        $fields = $request->post();
        $culture = $this->getModel()->createCheck($fields);

        return createJsonResponse(array('data' => $culture));
    }

    public function update(Request $request)
    {
        $fields = $request->post();
        $culture = $this->getModel()->updateCheck($fields, $fields['ID']);

        return createJsonResponse(array('data' => $culture));
    }

    public function search(Request $request)
    {
        //获取信息
        $page = $request->get('page', '1');
        $limit = $request->get('num', '10');

        $search = $request->get();
        $order = isset($search['order']) ? $search['order'] : ['ID' => 'asc'];
        $conditions = isset($search['search']) ? $search['search'] : array();
        $conditions = array_filter($conditions);

        $versions = $this->getModel()->search($conditions, $order, $page, $limit);
        $total = $this->getModel()->countByCondition($conditions);

        $result = array(
            'draw'            => $request->get('draw'),
            'recordsTotal'    => $this->getModel()->count(),
            'recordsFiltered' => $total,
            'conditions'      => $search,
            'data'            => $versions,
        );

        return createJsonResponse($result);
    }

    public function delete(Request $request)
    {
        $ID = $request->post('ID');
    	if (empty($ID)) {
    		return ['code' => 209, 'msg' => '必要参数缺失'];
    	}
        $where = array('ID' => $ID);
    	$this->getModel()->deleteByCondition($where);

    	return createJsonResponse(['data' => true]);
    }

    public function header(Request $request)
    {
        $result = $this->getModel()->header();

        return createJsonResponse(['data' => $result]);
    }
}