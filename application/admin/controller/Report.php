<?php


namespace app\admin\controller;
use app\admin\logic\GoodsLogic;
use think\Db;
use think\Page;

class Report extends Base{
	public $begin;
	public $end;
	public function _initialize(){
        parent::_initialize();
		
		if(I('start_time')){
           $begin = I('start_time');
           $end = I('end_time');
		}else{
           $begin = date('Y-m-d', strtotime("-3 month"));//30天前
           $end = date('Y-m-d', strtotime('+1 days'));
		}
		$this->assign('start_time',$begin);
		$this->assign('end_time',$end);
		$this->begin = strtotime($begin);
		$this->end = strtotime($end)+86399;
	}
	
	public function index(){
		$now = strtotime(date('Y-m-d'));
		$today['today_amount'] = M('order')->where("add_time>$now AND (pay_status=1 or pay_code='cod') and order_status in(1,2,4)")->sum('order_amount');//今日销售总额
		$today['today_order'] = M('order')->where("add_time>$now and (pay_status=1 or pay_code='cod')")->count();//今日订单数
		$today['cancel_order'] = M('order')->where("add_time>$now AND order_status=3")->count();//今日取消订单
		if ($today['today_order'] == 0) {
			$today['sign'] = round(0, 2);
		} else {
			$today['sign'] = round($today['today_amount'] / $today['today_order'], 2);
		}
		$this->assign('today',$today);
		$sql = "SELECT COUNT(*) as tnum,sum(order_amount) as amount, FROM_UNIXTIME(add_time,'%Y-%m-%d') as gap from  __PREFIX__order ";
		$sql .= " where add_time>$this->begin and add_time<$this->end AND (pay_status=1 or pay_code='cod') and order_status in(1,2,4) group by gap ";
		$res = DB::query($sql);//订单数,交易额
		
		foreach ($res as $val){
			$arr[$val['gap']] = $val['tnum'];
			$brr[$val['gap']] = $val['amount'];
			$tnum += $val['tnum'];
			$tamount += $val['amount'];
		}

		for($i=$this->begin;$i<=$this->end;$i=$i+24*3600){
			$tmp_num = empty($arr[date('Y-m-d',$i)]) ? 0 : $arr[date('Y-m-d',$i)];
			$tmp_amount = empty($brr[date('Y-m-d',$i)]) ? 0 : $brr[date('Y-m-d',$i)];
			$tmp_sign = empty($tmp_num) ? 0 : round($tmp_amount/$tmp_num,2);						
			$order_arr[] = $tmp_num;
			$amount_arr[] = $tmp_amount;			
			$sign_arr[] = $tmp_sign;
			$date = date('Y-m-d',$i);
			$list[] = array('day'=>$date,'order_num'=>$tmp_num,'amount'=>$tmp_amount,'sign'=>$tmp_sign,'end'=>date('Y-m-d',$i+24*60*60));
			$day[] = $date;
		}
		rsort($list);
		$this->assign('list',$list);
		$result = array('order'=>$order_arr,'amount'=>$amount_arr,'sign'=>$sign_arr,'time'=>$day);
		$this->assign('result',json_encode($result));
		return $this->fetch();
	}

    //	机构列表
    public function area(){
        $sql = "select a.user_id,a.mobile,from_unixtime(a.reg_time,'%Y-%m-%d') as reg_time,a.nickname ,b.name from __PREFIX__users  a";
        $sql .=" left join __PREFIX__region b on a.district=b.id  where is_agent = 2  order by reg_time DESC limit 100";
        $res = DB::cache(true,3600)->query($sql);
        $this->assign('list',$res);
        return $this->fetch();
    }

    public function organization(){
        $sql = M('inst')->select();
        $this->assign('sql',$sql);
        return $this->fetch();
    }

