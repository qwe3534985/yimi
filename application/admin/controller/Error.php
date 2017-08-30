<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/23
 * Time: 9:30
 */

namespace app\admin\controller;

use think\Controller;
class Error extends Controller
{
    public function _empty()
    {
        return $this->fetch('_empty/404');
    }

}