<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/28
 * Time: 20:18
 */

namespace app\index\widget;

use think\Controller;

class Market extends Controller
{
    /**
     * @return mixed
     * 页首
     */
    public function header()
    {
        return $this->fetch('common/header');
    }

    /**
     * @return mixed
     * 头部js
     */
    public function head()
    {
        return $this->fetch('common/head');
    }

    /**
     * @return mixed
     * 底部
     */
    public function footer()
    {
        return $this->fetch('common/footer');
    }
}