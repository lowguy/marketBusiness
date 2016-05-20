<?php
/**
 * Created by PhpStorm.
 * User: LegendFox
 * Date: 2016/5/9 0009
 * Time: 上午 10:39
 */

namespace web\controller\admin;


use web\common\Controller;
use web\common\Session;

class Order extends Controller
{
    public function __construct(){
        parent::__construct();
        $this->addRoleAction(100, 'index');
        $this->addRoleAction(102, 'index');
        $this->addRoleAction(100, 'deal');
        $this->addRoleAction(102, 'deal');
        $this->addRoleAction(100, 'newOrder');
        $this->addRoleAction(102, 'newOrder');
    }

    public function index(){
        $order_status = array(
            array('id'=>'0','title'=>'未处理'),
            array('id'=>'1','title'=>'已处理'),
        );
        $order_model = new \model\logic\Order();
        $session = new Session();
        $shop = $session->getShop();
        $status = intval($_GET['s']);
        $order_no   = $_GET['n'];
        $page = intval($_GET['page']);
        $page   = $page ? $page : 1;
        $size   = 10;
        $data = $order_model->search($shop,$status,$order_no,$page,$size);
        foreach($data['data'] as $k => $v){
            $data['data'][$k]['amount'] = 0;
            $goods = $order_model->orderProducts($shop,$v['order_id']);
            $data['data'][$k]['goods'] = $goods;
            foreach($goods as $kg => $vg){
                $data['data'][$k]['amount'] += $vg['amount'];
            }
        }
        $request = \web\common\Request::instance();
        $pagination_url = $request->makeURL('admin', 'order', 'index',array(
            's'=>$status
        ));
        $pagination = new \web\common\Pagination($page, $size, $data['total'], $pagination_url);
        $this->view->assign('pagination', $pagination);
        $this->view->assign('orders', $data['data']);
        $this->view->assign('order_status', $order_status);
        $this->view->js('lodop.js');
        $this->view->js('admin/order/index.js');
        $this->view->render();
    }

    public function deal(){
        $session = new Session();
        $shop = $session->getShop();
        $order_id = $_POST['id'];
        $order = new \model\logic\Order();
        $code = $order->printTicket($order_id,$shop);
        echo json_encode(array('code'=>$code));
    }

}