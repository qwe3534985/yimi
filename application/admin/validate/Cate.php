<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/29
 * Time: 16:45
 */

namespace app\admin\validate;

use think\Validate;

class Cate extends Validate
{
//验证规则
    protected $rule = [
        'name' => 'require|max:20|unique:cate',
    ];
    //错误信息的提示文字
    protected $message = [
        'name.unique' => '用户名不能重复',
        'name.require' => '用户名不能为空',
    ];
    /**
     * 验证场景
     *
     */
    protected $scene = [
        'add' => ['name'],
        'addCate' => ['name'],
    ];

}