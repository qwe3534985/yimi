<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/29
 * Time: 10:49
 */

namespace app\admin\model;

use think\Model;
use think\Db;

class Cate extends Model
{
    /**
     * 添加顶级和子分类的集合
     */
    static public function addAllCate($data)
    {
        //判断传入的$data['id']是否为0
        if ($data['id'] == 0) {
            //顶端分类
            //顶端pid的值都为0
            $pid = 0;
            //顶端level的值也都为0
            $level = 0;
        } else {
            //子分类
            $pid = $data['id'];
            //根据父分类的id主键查询数据
            $res = Db::name('cate')->find('$data[id]');
            $level = $res['level'] + 1;
        }
        $arr = [
            'name' => $data['name'],
            'pid' => $pid,
            'level' => $level
        ];

        //将数据添加到cate表并返回id主键
        $arr['id'] = db('cate')->insertGetId($arr);
        //判断传入的$data['id']是否为0
        if ($data['id'] == 0) {
            //顶级分类
            //是则是顶级分类 path等于自己的id
            $arr['path'] = $arr['id'];
        } else {
            //子分类
            //否则是子分类 path等于父类的path用,拼上自己的id
            $arr['path'] = $res['path'] . ',' . $arr['id'];
        }
        $res = db('cate')->update(['id' => $arr['id'], 'path' => $arr['path']]);
        return $res ? true : false;
    }

    /**
     * 查询所有的分类数据
     */
    static public function getAllCate()
    {
        //cate中的数据,按path排序 每页数据4条
        $data = Db::name('cate')->order('path')->paginate(4);
        $addData = Db::name('cate')->order('path')->select();
        //通过render()方法取出分页链接
        $pag = $data->render();
        //只获取分页后所有数据
        $arr = $data->all();//分页后的所有数据
        foreach ($arr as $key => $val) {
            //'--'重复level次在拼接上name
            $arr[$key]['name'] = str_repeat("--", $val['level']) . $val['name'];
        }
        foreach ($addData as $key => $val) {
            $addData[$key]['name'] = str_repeat("--", $val['level']) . $val['name'];
        }
        //return数据与分页链接
        return ['data' => $arr, 'pag' => $pag, 'addData' => $addData];
    }

    /**
     *添加顶级分类
     */
    static public function topCate($data)
    {
        //将$data插入到cate表获取id
        $id = Db::name('cate')->insertGetId($data);
        //如果id为空就return false
        if (!$id) {
            return false;
        }
        //顶级分类的path就是他自己的id
        $path = $id;
        //根据获取主键id更新数据 更新id与path
        $res = Db::name('cate')->update(['id' => $id, 'path' => $path]);
        return $res ? true : false;
    }

    /**
     * 通过分类id查询分类名称
     */
    static public function getCateById($id)
    {
        //判断传入的id是否为空
        if (!$id) {
            return false;
        }
        //根据传入的id主键获取数据
        $data = Db::name('cate')->find($id);
        //将数据返回
        return $data;
    }

    /**
     * 添加子分类
     */
    static public function addCate($data)
    {
        //将传入的$data通过self调用当前类里的getCateById方法,获取数据
        $arr = self::getCateById($data['id']);
        //判断数据不存在或者为空
        if (!$arr || empty($arr)) {
            return false;
        }
        //pid 是分类的id  path 父类的path 拼上自己的id level 是父类的level + 1
        $pid = $data['id'];//父类的id就是分类自己的pid
        $name = $data['name'];
        $level = $arr['level'] + 1;//分类的level=父类的level+1
        $param = [
            'pid' => $pid,
            'name' => $name,
            'level' => $level
        ];
        // 启动事务
        Db::startTrans();
        try {
            //添加
            //将$param插入到cate表获取id
            $id = Db::name('cate')->insertGetId($param);//获取id
            if (!$id) {
                return false;
            }
            //分类自己path是父类的path拼上自己id
            $path = $arr['path'] . ',' . $id;
            //将id与path传入更新数据
            $res = Db::name('cate')->update(['id' => $id, 'path' => $path]);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }
        return $res ? true : false;
    }
}