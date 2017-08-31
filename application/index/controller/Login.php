<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/30
 * Time: 15:58
 */

namespace app\index\controller;

use think\Controller;

class Login extends Controller
{
    /**
     * 登录
     */
    public function index()
    {
        return $this->fetch('login');
    }
    /**
     * 注册
     */
    public function add(){


    }}