    public function orList(){
        $add = array();
        $inst = M('inst')->where('inst_id','=',$_GET['inst_id'])->find();
        $sql = M('inst')->select();
        //  获取省份
        $province = M('region')->where(array('parent_id'=>0,'level'=>1))->select();
        //  获取机构城市
        $city =  M('region')->where(array('level'=>2))->select();
        //  获取机构地区
        $area =  M('region')->where(array('level'=>3))->select();
        //管理ID
        $admin = M('admin')->select();
        if(IS_POST){
            $arr=[
                'inst_type' => $_POST['inst_type'],
                'inst_name' => $_POST['inst_name'],
                'parent_inst' => $_POST['parent_inst'],
                'plat_admin_id' => $_POST['plat_admin_id'],
                'contact_user'  => $_POST['contact_user'],
                'contact_phone' => $_POST['contact_phone'],
                'contact_addr'  => $_POST['contact_addr'],
                'open_status'   => $_POST['open_status'],
                'add_time'      =>time()
            ];
            if($_POST['province'] == null ){
                $arr['province'] = 0;
            }else{
                $arr['province']=$_POST['province'];
            }
            if($_POST['city'] == null){
                $arr['city'] =0;
            }else{
                $arr['city'] =$_POST['city'];
            }
            if($_POST['area'] == null || $_POST['area'] =='选择区域'){
                $arr['area'] =0;
            }else{
                $arr['area'] = $_POST['area'];
            }
            $a=M('inst')->where('inst_id','=',$_POST['inst_id'])->save($arr);
            if($a){
                $this->success('操作成功',U('Admin/Report/organization'));
            }else{
                $this->success('操作失败',U('Admin/Report/organization'));
            }
        }
        $this->assign('admin',$admin);
        $this->assign('province',$province);
        $this->assign('city',$city);
        $this->assign('area',$area);
        $this->assign('sql',$sql);
        $this->assign('inst',$inst);
        return $this->fetch();
    }



    public function add_or(){
        $add = array();
        //  获取省份
        $province = M('region')->where(array('parent_id'=>0,'level'=>1))->select();
        //  获取订单城市
        $city =  M('region')->where(array('parent_id'=>$add['province'],'level'=>2))->select();
        //  获取订单地区
        $area =  M('region')->where(array('parent_id'=>$add['city'],'level'=>3))->select();

        //上级机构
        $sql = M('inst')->select();
        //管理ID
        $admin = M('admin')->select();
        if(IS_POST){
            $arr=[
                'inst_type' => $_POST['inst_type'],
                'inst_name' => $_POST['inst_name'],
                'parent_inst' => $_POST['parent_inst'],
                'plat_admin_id' => $_POST['admin_id'],
                'contact_user'  => $_POST['contact_user'],
                'contact_phone' => $_POST['contact_phone'],
                'contact_addr'  => $_POST['contact_addr'],
                'open_status'   => $_POST['open_status'],
                'add_time'      =>time()
            ];
            if($_POST['province'] == null ){
                $arr['province'] = 0;
            }else{
                $arr['province']=$_POST['province'];
            }
            if($_POST['city'] == null){
                $arr['city'] =0;
            }else{
                $arr['city'] =$_POST['city'];
            }
            if($_POST['area'] == null || $_POST['area'] =='选择区域'){
                $arr['area'] =0;
            }else{
                $arr['area'] = $_POST['area'];
            }
            $a=M('inst')->add($arr);
            if($a){
                $this->success('操作成功',U('Admin/Report/organization'));
            }else{
                $this->success('操作失败',U('Admin/Report/organization'));
            }
        }
        $this->assign('admin',$admin);
        $this->assign('sql',$sql);
        $this->assign('province',$province);
        $this->assign('city',$city);
        $this->assign('area',$area);
        return $this->fetch();
    }

    public function referrer(){
        //机构
        $sql = M('inst a')->join('referrer b','a.inst_id = b.inst_id')->join('users c','b.user_id = c.user_id')->select();
        $this->assign('ref',$sql);
        return $this->fetch();
    }

    public function addRef(){
        $sql = M('inst')->select();
        if(IS_POST){
            $arr=[
                'inst_id' => $_POST['inst_id'],
                'user_id' => $_POST['user_id'],
                'open_status'   => $_POST['open_status'],
                'add_time'      =>time()
            ];
            $a=M('referrer')->add($arr);
            if($a){
                $this->success('操作成功',U('Admin/Report/referrer'));
            }else{
                $this->success('操作失败',U('Admin/Report/referrer'));
            }
        }
        $this->assign('sql',$sql);
        return $this->fetch();
    }
    public  function refEdit(){
        //机构
        $sql = M('inst')->select();
        $ref=M('inst a')->join('referrer b','a.inst_id = b.inst_id')->join('users c','b.user_id = c.user_id')->where('id','=',$_GET['id'])->find();
        if(IS_POST){
            $arr=[
                'inst_id' => $_POST['inst_id'],
                'user_id' => $_POST['user_id'],
                'open_status'   => $_POST['open_status'],
            ];
            $a=M('referrer')->where('id','=',$_GET['id'])->save($arr);
            if($a){
                $this->success('操作成功',U('Admin/Report/referrer'));
            }else{
                $this->success('操作失败',U('Admin/Report/referrer'));
            }
        }
        $this->assign('sql',$sql);
        $this->assign('ref',$ref);
        return $this->fetch();
    }

