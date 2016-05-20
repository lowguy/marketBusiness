<?php
/**
 * Created by PhpStorm.
 * User: LegendFox
 * Date: 2016/5/11 0011
 * Time: 下午 2:08
 */

namespace model\logic;


use model\database\Table;
use model\database\View;

class Product
{
    /**
     * 经营产品
     * @param $market
     * @param $shop
     * @param $page
     * @param $size
     * @param $title
     * @param $category
     * @return array|null
     */
    private function search($market,$shop,$page,$size,$title = null,$category=null){
        $res  = array(
            'total'=>0,
            'data'=>array()
        );
        $table = new Table('market_product');
        $filter = " LEFT JOIN product ON product.product_id = market_product.product_id WHERE market_product.user_id IS NOT NULL AND market_product.status = ? AND market_product.market_id = ? AND market_product.user_id =  ? ";
        $params = array(1,$market,$shop);
        if(!empty($category)){
            $filter .= " AND product.category_id IN ( SELECT end FROM category_category WHERE start = ? and distance = ?)";
            $params = array_merge($params,array($category,1));
        }

        if(!empty($title)){
            $filter .= ' AND product.title LIKE CONCAT("%", ? , "%") ';
            $params = array_merge($params,array($title));
        }

        $res['total'] = $table->count($filter,$params,'product.product_id');
        $filter .= " ORDER BY stock ASC,sales DESC";
        $start = $size * ($page - 1);
        $filter .= " LIMIT $start,$size";
        $fields = array(
            'product.product_id AS id',
            'product.title',
            'product.slogan',
            'product.category_id',
            'market_product.price',
            'market_product.market_id',
            'market_product.user_id',
            'market_product.stock',
            'market_product.sales',
            'market_product.start',
            'market_product.end',
            'market_product.updated_at',
            'market_product.open',
            'market_product.start_time',
            'market_product.close_time',
            'market_product.activity',
            'market_product.discount'
        );

        $res['data']    = $table->lists($filter,$params,$fields);
        return $res;

    }
    /**
     * 获取用户经营产品
     * @param $market
     * @param $shop
     * @param $page
     * @param $size
     * @param $title
     * @param $category
     * @return array
     */
    public function getProductByUserId($market,$shop,$page,$size,$title,$category){
        $res  = array(
            'total'=>0,
            'data'=>array()
        );
        if($market && $shop){
            $products = self::search($market,$shop,$page,$size,$title,$category);
            $res['total'] = $products['total'];
            foreach($products['data'] as $k => $v){
                $category_name = $this->getCategoryNameByID($v['category_id']);
                $res['data'][$k] = array(
                    'id' =>intval($v['id']),
                    'title'=>strval($v['title']),
                    'price'=>floatval($v['price']),
                    'stock'=>intval($v['stock']),
                    'sales'=>intval($v['sales']),
                    'status'=>intval($v['status']),
                    'activity'=>intval($v['activity']),
                    'discount'=>floatval($v['discount']),
                    'category_name'=>$category_name
                );
            }
        }
        return $res;
    }

    public function getCategoryNameByID($id){
        $category = new Category();
        $res = $category->getCategoryNameByID($id);
        return $res['category_name'];
    }
    /**
     * 获取单条产品信息
     * @param $id
     * @return array|null
     */
    public function getProductByID($id){
        $params = array();
        if(empty($id)){
            return $params;
        }
        $product_view = new View('v_product_category');
        $fields = array('*');
        $filter = ' WHERE product_id = ? ';
        $params[] = $id;
        $res    = $product_view->get($filter, $params, $fields);
        return $res;
    }

    public function changeStock($market,$shop,$id,$stock){
        $table = new Table('market_product');
        $data  = array('stock'=>$stock);
        $filter = " WHERE market_id = ? AND user_id = ? AND product_id = ?";
        $params = array($market,$shop,$id);
        return $table->edit($data,$filter,$params);
    }
}