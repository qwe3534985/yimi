<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/29
 * Time: 13:52
 */

namespace app\admin\controller;

use app\admin\model\Cate as CateModel;
use think\Request;
use think\Controller;
use think\Validate;

class Cate extends Controller
{
    /**
     * 实例化Request
     */
    public $request;

    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        //Request调用单例模式的静态方法
        $this->request = Request::instance();
    }

    /**
     * @return mixed
     * 列表
     */
    public function index()
    {
        /**
         * 查询所有分类
         */
        //通过CateModel静态方法查询所有数据
        $data = CateModel::getAllCate();
        $this->assign('data', $data);
        return $this->fetch('list');
    }

    /**
     * @return mixed
     * 添加顶级分类
     */
    public function topCate()

    {
        //判断是否是从input传入
        if ($this->request->isPost()) {
            //获取input传入的name值
            $name = $this->request->param('name');
            //顶端pid的值都为0
            $pid = 0;
            //顶端level的值也都为0
            $level = 0;
            $data = [
                'name' => $name,
                'pid' => $pid,
                'level' => $level
            ];
            //验证
            $validate = Validate('Cate');
            if (!$validate->scene('add')->check($data)) {
                return $this->error($validate->getError());
            }
            //执行数据CateModel静态方法 完成数据添加
            $res = CateModel::topCate($data);
            if ($res) {
                return $this->success('添加成功', url('Cate/index'));
            } else {
                return $this->error('添加失败');
            }
        }
        return $this->fetch('add');
    }

    /**
     * 添加子分类
     */
    public function addCate()
    {
        //获取input传入的id
        $id = $this->request->param('id');
        //传入id通过CateModel的静态方法获取数据
        $data = CateModel::getCateById($id);
        $this->assign('data', $data);
        return $this->fetch('addCate');
    }

    /**
     * 执行添加子分类
     */
    public function doAddCate()
    {
        $arr = [
            'id' => $this->request->param('id'),
            'name' => $this->request->param('name')
        ];
        //验证器
        $validate = Validate('Cate');
        if (!$validate->scene('addCate')->check($arr)) {
            return $this->error($validate->getError());
        }
        //传入$arr数据通过CateModel的静态方法,完成数据添加
        $res = CateModel::addCate($arr);
        if ($res) {
            return $this->success('添加成功', url('index'));
        } else {
            return $this->error('添加失败');
        }
    }
    public function add(){
        
    }
}