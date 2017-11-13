<?php


namespace app\api\controller\v1 ;

use app\api\validate\IDMustBeInteger;
use app\api\validate\UserLoginValidate;
use app\api\validate\UserRegistValidate;
use app\api\validate\UserResetValidate;
use  app\lib\exception\ParameterException ;


class User  extends   Base {

//    用户注册接口
    public  function  regist(){

        if(request()->isPost()){
             //根据   推荐人号码  找到推荐人uid
//            var_dump($this->post['recond_mobile']) ; die ;

//          (new UserRegistValidate() )->goCheck() ;
          $postdata = request()->post() ;

          if(!isset($postdata['nickname'])  ||  !isset($postdata['mobile'])  || !isset($postdata['password'])  ||  !isset($postdata['recond_mobile'])  ||  !isset($postdata['id_card'])  ){
              $e = new  ParameterException(array(
                  'msg' => '缺少必填参数' ,
                  'errorCode' => '391016',
              ));
              throw  $e ;
          }

            if(!isAppNotEmpty($postdata['mobile'])){
                $e = new  ParameterException(array(
                    'msg' => '手机号码不能为空' ,
                    'errorCode' => '391020',
                ));
                throw  $e ;
            }

            if(!isAppNotEmpty($postdata['recond_mobile'])){
                $e = new  ParameterException(array(
                    'msg' => '手机号码不能为空' ,
                    'errorCode' => '391020',
                ));
                throw  $e ;
            }

          if(!isAppNotEmpty($postdata['nickname'])){
              $e = new  ParameterException(array(
                  'msg' => '用户名不能为空' ,
                  'errorCode' => '391017',
              ));
              throw  $e ;
          }

            if(!isAppNotEmpty($postdata['password'])){
                $e = new  ParameterException(array(
                    'msg' => '密码不能为空' ,
                    'errorCode' => '391015',
                ));
                throw  $e ;
            }

            if(!isAppNotEmpty($postdata['id_card'])){
                $e = new  ParameterException(array(
                    'msg' => '身份证号码不能为空' ,
                    'errorCode' => '391018',
                ));
                throw  $e ;
            }

            if(!isIdentify($postdata['id_card'])){
                $e = new  ParameterException(array(
                    'msg' => '身份证号码格式错误' ,
                    'errorCode' => '391019',
                ));
                throw  $e ;
            }

            if(!isAppMobile($postdata['mobile'])){
              $e = new  ParameterException(array(
                  'msg' => '手机号码格式不正确' ,
                  'errorCode' => '391014',
              ));
              throw  $e ;
          }



          $ismobile =   isAppMobile($postdata['mobile']) ;
          if(!$ismobile){
              $e = new  ParameterException(array(
                  'msg' => '手机号码格式不正确' ,
                  'errorCode' => '391014',
              ));
              throw  $e ;
          }

            $mobile = I('post.mobile', '');
            $code = I('post.mobile_code', '');
            $scene = I('post.scene', 1);
            $session_id = session_id();

            $check_code =check($code, $mobile, $session_id, $scene);
            if($check_code['status'] != 1){
                $this->ajaxReturn($check_code);
            }

          if($postdata['mobile'] == $postdata['recond_mobile']){
              $e = new  ParameterException(array(
                  'msg' => '注册手机号不能与推荐人手机号一样' ,
                  'errorCode' => '391002',
              ));
              throw  $e ;
          }



          //查询该身份证号码是否已经存在
           $card =  M('users')->where('id_card', $postdata['id_card'])->find() ;
           if(!empty($card)){
               $e = new  ParameterException(array(
                   'msg' => '该用户已存在' ,
                   'errorCode' => '391006',
               ));
               throw  $e ;
           }

          //查询该手机号码是否已经存在    ， 查询推荐人手机号是否存在
           $result =   M('users')->where('mobile',$postdata['mobile'])->find();
//           var_dump($result) ; die ;
            if(!empty($result)){
                $e = new  ParameterException(array(
                    'msg' => '该号码已注册' ,
                    'errorCode' => '391001',
                ));
                throw  $e ;
            }

            $udata =  M('users')->where('mobile' , $postdata['recond_mobile'])->field('user_id')->find() ;

            if($udata == NULL ){
                $e = new  ParameterException(array(
                    'msg' => '推荐人手机号不存在' ,
                    'errorCode' => '391003',
                ));
                throw  $e ;
            }

            //验证身份证信息
            if(config('app_debug') == false){
                $validator = identity($postdata['nickname'], $postdata['id_card']) ;
                $validate_info =substr($validator,strpos($validator,'{'));
                $validate_info =   json_decode($validate_info, true ) ;
                if($validate_info !=null){
                    if($validate_info['result']['isok'] == false){
                        $e = new  ParameterException(array(
                            'msg' => '身份信息不符合，请填写真实信息' ,
                            'errorCode' => '391012',
                        ));
                        throw  $e ;
                    }
                }else{
                    $e = new  ParameterException(array(
                        'msg' => '身份认证失败' ,
                        'errorCode' => '391013',
                    ));
                    throw  $e ;
                }
            }



          //执行 用户注册的逻辑
            $map['password'] =   encrypt(request()->post('password')) ;
            $map['nickname'] = $postdata['nickname'];
            $map['uid'] = $udata['user_id'];
            $map['mobile'] = $postdata['mobile'];
            $map['reg_time'] = time() ;
            $map['id_card'] = $postdata['id_card'] ;
            $map['token'] = md5(time().mt_rand(1,999999999));

            //数据入库
            $res =    M('users')->save($map);
            if($res){
                $e = new  ParameterException(array(
                    'msg' => '注册成功' ,
                    'errorCode' => '0',
                ));
                throw  $e ;
            }else{
                $e = new  ParameterException(array(
                    'msg' => '注册失败' ,
                    'errorCode' => '391004',
                ));
                throw  $e ;
            }

        }
    }


//    用户登录接口
    public   function  login(){

//        (  new  UserLoginValidate() )->goCheck() ;

        $postdata =   request()->post() ;

         $isMobile =  isAppMobile($postdata['mobile']) ;
         if($isMobile ==  false ){
             $e = new  ParameterException(array(
                 'msg' => '手机格式不正确' ,
                 'errorCode' => '391014',
             ));
             throw  $e ;
         }


         if(!isAppNotEmpty($postdata['password'])){
             $e = new  ParameterException(array(
                 'msg' => '密码不能为空' ,
                 'errorCode' => '391014',
             ));
             throw  $e ;
         }


        //根据 手机号码  ， 密码  去查询数据
         $uModel =  model('User') ;
         $data =  $uModel->identiMobilePass($postdata) ;
//        var_dump($data) ;die ;

        if($data != NULL ){
            $e = new  ParameterException(array(
                'msg' => '登录成功' ,
                'errorCode' => '0',
                'datas'  =>  $data
            ));
            throw  $e ;
        }else{
            $e = new  ParameterException(array(
                'msg' => '手机号或密码错误' ,
                'errorCode' => '391007',
                'datas'  =>  $data
            ));
            throw  $e ;
        }
    }

//    更换密码
    public  function  reset(){
       // (new  UserResetValidate())->goCheck() ;
        $postdata = request()->post() ;

        //先把 验证码写死
        if($postdata['vcode'] != "888888"){
            $e = new  ParameterException(array(
                'msg' => '验证码错误' ,
                'errorCode' => '391005',
            ));
            throw  $e ;
        }



        if(!isAppNotEmpty($postdata['newpassword'])){
            $e = new  ParameterException(array(
                'msg' => '密码不能为空' ,
                'errorCode' => '391015',
            ));
            throw  $e ;
        }

        if(!isAppNotEmpty($postdata['mobile'])){
            $e = new  ParameterException(array(
                'msg' => '手机号码不能为空' ,
                'errorCode' => '391020',
            ));
            throw  $e ;
        }

        if(!isAppMobile($postdata['mobile'])){
            $e = new  ParameterException(array(
                'msg' => '手机号码格式不正确' ,
                'errorCode' => '391014',
            ));
            throw  $e ;
        }

        $mobile =$postdata['mobile'];
        $code = $postdata['mobile_code'];
        $scene = 2;
        $session_id = session_id();
        $check_code =check($code, $mobile, $session_id, $scene);
        if($check_code['status'] != 1){
            $e = new  ParameterException(array(
                'msg' => '手机验证码不正确' ,
                'errorCode' => '391008',
            ));
            throw  $e ;
        }
        $password =  encrypt($postdata['newpassword']) ;

        $oldpassword =  M('users')->where('mobile', $postdata['mobile'])->getField('password') ;

        if($oldpassword != NULL ){
             if($password == $oldpassword){
                 $e = new  ParameterException(array(
                     'msg' => '新密码不能和旧密码相同' ,
                     'errorCode' => '391008',
                 ));
                 throw  $e ;
             }
        }else{
            $e = new  ParameterException(array(
                'msg' => '手机号不存在' ,
                'errorCode' => '391003',
            ));
            throw  $e ;
        }

        $res =   M('users')->where('mobile', $postdata['mobile'])->save(['password' => $password]) ;
        if($res){
            $e = new  ParameterException(array(
                'msg' => '重置密码成功' ,
                'errorCode' => '0',
            ));
            throw  $e ;
        }else{
            $e = new  ParameterException(array(
                'msg' => '重置密码失败' ,
                'errorCode' => '391009',
            ));
            throw  $e ;
        }
     }

