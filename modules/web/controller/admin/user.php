<?php
/**
 * Created by PhpStorm.
 * User: Monk
 * Date: 2016/1/26
 * Time: 16:53
 */

namespace web\controller\admin;

use model\logic\Code;
use web\common\Controller;
use web\common\Request;
use web\common\Session;
use web\common\SMS;

class User extends Controller{

    public function __construct(){
        parent::__construct();
        $this->addRoleAction(100, 'phoneUsed');
        $this->addRoleAction(100, 'getCode');
        $this->addRoleAction(100, 'add');
        $this->addRoleAction(100, 'status');
        $this->addRoleAction(100, 'index');
    }

    public function index(){
        $status_array = array(
            '0'=>'全部',
            '1'=>'启用',
            '2'=>'禁用'
        );
        $status = intval($_GET['status']);
        $size = 10;
        $page = intval($_GET['page']);
        $page = $page ? $page : 1;
        $phone = $_GET['phone'];

        $session = new Session();
        $shop = $session->getShop();
        $market_id = $session->getCurrentMarket();
        $user_model = new \model\logic\User();
        $data = $user_model->search($market_id, $shop, $status, $phone, $page, $size);
        $request = \web\common\Request::instance();
        $pagination_url = $request->makeURL('admin', 'user', 'index',array(
            'status'=>$status,
            'phone'=>$phone
        ));
        $pagination = new \web\common\Pagination($page, $size, $data['total'], $pagination_url);
        $this->view->assign('users', $data['data']);
        $this->view->assign('pagination', $pagination);
        $this->view->assign('status_array', $status_array);
        $this->view->js('admin/user/index.js');
        $this->view->render();
    }

    /**
     * 添加接单员
     */
    public function add(){
        $request   = Request::instance();
        if($request->isPOST()){
            $phone = $_POST['phone'];
            $pwd   = $_POST['password'];
            $code  = $_POST['code'];
            $verifyCode = $this->verifyCode($phone,$code);
            //检查验证码
            if($verifyCode == 0){
                $session = new Session();
                $shop    = $session->getShop();
                $market_id = $session->getCurrentMarket();
                $user  = new \model\logic\User();
                $code = $user->add($market_id,$phone,$pwd,$shop);
            }
            $request = Request::instance();
            $request->jsonOut($code);
        }else{
            $this->view->js('admin/user/form.js');
            $this->view->js('jquery.validate.js');
            $this->view->js('validate.method.js');
            $this->view->render('modules/web/view/admin/user/form.php');
        }
    }

    /**
     * 检查手机号是否被使用, POST请求
     */
    public function phoneUsed(){
        $result = true;

        $request = \web\common\Request::instance();
        if($request->isPOST()){

            $phone = $_POST['phone'];
            $user_model = new \model\logic\User();
            $user = $user_model->getUserByPhone($phone);
            if(null != $user){
                $result = false;
            }
            echo json_encode($result);
        }
        exit();
    }

    public function status(){
        $code = 1;
        $id = $_POST['id'];
        $id = intval($id);

        $user_model = new \model\logic\User();
        $rows = $user_model->toggleStatus($id);

        if($rows > 0){
            $code = 0;
        }
        $request = \web\common\Request::instance();

        $request->jsonOut($code, '');
    }

    /**
     * @param $phone
     * @param $verifyCode
     * @return array
     */
    private function verifyCode($phone,$verifyCode){
        $result = 4;
        $code = new Code();
        $res  =  $code->lastCode($phone);
        if($res){
            $result = 3;
            $time = time();
            if(($time - 300) < $res['created_at']){
                $result = 2;
                if($verifyCode == $res['code']){
                    $result = 0;
                }
            }
        }
        return $result;
    }

}