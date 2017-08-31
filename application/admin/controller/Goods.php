<?php
/**
 * Created by PhpStorm.
 * User: 0.0
 * Date: 2017/8/30
 * Time: 13:38
 */

namespace app\admin\controller;

use think\Controller;
use app\admin\model\Goods as GoodsModel;

class Goods extends Controller
{
    /**
     * @return mixed
     * 列表
     */
    public function index()
    {
        $data = GoodsModel::getGoods();
        $this->assign('data', $data);
        return $this->fetch('list');
    }

    /**
     * @return mixed
     * 添加商品 图片添加
     */
    public function add()
    {
        //获取分类列表所有信息
        $data = GoodsModel::getCateData();
        $this->assign('data', $data);

        if (request()->isPost()) {
            $arr = [
                'goods_name' => $this->request->param('goods_name'),
                'cate_id' => input('cate_id'),
                'sell_price' => input('sell_price'),
                'market_price' => input('market_price'),
                'store' => input('store'),
                'desc' => input('desc'),
                'content' => input('content'),
                'time' => time()
            ];
            //判断封面是否为空,是否存在
            if ($_FILES['file']['tmp_name'] == '' || !$_FILES['file']['tmp_name']) {
                return $this->error('必须上传封面');
            }
            //验证器
            $validate = Validate('Goods');
            if (!$validate->scene('add')->check($arr)) {
                return $this->error($validate->getError());
            }
            //添加商品表信息
            $addGoods = GoodsModel::addGoods($arr);
            if (!$addGoods) {
                return $this->error('添加失败');
            }
            //上传图片
            $file = GoodsModel::uploadImage('file');
            //判断图片是否上传成功
            if ($file['status'] == 'success') {
                //取出图片路径
                $image_url = $file['image_url'];
            } else {
                //打印错误信息
                return $this->error($file['mag']);
            }
            //缩放图片  调用GoodsModel静态方法传入image路径 与宽高
            $image_b_url = GoodsModel::zoom($image_url, 650, 650);//大
            $image_m_url = GoodsModel::zoom($image_url, 240, 240);//中
            $image_s_url = GoodsModel::zoom($image_url, 120, 120);//小
            //将图片信息保存到image表中
            $imageData = [
                'goods_id' => $addGoods,
                'image_url' => $image_url,
                'image_b_url' => $image_b_url ? $image_b_url : '',
                'image_m_url' => $image_m_url ? $image_m_url : '',
                'image_s_url' => $image_s_url ? $image_s_url : '',
                'is_face' => 1//封面
            ];
            //将图片信息添加到image表中
            $addImage = GoodsModel::addImage($imageData);
            if ($addImage) {
                return $this->success('添加成功', url('index'));
            } else {
                return $this->error('添加失败');
            }
        }
        return $this->fetch();
    }

    /**
     * 商品修改
     */
    public function goodsEdit()
    {
        $id = input('goods_id');
        //获取分类列表所有信息
        $cate_Data = GoodsModel::getCateData();
        $this->assign('cate', $cate_Data);
        //获取商品信息
        $data = GoodsModel::getEditGoods($id);
//        dump($data);exit;
        $this->assign('data', $data);
        return $this->fetch('edit');
    }

    /**
     *修改保存
     */
    public function edit()
    {
        if (request()->isPost()) {
            $arr = [
                'goods_id' => input('id'),
                'goods_name' => $this->request->param('goods_name'),
                'cate_id' => input('cate_id'),
                'sell_price' => input('sell_price'),
                'market_price' => input('market_price'),
                'store' => input('store'),
                'desc' => input('desc'),
                'content' => input('content'),
                'last_time' => time()
            ];
            //验证器
            $validate = Validate('Goods');
            if (!$validate->scene('edit')->check($arr)) {
                return $this->error($validate->getError());
            }
            //修改商品表信息
            $goodsEdit = GoodsModel::goodsEdit($arr);
            if ($goodsEdit!==false) {
                return $this->success('添加成功', url('index'));
            } else {
                return $this->error('修改失败');
            }
        }
    }

}