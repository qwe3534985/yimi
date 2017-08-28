<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/28
 * Time: 21:21
 */
namespace app\admin\controller;
use think\Controller;
class Index extends Controller{
    public function index(){
        return $this->fetch('index');
    }

}