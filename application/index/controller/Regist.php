<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/30
 * Time: 16:24
 */

namespace app\index\controller;

use app\index\model\Regist as RegisMosel;
use think\Controller;

class Regist extends Controller
{
    public function index()
    {
        return $this->fetch('regist');
    }

    public function add()
    {
        if (request()->isPost()) {
            $arr = [
                'username' => input('username'),
                'password' => md5(input('password')),
                'reg_time' => time()
            ];
            $res = RegisMosel::addRegist($arr);
            if ($res) {
                return $this->success('添加成功');
            } else {
                return $this->error('添加失败');
            }
        }
        return $this->fetch();
    }
}