<?php
/**
 * Created by PhpStorm.
 * User: Monk
 * Date: 2016/1/20
 * Time: 16:47
 */

namespace web\common;

use model\logic\Market;
use model\logic\Order;

class Controller{
    protected $view = null;

    private $free_action=array();

    private $role_action=array();

    public function __construct(){

        $this->view = new View();
        $this->view->js('jquery-1.11.3.js');
        $this->view->js('bootstrap.js');
        $this->view->css('bootstrap.css');
        $this->view->css('font-awesome.css');
        $this->view->css('bootstrap-theme.css');
        $this->view->css('base.css');
        $this->view->js('common/form.js');
        $request = \web\common\Request::instance();
        $action = $request->getAction();
        $controller = $request->getController();
        if('sign' != $controller || 'in' != $action){
            $this->view->js('common/notify.js');
        }
    }

    protected function addFreeAction($action){
        $this->free_action[] = strtolower($action);
    }

    protected function addRoleAction($role_id, $action){
        $this->role_action[$role_id][] = strtolower($action);
    }

    public function checkPermission(){

        $session = new Session();
        $request = Request::instance();
        $action = $request->getAction();
        $action = strtolower($action);

        if($session->getUser()){
            $order = new Order();
            $newOrder = $order->newOrder($session->getShop());
            $this->view->assign('newOrder',$newOrder);
            $market = new Market();
            $currentMarket = $market->getMarketsByID($session->getCurrentMarket());
            $allMarket = $market->getMarketsByID($session->getMarkets());
            $role = $session->getRole();
            $markets = array(
                'all' => $allMarket,
                'current' => $currentMarket
            );

            $this->view->assign('markets', $markets);
            $menu = new \model\logic\Menu();
            $menus = $menu -> getMenus($role);
            $this->view->assign('menu',$menus);
        }

        if(!in_array($action, $this->free_action)){
            if(!$session->isLogin()){
                $url = $request->makeURL('user', 'sign', 'in');
                $request->rediect($url);
            }
            else{
                $allowed = false;
                if(in_array($action,$this->role_action[$role])){
                    $allowed = true;
                }
                if(!$allowed){
                    $request->FOF();
                }
            }
        }
    }
}