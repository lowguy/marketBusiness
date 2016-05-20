<?php
/**
 * Created by PhpStorm.
 * User: zhanghui
 * Date: 16/4/29
 * Time: 14:40
 */
namespace model\logic;

use model\database\Table;

class Market{

    /**
     * 获取用户所在的所有市场信息
     * @param $userID
     * @return array
     */
    public function getMarketsOfUser($userID){
        $table = new Table('market_user');
        $filter = " WHERE user_id = ? AND status = 1 AND role_id IN (100, 102)";
        return $table->lists($filter, array($userID));
    }

    public function getMarketsByID($ids){
        if(empty($ids)){
            return ;
        }
        $table = new Table('market');
        if(is_array($ids)){
            $res = $table->lists(" WHERE market_id IN (" . implode(',',$ids ) . ")",array(),array('market_id,district'));
        }else{
            $res = $table->lists(" WHERE market_id IN ({$ids})",array(),array('market_id,district'));
        }
        return $res;
    }

    /**
     * @param $userID
     * @return array
     */
    public function getShopOfUser($userID){
        $table  = new Table('user_operator');
        $filter = " WHERE user_id = ?";
        return $table->get($filter,array($userID));
    }
}