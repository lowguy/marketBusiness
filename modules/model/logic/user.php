<?php
/**
 * Created by PhpStorm.
 * User: LegendFox
 * Date: 2016/4/7 0007
 * Time: 上午 11:10
 */
namespace model\logic;

use model\database\Table;

class User {


    /**
     * 登录用户检测
     * @param $phone
     * @param $password
     * @return array|null
     */
    public function login($phone, $password){
        $table = new Table('user');
        $filter = " WHERE phone = ? AND password = ?";
        $user = $table->get($filter, array($phone, md5($password)));
        return $user;
    }

    /**
     * @param $phone
     * @param int $status
     * @return array|null
     */
    public function userInfo($phone,$status = 1){

        $table = new Table('user');

        $filter = " WHERE phone = ? AND status = ?";

        $fields = array('*');

        $user = $table->get($filter, array($phone,$status),$fields);

        return $user;

    }

    /**
     * 通过手机号码获取用户信息
     * @param $phone
     * @return array|null
     */
    public function getUserByPhone($phone){
        $filter = "WHERE phone = ?";

        $user_table = new Table('user');
        $user = $user_table->get($filter, array($phone));

        return $user;
    }

    /**
     * 添加用户
     * @param $market_id
     * @param $phone
     * @param $pwd
     * @param $shop
     * @return int
     */
    public function add($market_id,$phone,$pwd,$shop){
        $code  = 0;
        $table = new Table('user');
        $user_operator = new Table('user_operator');
        $user_user     = new Table('user_user');
        $market_user   = new Table('market_user');
        $pdo   = $table->getConnection();
        try{
            $pdo->beginTransaction();
            $table->add(array(
                'phone'=>$phone,
                'password'=>md5($pwd),
                'created_at'=>time(),
                'status'=>1
            ));
            $lastId = $table->lastID();

            $user_user->add(array(
                'start'=>$lastId,
                'end'=>$lastId,
                'distance'=>0));

            $market_user->add(array(
                'market_id'=>$market_id,
                'user_id'=>$lastId,
                'role_id'=>102,
                'status'=>1,

            ));

            $user_operator->add(array(
                'user_id'=>$lastId,
                'shop_id'=>$shop));
            $pdo->commit();
        }catch (\Exception $e){
            $code = $e->getCode();
        }
        return $code;
    }

    /**
     * 搜索用户
     * @param $market_id
     * @param $shop
     * @param string $phone, 手机号码
     * @param int $status, 状态
     * @param int $page, 页数
     * @param int $size, 每页大小
     * @return array
     */
    public function search($market_id,$shop,$status, $phone, $page, $size){
        $result = array(
            'total'=>0,
            'data'=>array()
        );
        $status = intval($status);
        $page = intval($page);
        $size = intval($size);
        $page = $page ? $page : 1;
        $size = $size ? $size : 10;

        $params = array();

        $table  = new Table('user_operator');
        $filter = " LEFT JOIN user ON user_operator.user_id = user.user_id LEFT JOIN market_user ON market_user.user_id = user_operator.user_id WHERE market_user.market_id = ? AND user_operator.shop_id = ? AND market_user.role_id = ?";
        $params[] = $market_id;
        $params[] = $shop;
        $params[] = 102;
        if(in_array($status, array(1,2))){
            $filter .= ' AND market_user.status = ?';
            $params[] = $status;
        }
        if(!empty($phone)){
            $phone = str_replace('%', '\%', $phone);
            $phone = str_replace('_', '\_', $phone);
            $filter .= ' AND user.phone like CONCAT("%", ? , "%")';
            $params[] = $phone;
        }
        //获取总数
        $result['total'] = $table->count($filter, $params, 'user_operator.user_id');

        $filter .= ' GROUP BY market_user.user_id ';

        $filter .= ' ORDER BY market_user.user_id DESC';
        $start = $size * ($page - 1);
        $filter .= " LIMIT $start, $size";

        $fields = array(
            'market_user.user_id',
            'user.phone',
            'market_user.status'
        );

        $result['data'] = $table->lists($filter, $params, $fields);
        return $result;
    }

    /**
     * 启用/禁用
     * @param $id
     * @return number
     */
    public function toggleStatus($id){
        $table = new Table('market_user');

        $pdo = $table->getConnection();

        $sql = 'UPDATE market_user SET status = ABS(status - 1) WHERE user_id = ?';
        $statement = $pdo->prepare($sql);
        return $statement->execute(array($id));

    }

}