<?php
namespace app\common\model;

use app\common\model\GeneralModel;

class Material extends GeneralModel
{
	protected $tableName = "material";

    public function declares()
    {
        return array(
            'serializes' => array(),
            'orderbys'   => array('versionCode', 'onlineTime'),
            'timestamps' => array('createTime'),
            'conditions' => array(
                'name' => ['name', ""],
                'type' => ['type', "="],
            )
        );
    }

    public function headerKeys()
    {
        return array('ID', 'partnerID', 'name', 'type', 'count', 'newCount', 'outCount', 'orderID');
    }

    /**
     * example 参数可配置项
     *
     * @param  $name        [参数名称]   必传
     * @param  $isRequired  [是否必填 true|false]   必传
     * @param  $isFixed     [是否不可修改 true|false]   必传
     * @param  $isOnly      [是否唯一值 true|false]   必传
     * @param  $default     [默认参数]   必传
     * @param  $range       [参数范围 数组]   必传
     */
    public function columnsRule()
    {
        return array(
            'ID' => [
                'name' => "编号", 
                'isFixed' => true,
            ],
            'partnerID' => [
                'name' => "供应商ID",
            ],
            'name' => [
                'name' => "材料名称",
            ],
            'type' => [
                'name' => "材料类型",
            ],
            'count' => [
                'name' => "库存",
            ],
            'newCount' => [
                'name' => "入库存",
            ],
            'outCount' => [
                'name' => "出库存",
            ],
            'amount' => [
                'name' => "金额",
            ],
            'orderID' => [
                'name' => "订单ID",
            ],
            'inputUserID' => [
                'name' => "录入人ID",
            ],
            'inputTime' => [
                'name' => "录入时间",
                'default' => date('Y-m-d H:i:s'),
            ],
        );
    }
}