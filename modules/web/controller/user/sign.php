<?php
/**
 * Created by PhpStorm.
 * User: Monk
 * Date: 2016/1/25
 * Time: 10:31
 */
namespace web\controller\user;
use model\logic\User;
use web\common\Controller;
use web\common\Session;

class Sign extends Controller{
    public function __construct(){
        parent::__construct();
        $this->addFreeAction('in');
        $this->addFreeAction('out');
        $this->addFreeAction('checkCode');
    }

    private function login(){
        $request = \web\common\Request::instance();
        $status = 1;
        $data = '用户名/密码错误';
        $session = new Session();
        $code = $_POST['code'];
        $session_code = $session->getCode();
        if($code == $session_code){
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $user = new User();
            $operator = $user->login($phone,$password);
            if(null != $operator){
                $marketModel = new \model\logic\Market();
                $userMarkets = $marketModel->getMarketsOfUser($operator['user_id']);

                if(!empty($userMarkets)){
                    $session->removeCode();
                    $session->reID();
                    $session->setTag();
                    $marketIDs = array_column($userMarkets, 'market_id');
                    $market = $userMarkets[0];
                    $session->setMarkets($marketIDs);
                    $session->setCurrentMarket($market['market_id']);
                    $session->setRole($market['role_id']);
                    $session->setUser($operator['user_id']);
                    if(100 == $market['role_id']){
                        $session->setShop($operator['user_id']);
                    }elseif(102 == $market['role_id']){
                        $shopID = $marketModel->getShopOfUser($operator['user_id']);
                        $session->setShop($shopID['shop_id']);
                    }
                    $status = 0;
                    $data   = "";
                }else{
                    $status = 2;
                    $data = '您没有权限使用此系统';
                }
            }
        }
        else{
            $status = 3;
            $data = '验证码错误';
        }
        echo $data;
        $request->jsonOut($status, $data);
    }

    /**
     * 用户登录, POST/GET
     * URI:/user/sign/in
     */
    public function in(){
        $request = \web\common\Request::instance();
        if($request->isPOST()){
            $this->login();
        }
        else{
            \session_start();
            $_SESSION['tag'] = 'tag';
            $this->view->css('user/login.css');
            $this->view->js('jquery.validate.js');
            $this->view->js('validate_zh.js');
            $this->view->js('validate.method.js');
            $this->view->render();
        }

    }
    /**
     * 用户登出, POST/GET
     * URI:/user/sign/out
     */
    public function out(){
        $session = new \web\common\Session();

        $session->destroy();

        $request = \web\common\Request::instance();
        $login_url = $request->makeURL('user', 'sign', 'in');
        $request->rediect($login_url);
    }

    /**
     * 验证码校验, POST
     * URI:/user/sign/checkcode
     */
    public function checkCode(){
        $session = new Session();
        $result = false;
        $code = $_POST['code'];
        $session_code = $session->getCode();
        if($code == $session_code){
            $result = true;
        }

        echo json_encode($result);
    }
}