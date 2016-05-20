<?php
/**
 * Created by PhpStorm.
 * User: zhanghui
 * Date: 16/5/11
 * Time: 09:52
 */

namespace web\controller\admin;

use web\common\Controller;
use web\common\Session;

class Notify extends Controller{

    public function __construct(){
        parent::__construct();
        $this->addRoleAction(100, 'index');
        $this->addRoleAction(102, 'index');
    }


    public function index(){
        $data = array(0);

        $order_model = new \model\logic\Order();
        $session = new Session();
        $shop = $session->getShop();
        $data[0] = $order_model->newOrder($shop);
        $data[0] = intval($data[0]);
        echo json_encode($data);
    }
}