     //发送验证码
    public function send_code()
    {
        $postdata = request()->post() ;

        $scene = $postdata['scene'];    //发送短信验证码使用场景  1注册 2 找回密码
        $mobile = $postdata['mobile'];
        $session_id = session_id();

        //注册
        //判断是否存在验证码
        $data = M('sms_log')->where(array('mobile' => $mobile, 'session_id' => $session_id, 'status' => 1))->order('id DESC')->find();
        //获取时间配置
        $sms_time_out = '60';
        //60秒以内不可重复发送
        if ($data && (time() - $data['add_time']) < $sms_time_out) {
            $e = new  ParameterException(array(
                'msg' => $sms_time_out . '秒内不允许重复发送',
                'errorCode' => '391020',
            ));
            throw  $e;
        }
        //随机一个验证码
        $code = mt_rand(100000, 999999);
        if ($scene == 1) {
            $msg = '验证码：' . $code . ',您正在注册成为爱车送用户, 请勿告诉他人，感谢您的支持!';
        }
        if ($scene == 2) {
            $msg = '验证码：' . $code . ',用于密码找回，如非本人操作，请及时检查账户安全';
        }

        //发送短信
        $resp = sendSms($mobile, $msg, $code, $scene, $needstatus = 'true');
        if ($resp['status'] == 1) {
            //发送成功, 修改发送状态位成功
            $e = new  ParameterException(array(
                'msg' => '发送成功',
                'errorCode' => '391021',
            ));
            throw  $e;
        } else {
            $e = new  ParameterException(array(
                'msg' => '发送失败',
                'errorCode' => '391020',
            ));
            throw  $e;
        }
    }

//     上传图像
    public  function uploadimg(){
        $user_id =   request()->get('user_id') ;


        $file  =   request()->file('image') ;


        if($file == NULL ){
            $e = new  ParameterException(array(
                'msg' => '上传图片不能为空' ,
                'errorCode' => '391021',
            ));
            throw  $e ;
        }

        if(!isAppPositiveInteger($user_id)){
            $e = new  ParameterException(array(
                'msg' => '用户编码必须为正整数' ,
                'errorCode' => '391022',
            ));
            throw  $e ;
        }






            $id  =  M('users')->where('user_id' , $user_id)->getField('user_id');
            if($id == NULL ){
                $e = new  ParameterException(array(
                    'msg' => '该用户不存在' ,
                    'errorCode' => '391011',
                ));
                throw  $e ;
            }

            $dateArr =   sub_year_month_day();
            $yearpath = "public/upload/head_pic/" . $dateArr[0] ;

            //判断文件夹是否存在  ( 2017 )

            if(!is_dir($yearpath)){
                mkdir($yearpath);
            }

            $info =  $file->move($yearpath) ;
            $logo =  str_replace('\\', '/',$info->getSaveName()) ;
            $path =   '/' . $yearpath . '/' . $logo ;



            //删除数据库中原有的图片， 上传新的图片
            $head_pic_url =  M('users')->where('user_id' , $user_id)->getField('head_pic');
            if($head_pic_url != ""){

                unlink(substr($head_pic_url, 1)) ;
            }


            $res =   M('users')->where('user_id' , $user_id)->save(['head_pic' => $path]) ;

            if($res){
                //图片上传成功
                $e = new  ParameterException(array(
                    'msg' => '图片上传成功' ,
                    'errorCode' => '0',
                    'datas' =>  BASE_PATH  . $path  ,
                ));
                throw  $e ;
            }else{
                //图片上传失败
                $e = new  ParameterException(array(
                    'msg' => '图片上传失败' ,
                    'errorCode' => '391010',
                ));
                throw  $e ;
            }
      }




//      获取用户信息
    public  function  getuserinfo($user_id){

        $is_Inter =   isAppPositiveInteger($user_id) ;

        if(!$is_Inter){
            $e = new  ParameterException(array(
                'msg' => '参数必须为正整数' ,
                'errorCode' => '391023',
            ));
            throw  $e ;
        }

         $uModel =   model('User');
         $udata =   $uModel->getUserInfoBy($user_id);
         if(!empty($udata)){
             $e = new  ParameterException(array(
                 'msg' => 'success' ,
                 'errorCode' => '0',
                 'datas'      => $udata ,
             ));
             throw  $e ;
         }else{
             $e = new  ParameterException(array(
                 'msg' => '该用户不存在' ,
                 'errorCode' => '391011',
                 'datas'      => null ,
             ));
             throw  $e ;
         }
    }

//    更新用户信息
    public  function  updateSex($user_id){
        $is_Inter =   isAppPositiveInteger($user_id) ;

        if(!$is_Inter){
            $e = new  ParameterException(array(
                'msg' => '参数必须为正整数' ,
                'errorCode' => '391023',
            ));
            throw  $e ;
        }

        $data = request()->put() ;
//        var_dump($data) ;die ;

        if(empty($data)){
            $e = new  ParameterException(array(
                'msg' => '参数不能为空' ,
                'errorCode' => '391016',
            ));
            throw  $e ;
        }


        if(!isset($data['sex'])){
            $e = new  ParameterException(array(
                'msg' => '性别不能为空' ,
                'errorCode' => '391016',
            ));
            throw  $e ;
        }

        $udata =  M('users')->where('user_id' , $user_id)->field('sex')->find() ;
        if($udata == NULL ){
            $e = new  ParameterException(array(
                'msg' => '	该用户不存在' ,
                'errorCode' => '391011',
            ));
            throw  $e ;
        }else{
            if($udata['sex'] == $data['sex']){
                $e = new  ParameterException(array(
                    'msg' => 'success' ,
                    'errorCode' => '0',
                ));
                throw  $e ;
            }
        }

        $res =   M('users')->where('user_id' , $user_id)->save(['sex' => $data['sex']]) ;

        if($res){
            $e = new  ParameterException(array(
                'msg' => 'success' ,
                'errorCode' => '0',
            ));
            throw  $e ;
        }else{
            $e = new  ParameterException(array(
                'msg' => '性别更改失败' ,
                'errorCode' => '391027',
            ));
            throw  $e ;
        }

    }

}














