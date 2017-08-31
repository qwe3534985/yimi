<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/30
 * Time: 16:48
 */

namespace app\index\model;

use think\Db;
use think\Model;

class Regist extends Model
{
    static public function addRegist($data)
    {
        $res = Db::name('member')->insert($data);
        return $res ? true : false;
    }
}