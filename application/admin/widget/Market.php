<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/28
 * Time: 20:18
 */

namespace app\admin\widget;

use think\Controller;

class Market extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        $this->islogin();
    }

    /**
     * 判断是否登入
     */
    public function islogin(){
        $admin=session('manager');
        if (!isset($admin)||!$admin['id']){
            return $this->error('请先登入...',url('Login/index'));
        }
    }

    /**
     * @return mixed
     * 页首
     */
    public function header()
    {
        return $this->fetch('common/header');
    }

    public function left()
    {
        return $this->fetch('common/left');
    }

}