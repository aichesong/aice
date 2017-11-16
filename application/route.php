<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
//
//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//    //'goodsInfo/[:id]' => ['Home/Goods/goodsInfo',['method' => 'get', 'ext' => 'html'],'cache'=>3600]
//    //Home/Goods/goodsInfo/id/104.html
//];
use think\Route;
// 注册路由到index模块的News控制器的read操作
//Route::get('goodsInfo/:id','api/goods/goodsInfo',['cache'=>['Home/Goods/goodsInfo',300]]);// 访问方式 http://www.tpshop2.0.com/goodsInfo/77.html

Route::post('api/:version/user/regist','api/:version.User/regist');// 访问方式 http://www.tpshop2.0.com/goodsInfo/77.html
Route::post('api/:version/user/login','api/:version.User/login');
Route::post('api/:version/user/password/reset','api/:version.User/reset');
Route::get('api/:version/user/:user_id/getuserinfo','api/:version.User/getUserInfo');    //获取用户信息接口
Route::put('api/:version/user/:user_id/updatesex','api/:version.User/updateSex');    //修改用户性别
Route::get('api/:version/user/:user_id/subordinates','api/:version.User/getSubordinates');    //我的下级
Route::put('api/:version/user/:user_id/quit','api/:version.User/quit');    //退出登录接口


Route::post('api/:version/user/:user_id/uploadimg','api/:version.User/uploadimg');
Route::get('api/:version/ad/getadlist','api/:version.Ad/getadlist');
Route::get('api/:version/ad/getad','api/:version.Ad/getad');   //获取启动页广告
Route::get('api/:version/order/getnews','api/:version.Order/getnews');   //获取最新快报接口
Route::get('api/:version/good/gethots','api/:version.Good/gethots');   //获取热门推荐接口


Route::get('api/:version/good/:good_id/getdetails','api/:version.Good/getdetails');   //获取商品详情接口


Route::get('api/:version/attr/:good_id/getattr','api/:version.Attr/getattr');   //获取商品属性接口

Route::get('api/:version/region/getlist','api/:version.Region/getRegionList');   //获取地区列表
Route::get('api/:version/version/:type/checkversion','api/:version.Version/checkVersion');   //版本检测接口

//汽车列表  接口

Route::get('api/:version/good/getrecomlist','api/:version.Good/getRecomList');   //获取精品推荐列表接口

//任务接口
Route::get('api/:version/task/:user_id/gettasklist','api/:version.Task/getTaskList');   //查询任务列表
Route::get('api/:version/user/:user_id/task/:task_id/getdetail','api/:version.Task/getDetail');   //查询任务详情


Route::get('api/:version/order/:user_id/getlist','api/:version.Order/getOrderList');   //获取用户订单列表接口
Route::get('api/:version/order/:rec_id/getorderdetail','api/:version.Order/getOrderDetail');   //查询订单详情接口
Route::post('api/:version/user/:user_id/good/:good_id/order/submitorder','api/:version.Order/submitOrder');   //提交订单接口


Route::post('api/:version/message/sendsms','api/:version.SendSms/sendCode');    //发送验证码

//汽车整车、产品品牌     全套接口
Route::get('api/:version/nav/:nav_id/home/gethomelist','api/:version.HomeList/getHomeList');





