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

        $_POST['create_time'] = date('Y-m-d H:i:s');
        $res = Db::table('order')->insert($_POST);
        if ($res){
            return $this->buildReturn(1, '提交成功！');
        }else{
            return $this->buildReturn(0, '提交失败！');
        }
    }

    public function orderList()
    {
        $list = Db::table('order')->where(['status' => 1])->select();

        $this->assign('list', $list);
        return $this->fetch();
    }

    //输入订单号页面
    public function saveOrderNumber()
    {
        if (!isset($_POST['oid']))
            return $this->buildReturn(0, '订单不存在');
        if (!isset($_POST['shipping_number']))
            return $this->buildReturn(0, '订单号不能为空');

        $id = $_POST['oid'];
        $shipping_number = $_POST['shipping_number'];

        $res = Db::table('order')->where(['id' => $id])->update(['shipping_number' => $shipping_number]);
        if ($res){
            return $this->buildReturn(1, '保存成功！');
        }

        return $this->buildReturn(0, '保存失败！');
    }

    //查询订单号
    public function searchOrderNumber()
    {
        return $this->fetch();
    }

    public function getOrderNumber()
    {
        $shipping_name = isset($_POST['shipping_name']) && strlen($_POST['shipping_name'])>0 ? $_POST['shipping_name'] : null;
        $phone = isset($_POST['phone']) && strlen($_POST['phone'])>0 ? $_POST['phone'] : null;



        if (!$shipping_name && !$phone){
            echo json_encode($this->buildReturn(0, '请输入查询条件'), 256 );
            exit;
        }

        $shipping_name ? $query['shipping_name'] = $shipping_name : '';
        $phone ? $query['phone'] = $phone : '';

        $list = Db::table('order')->where($query)->select();
        if ($list){
            echo json_encode($this->buildReturn(1, '', $list), 256);
        }else{
            echo json_encode($this->buildReturn(0, '没有查询到结果，请确认下单时所填信息是否正确'), 256 );
        }
    }

    public function urlList()
    {
        return $this->fetch();
    }

    private function buildReturn($stauus, $msg, $data = null)
    {
        return ['status' => $stauus, 'msg' => $msg, 'data' => $data];
    }
}
