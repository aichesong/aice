<?php


namespace   app\api\controller\v1 ;
use  app\lib\exception\ParameterException ;

class  HomeList extends  Base {

    public  function  getHomeList($nav_id , $page = 0 , $per_page = 10){

            $is_Inter =   isAppPositiveInteger($nav_id) ;
            if(!$is_Inter){
                $e = new  ParameterException(array(
                    'msg' => '参数必须为正整数' ,
                    'errorCode' => '391023',
                    'datas'  =>  null  ,
                ));
                throw  $e ;
            }

            $is_page_Inter =   isPageInteger($page) ;
            $is_per_page_Inter =   isPageInteger($per_page) ;

            if(!$is_page_Inter  || !$is_per_page_Inter){
                $e = new  ParameterException(array(
                    'msg' => '分页参数必须为整数' ,
                    'errorCode' => '391022',
                ));
                throw  $e ;
            }

            $user_id =  $this->jsondata[1] ;
            $searchKey =   model('SearchKey');
            $searchKey->setStartNum($page, $per_page) ;

            if($nav_id == "2" ){    // 汽车整车

                //判断是否有传入  cat_id  参数
                 $cat_id = request()->get('cat_id') ;
                 $catModel =   model('Category');
                if($cat_id == NULL ){
                     $dataList =    $catModel->getAllCatList($searchKey, $user_id) ;
                }else{
                      //cat_id  必须为正整数
                       $cat_inter  =  isAppPositiveInteger($cat_id) ;
                       if(!$cat_inter){
                           $e = new  ParameterException(array(
                               'msg' => '分类编码必须为正整数' ,
                               'errorCode' => '391023',
                               'datas'  =>  null  ,
                           ));
                           throw  $e ;
                       }

                       $dataList = $catModel->getCatListBy($cat_id ,$searchKey, $user_id) ;
                }
            }elseif ($nav_id == "4"){
                //判断是否有传入  cat_id  参数
                $brand_id = request()->get('brand_id') ;
                $brandModel =   model('Brand');
                if($brand_id == NULL ){
                        $dataList = $brandModel->getAllBrandList($searchKey , $user_id) ;
                }else{
                        $dataList = $brandModel->getAllListBy( $brand_id ,$searchKey , $user_id) ;
                }
            }elseif ( $nav_id == "1"){
                        $gModel =   model('Good') ;
                        $dataList =  $gModel->getRecomDataList($searchKey , $user_id) ;
            }

        if(!empty($dataList)){
            $e = new  ParameterException(array(
                'msg' => 'success' ,
                'errorCode' => '0',
                'datas'  =>  $dataList   ,
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
 *  搜索接口
 *  @param    $page    int   :   当前页
 *  @param    $per_page  int  :  每页显示的条目数
 * */
    public  function  searchList($page = 0 , $per_page = 10 , $key = ""){
        $is_page_Inter =   isPageInteger($page) ;
        $is_per_page_Inter =   isPageInteger($per_page) ;

        if(!$is_page_Inter  || !$is_per_page_Inter){
            $e = new  ParameterException(array(
                'msg' => '分页参数必须为整数' ,
                'errorCode' => '391022',
            ));
            throw  $e ;
        }

      if($key == ""){
          $e = new  ParameterException(array(
              'msg' => '搜索内容为空' ,
              'errorCode' => '391040',
          ));
          throw  $e ;
      }else{
              $gModel =   model('Good') ;
              $searchKey =   model('SearchKey');
              $searchKey->setStartNum($page, $per_page) ;
              $data =  $gModel->searchGoodList($searchKey , $key) ;
              if(!empty($data)){
                  $e = new  ParameterException(array(
                      'msg' => 'success' ,
                      'errorCode' => '1',
                      'datas'  =>  $data ,
                  ));
                  throw  $e ;
              }else{
                  $e = new  ParameterException(array(
                      'msg' => 'success' ,
                      'errorCode' => '1',
                      'datas'  =>  null  ,
                  ));
                  throw  $e ;
              }
      }




    }

}
