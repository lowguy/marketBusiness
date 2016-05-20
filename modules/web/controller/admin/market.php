<?php
/**
 * Created by PhpStorm.
 * User: LegendFox
 * Date: 2016/5/11 0011
 * Time: 上午 11:25
 */

namespace web\controller\admin;


use \web\common\Controller;
use web\common\Session;
use \web\common\Request;

class Market extends Controller
{
    public function __construct(){
        parent::__construct();
        $this->addRoleAction(100,'set');

    }

    public function set(){

        $market_id = $_GET['id'];

        $session = new Session();
        $session->setCurrentMarket($market_id);

        $request = Request::instance();

        $uri = explode('/', parse_url($_SERVER['HTTP_REFERER'],PHP_URL_PATH));
        $url = $request->makeURL('admin', $uri['2'], $uri['3']);

        $request->rediect($url);
    }
}