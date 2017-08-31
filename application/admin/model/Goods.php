<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/30
 * Time: 14:24
 */

namespace app\admin\model;

use think\Db;
use think\Model;

class Goods extends Model
{
    /**
     * @return false|\PDOStatement|string|\think\Collection
     *获取分类信息
     */
    static public function getCateData()
    {
        $data = Db::name('cate')->order('path')->select();
        foreach ($data as $key => $val) {
            $data[$key]['name'] = str_repeat("--", $val['level']) . $val['name'];
        }
        return $data;
    }

    /**
     * @param $data
     * @return int|string
     * 商品添加
     */
    static public function addGoods($data)
    {
        $res = Db::name('goods')->insert($data);
        return $res;
    }

    /**
     * 获取商品信息
     */
    static public function getGoods()
    {
        //两表联查
        $data = Db::name('goods')
            ->alias('g')
            ->field('g.goods_id,g.goods_name,g.sell_price,g.market_price,g.store,g.freeze,g.desc,g.content,g.last_modify_id,g.last_time,c.name')
            ->join('cate c', 'g.cate_id=c.id')
            ->paginate(5);
        return $data;
    }


    /**
     * 上传图片
     */
    static public function uploadImage($file)
    {
        //创建一个数组装信息
        $response = [
            //默认上传失败
            'status' => 'error',
            //提示信息为空
            'msg' => ''
        ];
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
//        dump($info);exit;
        if ($info) {
            // 成功上传后 获取上传信息
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            $image_url = $info->getSaveName();
            //字符串拼接路径,str_replace将路径中\的字符串替换成/
            $image_url = '/uploads/' . str_replace('\\', '/', $image_url);
            //上传成时改成成功信息
            $response['status'] = 'success';
            $response['msg'] = '上传成功';
            //保存图片路径
            $response['image_url'] = $image_url;
            return $response;
        } else {
            // 上传失败获取错误信息
            $response['msg'] = $file->getError();
            return $response;
        }
    }

    /**
     * 缩放图片
     */
    static public function zoom($url, $width = 120, $height = 120)
    {
        //打开图片
        $image = \think\Image::open('./' . $url);
        $dir_name = dirname($url);//获取目录名  /uploads/20170830
        $file_name = basename($url);//获取文件名  42a79759f284b767dfcb2a0197904287.jpg
        //目录名拼上/拼上宽度拼上 _ 拼上文件名
        $save_name = $dir_name . '/' . $width . '_' . $file_name;
        //保存缩略图  传入一个相对路径 宽高  进行thumb等比缩放
        $result = $image->thumb($width, $height)->save('./' . $save_name);
        //判断是否缩放成功
        if (!$result) {
            return false;
        }
        //缩放成功返回缩放图片的图片名
        return $save_name;
    }

    /**
     *图片添加
     */
    static public function addImage($data)
    {
        $res = Db::name('image')->insert($data);
        return $res;
    }

    /**
     * 修改获取商品修改显示信息
     */
    static public function getEditGoods($id)
    {
        //两表联查
        $data = Db::name('goods')
            ->alias('g')
            ->field('g.goods_id,g.goods_name,g.sell_price,g.market_price,g.store,g.freeze,g.desc,
            g.content,g.cate_id,g.last_modify_id,g.last_time,c.name')
            ->join('cate c', 'g.cate_id=c.id')
            ->find($id);
        return $data;
    }
    /**
     * 商品修改
     */
    static public function goodsEdit($data)
    {
        $res = Db::name('goods')->update($data);
        return $res?true:false;
    }

}