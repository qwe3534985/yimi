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
    public function header()
    {
        return $this->fetch('common/header');
    }

    public function left()
    {
        return $this->fetch('common/left');
    }

}