<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Index extends Controller
{
    //表单主页
    public function index()
    {
        return $this->fetch();
    }

    //表单保存接口
    public function saveOrder()
    {
        if (!isset($_POST['address']))
            return $this->buildReturn(0, '收货地址不能为空');
        if (!isset($_POST['shipping_name']))
            return $this->buildReturn(0, '收货名不能为空');
        if (!isset($_POST['school_name']))
            return $this->buildReturn(0, '学校名字不能为空');
        if (!isset($_POST['real_name']))
            return $this->buildReturn(0, '姓名不能为空');
        if (!isset($_POST['font_type']))
            return $this->buildReturn(0, '刻字类型为必选');
        if (!isset($_POST['u_type']))
            return $this->buildReturn(0, 'U盘样式为必选');
        if (!isset($_POST['color']))
            return $this->buildReturn(0, '颜色为必选');

        Db::table('order')->insert($_POST);
        return $this->buildReturn(1, '提交成功！');
    }

    public function orderList()
    {
        $list = Db::table('order')->where(['status' => 1])->find();
        return $this->fetch();
    }

    //输入订单号页面
    public function saveOrderNumber()
    {

    }

    //查询订单号
    public function searchOrderNumber()
    {

    }

    private function buildReturn($stauus, $msg)
    {
        return ['status' => $stauus, 'msg' => $msg];
    }
}
