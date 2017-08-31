<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/29
 * Time: 16:45
 */

namespace app\admin\validate;

use think\Validate;

class Goods extends Validate
{
//验证规则
    protected $rule = [
        'goods_name' => 'require|max:20|unique:cate',
    ];
    //错误信息的提示文字
    protected $message = [
        'goods_name.unique' => '用户名不能重复',
        'goods_name.require' => '用户名不能为空',
    ];
    /**
     * 验证场景
     */
    protected $scene = [
        'add' => ['name'],
        'edit' => ['name'],
    ];

}