<?php
/**
 * Created by PhpStorm.
 * User: LegendFox
 * Date: 2016/5/9 0009
 * Time: 上午 10:43
 */

namespace web\controller\admin;


use model\logic\Category;
use web\common\Controller;
use web\common\Pagination;
use web\common\Request;
use web\common\Session;

class Product extends Controller
{
    public function __construct(){
        parent::__construct();
        $this->addRoleAction(100, 'changeStock');
        $this->addRoleAction(102, 'changeStock');
        $this->addRoleAction(100, 'index');
        $this->addRoleAction(102, 'index');
    }

    public function index(){
        $session    = new Session();
        $market     = $session->getCurrentMarket();
        $shop       = $session->getShop();
        $category   = new Category();
        $categories = $category->categoryName($market);
        $title      = $_GET['t'];
        $topCategory   = intval($_GET['p']) ? intval($_GET['p']) : 0;
        $page       = intval($_GET['page']);
        $page       = $page ? $page : 1;
        $size       = 10;
        $product    = new \model\logic\Product();
        $result     = $product->getProductByUserId($market,$shop,$page,$size,$title,$topCategory);
        $request = Request::instance();
        $pagination_url = $request->makeURL('admin', 'order', 'index',array(
            't'=>$title
        ));
        $pagination = new Pagination($page, $size, $result['total'], $pagination_url);
        $this->view->assign('categories', $categories);
        $this->view->assign('pagination', $pagination);
        $this->view->assign('products',$result['data']);
        $this->view->js('admin/product/index.js');
        $this->view->render();
    }

    public function changeStock(){
        $session    = new Session();
        $market     = $session->getCurrentMarket();
        $shop       = $session->getShop();
        $id = $_POST['id'];
        $stock = $_POST['stock'];
        $product = new \model\logic\Product();
        $res = $product->changeStock($market,$shop,$id,$stock);
        $code = $res ? 0 : 1;
        echo json_encode(array('code'=>$code));
    }
}