    //	市代理列表
    public function agent(){
        $sql = "select a.user_id,a.mobile,from_unixtime(a.reg_time,'%Y-%m-%d') as reg_time,a.nickname ,b.name from __PREFIX__users  a";
        $sql .=" left join __PREFIX__region b on a.city=b.id  where is_agent = 1  order by reg_time DESC limit 100";
        $res = DB::cache(true,3600)->query($sql);
        $this->assign('list',$res);
        return $this->fetch();
    }

	public function saleTop(){
		$sql = "select goods_name,goods_sn,sum(goods_num) as sale_num,sum(goods_num*goods_price) as sale_amount from __PREFIX__order_goods ";
		$sql .=" where is_send = 1 group by goods_id order by sale_amount DESC limit 100";
		$res = DB::cache(true,3600)->query($sql);
		$this->assign('list',$res);
		return $this->fetch();
	}
	
	public function userTop(){

		$mobile = I('mobile');
		$email = I('email');
		if($mobile){
			$where =  "and b.mobile='$mobile'";
		}		
		if($email){
			$where = "and b.email='$email'";
		}

		if(empty($where)){
			$count = M('order')->where("add_time>$this->begin and add_time<$this->end and pay_status=1")->group('user_id')->count();
			$Page = new Page($count,20);
			$show = $Page->show();
			$this->assign('page',$show);
		}else{
			$sql = "select count(a.order_id) as order_num,sum(a.order_amount) as amount,a.user_id,b.mobile,b.email,b.nickname from __PREFIX__order as a left join __PREFIX__users as b ";
			$sql .= " on a.user_id = b.user_id where a.add_time>$this->begin and a.add_time<$this->end and a.pay_status=1 $where group by user_id order by amount DESC limit 0,100";
			$res = DB::cache(true)->query($sql);
			$this->assign('list',$res);
		}
		return $this->fetch();
	}
	
	public function saleList(){		 
		$cat_id = I('cat_id',0);
		$brand_id = I('brand_id',0);
		$where = "where b.add_time>$this->begin and b.add_time<$this->end ";
		if($cat_id>0){
			$where .= " and g.cat_id=$cat_id";
			$this->assign('cat_id',$cat_id);
		}
		if($brand_id>0){
			$where .= " and g.brand_id=$brand_id";
			$this->assign('brand_id',$brand_id);
		}
                
		$sql2 = "select count(*) as tnum from __PREFIX__order_goods as a left join __PREFIX__order as b on a.order_id=b.order_id ";
		$sql2 .= " left join __PREFIX__goods as g on a.goods_id = g.goods_id $where";
		$total = DB::query($sql2);
		$count =  $total[0]['tnum'];
		$Page = new Page($count,20);
		$show = $Page->show();                
                
		$sql = "select a.*,b.order_sn,b.shipping_name,b.pay_name,b.add_time from __PREFIX__order_goods as a left join __PREFIX__order as b on a.order_id=b.order_id ";
		$sql .= " left join __PREFIX__goods as g on a.goods_id = g.goods_id $where ";
		$sql .= "  order by add_time desc limit {$Page->firstRow},{$Page->listRows}";
		$res = DB::query($sql);
		$this->assign('list',$res);		
		$this->assign('page',$show);
		
                $GoodsLogic = new GoodsLogic();        
                $brandList = $GoodsLogic->getSortBrands();
                $categoryList = $GoodsLogic->getSortCategory();
                $this->assign('categoryList',$categoryList);
                $this->assign('brandList',$brandList);
                return $this->fetch();
	}
	
