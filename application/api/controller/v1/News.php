<?php

namespace   app\api\controller\v1 ;

use  app\lib\exception\ParameterException ;

class  News extends  Base {

     public  function  getnews($page = 0 , $per_page = 10 ){

         $pageInter =   isPageInteger($page) ;
         $perpageInter = isPageInteger($per_page) ;

         if( !( $pageInter  &&  $perpageInter )){
             $e = new  ParameterException(array(
                 'msg' => '分页参数必须为整数' ,
                 'errorCode' => '391022',
             ));
             throw  $e ;
         }

         $searchKey =  model('SearchKey');
         $searchKey->setStartNum($page, $per_page) ;

         $nModel =   model('News');
         $data =  $nModel->getNewsList($searchKey);

         if(!empty($data)){
             foreach ($data  as  $k=>$v ){
                     $data[$k]['message'] =   strip_tags($v['message']) ;
             }
             $e = new  ParameterException(array(
                 'msg' => 'success' ,
                 'errorCode' => '0',
                 'datas'  =>  $data
             ));
             throw  $e ;

         }else{
             $e = new  ParameterException(array(
                 'msg' => 'success' ,
                 'errorCode' => '0',
                 'datas'   =>  null ,
             ));
             throw  $e ;
         }


     }

}























