<?php

namespace app\admin\controller;

use think\Controller;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch('login');
    }

    public function login()
    {
        $data = [
            'username' => input('username'),
            'password' => input('password'),
            'code' => input('code')

        ];

        //先验证验证码
        if ($data['code'] == '' || !$data['code']) {
            return $this->error('请填写验证码');
        }

        //判断验证码是否正确
        if (!captcha_check($data['code'])) {
            return $this->error('验证码错误');
        }

        //验证用户名
        if ($data['username'] == '' || !$data['username']) {
            return $this->error('用户名不能为空');
        }

        //验证密码
        if ($data['password'] == '' || !$data['password']) {
            return $this->error('密码不能为空');
        }

        //判断用户名是否存在
        $arr = db('manager')->where(['username' => $data['username']])->find();
        if (!$arr) {
            return $this->error('用户名或密码错误');
        }
        if ($arr['password'] != md5($data['password'])) {
            return $this->error('用户名或密码错误');
        }

        //登录成功把用户信息放到session里面

        session('manager', $arr);
        return $this->success('登录成功,正在跳转到首页……', url('Index/index'));
    }
}