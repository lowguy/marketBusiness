<?php
/**
 * Created by PhpStorm.
 * User: LegendFox
 * Date: 2016/5/11 0011
 * Time: 下午 5:05
 */

namespace model\logic;


use model\database\Table;

class Category
{
    public function categoryName($market){
        $table = new Table('market_category');
        $filter = " LEFT JOIN category ON category.category_id = market_category.category_id WHERE market_category.market_id = ? AND status = ? ORDER BY weight ASC";
        $params = array($market,1);
        $fields = array(
            'category.category_id as id',
            'category.category_name as title'
        );
        return $table->lists($filter,$params,$fields);
    }

    public function getCategoryNameByID($id){
        $table = new Table('category');
        return $table->get(" WHERE category_id = ? ",array($id),array('category_name'));
    }
}