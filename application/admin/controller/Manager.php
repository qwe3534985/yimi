<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/28
 * Time: 21:48
 */

namespace app\admin\controller;

use think\Controller;

class Manager extends Controller
{
    /**
     * @return mixed
     * 查询列表
     */
    public function index()
    {
        $data = db('manager')->select();
        $this->assign('data', $data);
        return $this->fetch('manager');
    }

    /**
     * @return mixed
     * 添加数据
     */
    public function add()
    {
        if (request()->isPost()) {
            $data = [
                'username' => input('username'),
                'password' => md5(input('password'))//获取add中input password 内容
            ];
            //添加数据
            $res = db('manager')->insert($data);
            if ($res) {
                return $this->success('添加成功！', url('manager/index'));
            } else {
                return $this->error('添加失败!');
            }
        }
        return $this->fetch('add');
    }
    /**
     * 删除
     */
    public function del(){
        $id = input('id');
        $res = db('manager')->delete($id);
        if ($res) {
            return $this->success('删除成功!', url('manager/index'));
        } else {
            return $this->error('删除失败！');
        }
    }

    /**
     * @return mixed
     * 编辑
     */
    public function edit()
    {
        $id = input('id');
        $data = db('manager')->where('id', $id)->find();
        $this->assign('data', $data);
        return $this->fetch('edit');
    }

    /**
     * @return mixed|void
     * 编辑修改
     */
    public function doEdit()
    {
        if (request()->isPost()) {
            $data = [
                'id' => input('id'),
                'username' => input('username'),
                'password' => md5(input('password'))
            ];
            $res = db('manager')->update($data);
            if ($res !== false) {
                return $this->success('修改成功!', url('manager/index'));
            } else {
                return $this->error('修改失败！');
            }
        }
//        return $this->fetch();
    }
}
