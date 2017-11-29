<?php


namespace    app\api\model  ;

use think\Model;

class  News  extends   Model {
    protected  $table = 'tp_news' ;

    /*
     *  获取消息列表
     *  @param   $searchKey   obj  :  分页对象
     * return  Array
     * */
    public  function  getNewsList($searchKey){
         $sql =  ' select  n.id , n.title , n.message,   FROM_UNIXTIME( n.create_time , "%Y-%m-%d %H:%i") create_time     from tp_news n  '
                . '  where  n.is_delete = 1  '
                . ' ORDER  BY n.create_time  desc '
                . ' limit '  . $searchKey->startNum  . ','  . $searchKey->perPage ;
         $data =  $this->query($sql) ;
        return  $data ;
    }
}