	public function user(){
		$today = strtotime(date('Y-m-d'));
		$month = strtotime(date('Y-m-01'));
		$user['today'] = D('users')->where("reg_time>$today")->count();//今日新增会员
		$user['month'] = D('users')->where("reg_time>$month")->count();//本月新增会员
		$user['total'] = D('users')->count();//会员总数
		$user['user_money'] = D('users')->sum('user_money');//会员余额总额
		$res = M('order')->cache(true)->distinct(true)->field('user_id')->select();
		$user['hasorder'] = count($res);
		$this->assign('user',$user);
		$sql = "SELECT COUNT(*) as num,FROM_UNIXTIME(reg_time,'%Y-%m-%d') as gap from __PREFIX__users where reg_time>$this->begin and reg_time<$this->end group by gap";
		$new = DB::query($sql);//新增会员趋势
		foreach ($new as $val){
			$arr[$val['gap']] = $val['num'];
		}
		
		for($i=$this->begin;$i<=$this->end;$i=$i+24*3600){
			$brr[] = empty($arr[date('Y-m-d',$i)]) ? 0 : $arr[date('Y-m-d',$i)];
			$day[] = date('Y-m-d',$i);
		}		
		$result = array('data'=>$brr,'time'=>$day);
		$this->assign('result',json_encode($result));					
		return $this->fetch();
	}
	
	//财务统计
	public function finance(){
		$sql = "SELECT sum(b.goods_num*b.member_goods_price) as goods_amount,sum(a.shipping_price) as shipping_amount,sum(b.goods_num*b.cost_price) as cost_price,";
		$sql .= "sum(a.coupon_price) as coupon_amount,FROM_UNIXTIME(a.add_time,'%Y-%m-%d') as gap from  __PREFIX__order a left join __PREFIX__order_goods b on a.order_id=b.order_id ";
		$sql .= " where a.add_time>$this->begin and a.add_time<$this->end AND a.pay_status=1 and a.shipping_status=1 and b.is_send=1 group by gap order by a.add_time";
		$res = DB::cache(true)->query($sql);//物流费,交易额,成本价
		
		foreach ($res as $val){
			$arr[$val['gap']] = $val['goods_amount'];
			$brr[$val['gap']] = $val['cost_price'];
			$crr[$val['gap']] = $val['shipping_amount'];
			$drr[$val['gap']] = $val['coupon_amount'];
		}
			
		for($i=$this->begin;$i<=$this->end;$i=$i+24*3600){
			$date = $day[] = date('Y-m-d',$i);
			$tmp_goods_amount = empty($arr[$date]) ? 0 : $arr[$date];
			$tmp_cost_amount = empty($brr[$date]) ? 0 : $brr[$date];
			$tmp_shipping_amount = empty($crr[$date]) ? 0 : $crr[$date];
			$tmp_coupon_amount = empty($drr[$date]) ? 0 : $drr[$date];
			
			$goods_arr[] = $tmp_goods_amount;
			$cost_arr[] = $tmp_cost_amount;
			$shipping_arr[] = $tmp_shipping_amount;
			$coupon_arr[] = $tmp_coupon_amount;
			$list[] = array('day'=>$date,'goods_amount'=>$tmp_goods_amount,'cost_amount'=>$tmp_cost_amount,
					'shipping_amount'=>$tmp_shipping_amount,'coupon_amount'=>$tmp_coupon_amount,'end'=>date('Y-m-d',$i+24*60*60));
		}
                rsort($list);
		$this->assign('list',$list);
		$result = array('goods_arr'=>$goods_arr,'cost_arr'=>$cost_arr,'shipping_arr'=>$shipping_arr,'coupon_arr'=>$coupon_arr,'time'=>$day);
		$this->assign('result',json_encode($result));
		return $this->fetch();
	}
	
	public function expense_log(){
		$map = array();
		$begin = strtotime(I('add_time_begin'));
		$end = strtotime(I('add_time_end'));
		$admin_id = I('admin_id');
		if($begin && $end){
			$map['addtime'] = array('between',"$begin,$end");
		}
		if($admin_id){
			$map['admin_id'] = $admin_id;
		}
		$count = M('expense_log')->where($map)->count();
		$page = new Page($count);
		$lists  = M('expense_log')->where($map)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('page',$page->show());
		$this->assign('total_count',$count);
		$this->assign('list',$lists);
		$admin = M('admin')->getField('admin_id,user_name');
		$this->assign('admin',$admin);
		$typeArr = array('会员提现','订单退款','商品退款','其他');
		$this->assign('typeArr',$typeArr);
		return $this->fetch();
	}
}