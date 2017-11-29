<?php

namespace   app\api\controller\v1 ;

use  app\lib\exception\ParameterException ;

class   Good  extends  Base{
//  获取热门商品
    public  function   gethots($page=0 , $per_page=10){

        $goodModel =   model('Good');

        $pageInter =   isPageInteger($page) ;
        $perpageInter = isPageInteger($per_page) ;

        if( !( $pageInter  &&  $perpageInter )){
            $e = new  ParameterException(array(
                'msg' => '分页参数必须为整数' ,
                'errorCode' => '391022',
            ));
            throw  $e ;
        }



        $user_id =  $this->jsondata[1] ;
        $searchKey =  model('SearchKey');
        $searchKey->setStartNum($page, $per_page) ;

       $datas =  $goodModel->getHotList( $searchKey ,$user_id );

      if(!empty($datas)){
          foreach ($datas as $k=>$v ){
                if($v != ""){
                       $v['original_img'] =   BASE_PATH . '/' . $v['original_img'];
                       $datas[$k] = $v ;
                }
          }

          $e = new  ParameterException(array(
              'msg' => 'success' ,
              'errorCode' => '0',
              'datas'  =>  $datas ,
          ));
          throw  $e ;
      }else{
          $e = new  ParameterException(array(
              'msg' => 'success' ,
              'errorCode' => '0',
              'datas'  =>  null  ,
          ));
          throw  $e ;
      }

    }


    /*
     *  获取商品详情
     *  @param   $good_id   int   :   商品编码
     *  @return    Array
     * */
    public  function  getdetails($good_id){

          $is_inter =   isAppPositiveInteger($good_id) ;

          if(!$is_inter){
              $e = new  ParameterException(array(
                  'msg' => '参数必须为正整数' ,
                  'errorCode' => '391023',
                  'datas'  =>  null  ,
              ));
              throw  $e ;
          }


        //先根据用户编码查询出该用户的姓名， 电话， 配送地址
        $uModel =  model('User');
//        $udata =  $uModel->getUserInfo($user_id);

//        if(empty($udata)){
//            $e = new  ParameterException(array(
//                'msg' => '该用户不存在' ,
//                'errorCode' => '391011',
//                'datas'  =>  null   ,
//            ));
//            throw  $e ;
//        }

         $goodmodel =  model('Good');

          $goods_info =  $goodmodel->getGoodsDetail($good_id) ;
//        var_dump($goods_info) ; die ;
            if(!empty($goods_info)){
                $goods_info['original_img'] = BASE_PATH . $goods_info['original_img'] ;
                $content  = html_entity_decode($goods_info['goods_content']) ;

                if($content != ""){
                    $cont_arr = getSrcImg($content) ;
                }else{
                    $goods_info['goods_content'] = [];
                }

                if(!empty($cont_arr)){
                    $goods_info['goods_content'] = [] ;
                    foreach ( $cont_arr   as $k=>$v ) {
                        $goods_info['goods_content'][$k] =   BASE_PATH  . $v ;
                    }

                }

//                $goods_info = array_merge($udata, $goods_info) ;

//                var_dump($goods_info) ;die("333") ;
                $e = new  ParameterException(array(
                    'msg' => 'success' ,
                    'errorCode' => '0',
                    'datas'  =>  $goods_info  ,
                ));
                throw  $e ;
            }else{
                $e = new  ParameterException(array(
                    'msg' => 'success' ,
                    'errorCode' => '0',
                    'datas'  =>  null   ,
                ));
                throw  $e ;
            }

    }

    /*
     *  获取精品推荐列表接口
     * */
    public  function  getRecomList($page=0, $per_page=10 ){

        $pageInter =   isPageInteger($page) ;
        $perpageInter = isPageInteger($per_page) ;

        if( !( $pageInter  &&  $perpageInter )){
            $e = new  ParameterException(array(
                'msg' => '分页参数必须为整数' ,
                'errorCode' => '391022',
            ));
            throw  $e ;
        }

          $user_id =  $this->jsondata[1] ;
          $goodModel =   model('Good');
          $searchKey =   model('SearchKey');
          $searchKey->setStartNum($page, $per_page) ;
          $goodList =   $goodModel->getRecomList($searchKey, $user_id) ;

          if(!empty($goodList)){
              $e = new  ParameterException(array(
                  'msg' => 'success' ,
                  'errorCode' => '0',
                  'datas' =>  $goodList ,
              ));
              throw  $e ;
          }else{
              $e = new  ParameterException(array(
                  'msg' => 'success' ,
                  'errorCode' => '0',
              ));
              throw  $e ;
          }

    }

    /*
     *  根据 品牌 查询所有的商品
     *   @param    $brand_id   int    :   品牌编码
     *   return   Array
     * */
    public  function  getbrandgoods($brand_id, $page= 0 , $per_page = 10 ){
        $pageInter =   isPageInteger($page) ;
        $perpageInter = isPageInteger($per_page) ;
        if( !( $pageInter  &&  $perpageInter )){
            $e = new  ParameterException(array(
                'msg' => '分页参数必须为整数' ,
                'errorCode' => '391022',
            ));
            throw  $e ;
        }

             $is_b_Inter =   isAppPositiveInteger($brand_id) ;
             if(!$is_b_Inter){
                 $e = new  ParameterException(array(
                     'msg' => '参数必须为正整数' ,
                     'errorCode' => '391023',
                 ));
                 throw  $e ;
              }

             $gModel =   model('Good')  ;
             $gData =  $gModel->getGoodsBy($brand_id , $page , $per_page) ;
             if(!empty($gData)){
                 $e = new  ParameterException(array(
                     'msg' => 'success' ,
                     'errorCode' => '0',
                     'datas' =>  $gData ,
                 ));
                 throw  $e ;
             }else{
                 $e = new  ParameterException(array(
                     'msg' => 'success' ,
                     'errorCode' => '0',
                     'datas' =>  null  ,
                 ));
                 throw  $e ;
             }
    }

}























