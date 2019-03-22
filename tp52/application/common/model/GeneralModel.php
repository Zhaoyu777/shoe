<?php

namespace app\common\model;

use think\Model;
use think\Db;
/**
 *
 * 公共模型
 * 
 */

class GeneralModel extends Model
{
    protected $tableName = null;

    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     *
     * 条件查询列表信息
     *
     * @param $conditions [查询条件]
     * @param $order      [条件排序]
     * @param $page       [查询页码]
     * @param $limit      [查询条数]
     *
     */

    public function searchBase($conditions, $order = array(), $page = 1, $limit = 10, $field = array())
    {

      $this->checkOrder($order);

    	return Db::table($this->getTableName())
			->where($conditions['and'])
            ->where(function ($query) use($conditions) { 
                $query->whereOr($conditions['or']);
            })
            ->field($field)
		    ->order($order)
		    ->page($page, $limit)
		    ->select();
    }

    public function checkOrder($order)
    {
      if (empty($order)) {
        return true;
      }

      if (!function_exists("declares")) {
        return true;
      }

      $columns = $this->declares();
      $orderbys = $columns['orderbys'];
      foreach ($order as $coumn => $cdn) {
          if (!in_array($coumn, $orderbys)) {
              throw new \think\exception\HttpException(209, '排序条件有误');
          }
      }

      return $order;
    }

    public function searchBaseCount($conditions)
    {
        return Db::table($this->getTableName())
        			->where($conditions['and'])
        			->where(function ($query) use($conditions) { 
                        $query->whereOr($conditions['or']);
                    })
                    ->count();
    }

    /**
     *判断是否重复
     *@param $conditions   [[查询列, 查询条件, 查询值], ...]
     *
     */

    public function isRepeatByConditions($conditions)
    {
    	$table = Db::table($this->getTableName());
        foreach ($conditions as $condition) {
            $table->where($condition[0], $condition[1], $condition[2]);
        }
        $check = $table->select();

        if (!empty($check)) {
            return true;
        }

        return false;
    }

    public function checkColumns($fields)
    {
        $data = array();
        $columns = $this->columnsRule();
        foreach ($columns as $name => $column) {
            if (!empty($column['isRequired']) && $column['isRequired']) {
                if (empty($fields[$name])) {
                  throw new \think\exception\HttpException(209, $column['name'].'为空');
                  // $this->error = $column['name'].'为空';
                  // return false;
                }
            }

            if (!empty($column['default'])) {
                if (empty($fields[$name])) {
                    $data[$name] = $column['default'];
                }
            }

            if (!empty($fields[$name])) {
                if (is_string($fields[$name]) && !empty($column['range']) && !in_array($fields[$name], $column['range'])) {
                    throw new \think\exception\HttpException(209, $column['name'].'值有误');
                  // $this->error = $column['name'].'值有误';
                  // return false;
                }
                if (!empty($column['isOnly']) && $column['isOnly']) {
                    $count = $this->where($name, $fields[$name])->count();
                    if ($count > 0) {
                        throw new \think\exception\HttpException(209, $column['name'].'值已存在');
                        // $this->error = $column['name'].'值已存在';
                        // return false;
                    }
                }

                $data[$name] = $fields[$name];
            }
        }

        return $data;
    }

    public function checkUpdateColumns($fields)
    {
        $data = array();
        $columnsRule = $this->columnsRule();
        foreach ($fields as $columnKey => $columnValue) {
            if (empty($columnsRule[$columnKey])) {
                continue ;
            }
            $columnRule = $columnsRule[$columnKey];
            if (!empty($columnRule['isFixed']) && $columnRule['isFixed']) {
                continue ;
            }

            if (is_array($columnValue)) {
                foreach ($columnValue as $value) {
                    if (!empty($value) && !empty($columnRule['range']) && !in_array($value, $columnRule['range'])) {
                        throw new \think\exception\HttpException(209, $columnsRule[$columnKey]['name'].'值有误');
                      // $this->error = $columnsRule[$columnKey]['name'].'值有误';
                      // return false;
                    }
                }
            } else {
                if (!empty($columnValue) && !empty($columnRule['range']) && !in_array($columnValue, $columnRule['range'])) {
                    throw new \think\exception\HttpException(209, $columnsRule[$columnKey]['name'].'值有误');
                    // $this->error = $columnsRule[$columnKey]['name'].'值有误';
                    // return false;
                }
            }

            $data[$columnKey] = $columnValue;
        }

        return $data;
    }

    protected function createResourceException($msg, $code)
    {
        throw new \think\exception\HttpException($code, $msg);
    }

    public function createCheck($fields)
    {
        $fields = $this->checkColumns($fields);
        return $this->insertGetId($fields);
    }

    public function updateCheck($fields, $ID)
    {
        $data = $this->get($ID);
        if (empty($data)) {
            throw new \think\exception\HttpException(209, '数据为空');
        }

        $fields = $this->checkUpdateColumns($fields);
        $data = array('ID' => $ID);
        foreach ($fields as $column => $field) {
            $data[$column] = $field;
        }

        return $this->save($data, true);
    }

    public function deleteByCondition($condition)
    {
      return $this->where($condition)->delete();
    }

    public function search($conditions, $order, $page, $limit)
    {
        $where = $this->getSearchWhere($conditions);
        $versions = $this->searchBase($where, $order, $page, $limit);

        return $versions;
    }

    public function countByCondition($conditions)
    {
        $where = $this->getSearchWhere($conditions);
        $count = $this->searchBaseCount($where);

        return $count;
    }

    public function getSearchWhere($conditions)
    {
        $where = array('and' => array(), 'or' => array());
        if (empty($conditions)) {
            return $where;
        }

        $declares = $this->declares();
        if (!empty($declares) || !empty($declares['conditions'])) {
            $conditionRules = $declares['conditions'];
            foreach ($conditions as $column => $value) {
                if (!empty($conditionRules[$column])) {
                    $conditionRule = $conditionRules[$column];
                    $where['and'][$conditionRule[0]] =  [$conditionRule[1], $value];
                }
            }
        }

        return $where;
    }

    //获取header函数
    public function header()
    {
        $number = 1;
        $header = array();
        $columns = $this->columnsRule();
        $headerKeys = $this->headerKeys();
        foreach ($headerKeys as $ID => $headerKey) {
            $columnKey = is_array($headerKey) ? $ID : $headerKey;
            if (!empty($columns[$columnKey])) {
                $column = $columns[$columnKey];
                $template = array(
                    'ID' => $number++,
                    'name' => $column['name'],
                    'key' => $columnKey,
                    'orderable' => false,
                    'searchable' => false
                );
            }

            if (is_array($headerKey)) {
                if (empty($template)) {
                    $template = $headerKey;
                } else {
                    foreach ($headerKey as $headerColumn => $value) {
                        $template[$headerColumn] = $value;
                    }
                }
            }
            $header[] = $template;
        }

        return $header;
    }
}
 
