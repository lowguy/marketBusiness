<?php
/**
 * Created by PhpStorm.
 * User: Monk
 * Date: 2016/1/20
 * Time: 16:07
 */
namespace web\common;

class Session{

    public function __construct()
    {
        if(!isset($_SESSION)){
            \session_start();
            if(!$this->isOK()){
                session_destroy();
            }
        }
    }


    public function reID(){
        \session_regenerate_id(true);
    }

    public function destroy(){
        \session_destroy();
    }

    public function setTag(){
        $this->set('tag', 'tag');
    }

    public function isOK(){
        return !empty($this->get('tag'));
    }

    public function set($key, $value){
        $_SESSION[$key] = $value;
    }

    public function remove($key){
        unset($_SESSION[$key]);
    }

    public function setRole($roleID){
        $this->set('role', $roleID);
    }

    public function getRole(){
        return $this->get('role');
    }

    public function setUser($userID){
        $this->set('user', $userID);
    }

    public function getUser(){
        return $this->get('user');
    }

    public function setShop($userID){
        $this->set('shop', $userID);
    }

    public function getShop(){
        return $this->get('shop');
    }

    public function setCurrentMarket($marketID){
        $this->set('market', $marketID);
    }

    public function getCurrentMarket(){
        return $this->get('market');
    }

    public function setMarkets($marketIDs){
        $this->set('markets', $marketIDs);
    }

    public function getMarkets(){
        return $this->get('markets');
    }

    public function setCode($value){

        $this->set('code', $value);
    }

    public function removeCode(){
        $this->remove('code');
    }

    public function getCode(){
        return $this->get('code');
    }

    public function get($key){

        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function isLogin(){
        $result = false;
        $user = $this->getUser();
        if(!empty($user)){
            $result = true;
        }

        return $result;
    }
}