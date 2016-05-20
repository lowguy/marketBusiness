<?php
/**
 * Created by PhpStorm.
 * User: Monk
 * Date: 2016/1/8
 * Time: 14:18
 */

namespace model\logic;

use model\database\Table;

class Role{

    public function getRolesByUserID($id){
        $role_table = new Table('market_user');
        $filter = " WHERE user_id = ? AND status = ?";
        $roles = $role_table->lists($filter, array($id,1));
        return $roles;
    }
}