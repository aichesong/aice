<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:47:"./template/pc/rainbow/public\dispatch_jump.html";i:1507883317;s:40:"./template/pc/rainbow/public\header.html";i:1509706650;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/tpshop.css" />
    <script src="__STATIC__/js/jquery-1.11.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/global.js"></script>
    <script src="__STATIC__/js/common.js"></script>
</head>
<body>
<!--header-s-->
<div class="tpshop-tm-hander p">
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/base.css"/>
<div class="tpshop-tm-hander">
	<div class="top-hander clearfix">
		<div class="w1224 pr clearfix">
			<div class="fl">
				<?php if(strtolower(ACTION_NAME) != 'goodsinfo'): ?>
					<link rel="stylesheet" href="__STATIC__/css/location.css" type="text/css"><!-- 收货地址，物流运费 -->
					<div class="sendaddress pr fl">
					</div>
					<script src="__STATIC__/js/location.js"></script>
				<?php endif; ?>
				<div class="fl nologin">
					<a class="red" href="<?php echo U('Home/user/login'); ?>">登录</a>
				</div>
				<div class="fl islogin hide">
					<a class="red userinfo" href="<?php echo U('Home/user/index'); ?>"></a>
					<a  href="<?php echo U('Home/user/logout'); ?>"  title="退出" target="_self">安全退出</a>
				</div>
			</div>
			<ul class="top-ri-header fr clearfix">
				<li><a target="_blank" href="<?php echo U('Home/Order/order_list'); ?>">我的订单</a></li>
				<li class="spacer"></li>
				<li><a target="_blank" href="<?php echo U('Home/User/visit_log'); ?>">我的浏览</a></li>
				<li class="spacer"></li>
				<li><a target="_blank" href="<?php echo U('Home/User/goods_collect'); ?>">我的收藏</a></li>
				<li class="spacer"></li>
				<li><a target="_blank" href="<?php echo U('Home/User/agent'); ?>">代理管理中心</a></li>
			</ul>
		</div>
	</div>
	<div class="nav-middan-z w1224 clearfix">
		<a class="ecsc-logo" href="#"><img src="<?php echo $tpshop_config['shop_info_store_logo']; ?>"></a>
		<div class="ecsc-search">
			<form id="searchForm" name="" method="get" action="<?php echo U('Home/Goods/search'); ?>" class="ecsc-search-form">
				<input autocomplete="off"name="q" id="q" type="text" value="" class="ecsc-search-input" placeholder="请输入搜索关键字...">
				<button type="submit" class="ecsc-search-button">搜索</button>
				<div class="candidate p">
					<ul id="search_list"></ul>
				</div>
				<script type="text/javascript">
                    ;(function($){
                        $.fn.extend({
                            donetyping: function(callback,timeout){
                                timeout = timeout || 1e3;
                                var timeoutReference,
                                    doneTyping = function(el){
                                        if (!timeoutReference) return;
                                        timeoutReference = null;
                                        callback.call(el);
                                    };
                                return this.each(function(i,el){
                                    var $el = $(el);
                                    $el.is(':input') && $el.on('keyup keypress',function(e){
                                        if (e.type=='keyup' && e.keyCode!=8) return;
                                        if (timeoutReference) clearTimeout(timeoutReference);
                                        timeoutReference = setTimeout(function(){
                                            doneTyping(el);
                                        }, timeout);
                                    }).on('blur',function(){
                                        doneTyping(el);
                                    });
                                });
                            }
                        });
                    })(jQuery);

                    $('.ecsc-search-input').donetyping(function(){
                        search_key();
                    },500).focus(function(){
                        var search_key = $.trim($('#q').val());
                        if(search_key != ''){
                            $('.candidate').show();
                        }
                    });
                    $('.candidate').mouseleave(function(){
                        $(this).hide();
                    });

                    function searchWord(words){
                        $('#q').val(words);
                        $('#searchForm').submit();
                    }
                    function search_key(){
                        var search_key = $.trim($('#q').val());
                        if(search_key != ''){
                            $.ajax({
                                type:'post',
                                dataType:'json',
                                data: {key: search_key},
                                url:"<?php echo U('Home/Api/searchKey'); ?>",
                                success:function(data){
                                    if(data.status == 1){
                                        var html = '';
                                        $.each(data.result, function (n, value) {
                                            html += '<li onclick="searchWord(\''+value.keywords+'\');"><div class="search-item">'+value.keywords+'</div><div class="search-count">约'+value.goods_num+'个商品</div></li>';
                                        });
                                        html += '<li class="close"><div class="search-count">关闭</div></li>';
                                        $('#search_list').empty().append(html);
                                        $('.candidate').show();
                                    }else{
                                        $('#search_list').empty();
                                    }
                                }
                            });
                        }
                    }
				</script>
			</form>
			<div class="keyword clearfix">
				<?php if(is_array($tpshop_config['hot_keywords']) || $tpshop_config['hot_keywords'] instanceof \think\Collection || $tpshop_config['hot_keywords'] instanceof \think\Paginator): if( count($tpshop_config['hot_keywords'])==0 ) : echo "" ;else: foreach($tpshop_config['hot_keywords'] as $k=>$wd): ?>
					<a class="key-item" href="<?php echo U('Home/Goods/search',array('q'=>$wd)); ?>" target="_blank"><?php echo $wd; ?></a>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</div>
		<div class="u-g-cart fr" id="hd-my-cart">
			<a href="<?php echo U('Home/Cart/index'); ?>">
				<div class="c-n fl">
					<i class="share-shopcar-index"></i>
					<span>我的购物车</span>
					<em class="shop-nums" id="cart_quantity"></em>
				</div>
			</a>
			<div class="u-fn-cart" id="show_minicart">
				<div class="minicartContent" id="minicart">
				</div>
			</div>
		</div>
	</div>
	<div class="nav w1224 clearfix">
		<div class="categorys home_categorys">
			<div class="dt">
				<a href="" target="_blank"><i class="share-a_a2"></i>全部商品分类</a>
			</div>
			<!--全部商品分类-s-->
			<div class="dd">
				<div class="cata-nav" id="cata-nav">
					<?php if(is_array($goods_category_tree) || $goods_category_tree instanceof \think\Collection || $goods_category_tree instanceof \think\Paginator): $kr = 0; $__LIST__ = $goods_category_tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($kr % 2 );++$kr;?>
						<div class="item">
							<?php if($v[level] == 1): ?>
								<div class="item-left">
									<h3 class="cata-nav-name">
										<i><img src="/public/images/ico.png"></i>
										<a href="<?php echo U('Home/Goods/goodsList',array('id'=>$v[id])); ?>" title="<?php echo $v[name]; ?>"><?php echo $v[mobile_name]; ?></a>
										<!--<a href="" >手机店</a>-->
									</h3>
								</div>
							<?php endif; ?>
							<div class="cata-nav-layer">
								<div class="cata-nav-left">
									<div class="cata-layer-title">
										<?php if(is_array($v['hot_cate']) || $v['hot_cate'] instanceof \think\Collection || $v['hot_cate'] instanceof \think\Paginator): if( count($v['hot_cate'])==0 ) : echo "" ;else: foreach($v['hot_cate'] as $key=>$hc): ?>
											<a class="layer-title-item" href=""><?php echo $hc['name']; ?><i class="ico ico-arrow-right">></i></a>
										<?php endforeach; endif; else: echo "" ;endif; ?>
									</div>
									<div class="subitems">
										<?php if(is_array($v['tmenu']) || $v['tmenu'] instanceof \think\Collection || $v['tmenu'] instanceof \think\Paginator): if( count($v['tmenu'])==0 ) : echo "" ;else: foreach($v['tmenu'] as $k2=>$v2): if($v2[parent_id] == $v['id']): ?>
												<dl class="clearfix">
													<!-- id  =  分类id-->
													<dt><a href="<?php echo U('Home/Goods/goodsList',array('id'=>$v2[id])); ?>" target="_blank"><?php echo $v2[name]; ?></a></dt>
													<dd class="clearfix">
														<?php if(is_array($v2['sub_menu']) || $v2['sub_menu'] instanceof \think\Collection || $v2['sub_menu'] instanceof \think\Paginator): if( count($v2['sub_menu'])==0 ) : echo "" ;else: foreach($v2['sub_menu'] as $k3=>$v3): if($v3[parent_id] == $v2['id']): ?>
																<a href="<?php echo U('Home/Goods/goodsList',array('id'=>$v3[id])); ?>" target="_blank"><?php echo $v3[name]; ?></a>
															<?php endif; endforeach; endif; else: echo "" ;endif; ?>
													</dd>
												</dl>
											<?php endif; endforeach; endif; else: echo "" ;endif; ?>
									</div>
								</div>
								<div class="advertisement_down">
									<?php $pid =10+$kr;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1509706800 and end_time > 1509706800 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("5")->select();
if(is_array($ad_position) && !in_array($pid,array_keys($ad_position)) && $pid)
{
  M("ad_position")->insert(array(
         "position_id"=>$pid,
         "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ",
         "is_open"=>1,
         "position_desc"=>CONTROLLER_NAME."页面",
  ));
  delFile(RUNTIME_PATH); // 删除缓存
  \think\Cache::clear();  
}


$c = 5- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
if($c > 0 && I("get.edit_ad"))
{
    for($i = 0; $i < $c; $i++) // 还没有添加广告的时候
    {
      $result[] = array(
          "ad_code" => "/public/images/not_adv.jpg",
          "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid",
          "title"   =>"暂无广告图片",
          "not_adv" => 1,
          "target" => 0,
      );  
    }
}
foreach($result as $key=>$v3):       
    
    $v3[position] = $ad_position[$v3[pid]]; 
    if(I("get.edit_ad") && $v3[not_adv] == 0 )
    {
        $v3[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v3[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v3[ad_id]";        
        $v3[title] = $ad_position[$v3[pid]][position_name]."===".$v3[ad_name];
        $v3[target] = 0;
    }
    ?>
										<a href="<?php echo $v3[ad_link]; ?>" <?php if($v3['target'] == 1): ?>target="_blank"<?php endif; ?>>
										<img class="w-100" src="<?php echo $v3[ad_code]; ?>" title="<?php echo $v3[title]; ?>"/>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
				<script>
                    $('#cata-nav').find('.item').hover(function () {
                        $(this).addClass('nav-active').siblings().removeClass('nav-active');
                    },function () {
                        $(this).removeClass('nav-active');
                    })
				</script>
			</div>
			<!--全部商品分类-e-->
		</div>
		<ul class="navitems clearfix" id="navitems">
			<li>
				<a href="<?php echo U('Index/index'); ?>">首页</a>
			</li>
			<!--手机城、珠宝、家电城、促销商品 ....   原来是在这里查出来的-->
			<!--<?php
                                   
                                $md5_key = md5("SELECT * FROM `__PREFIX__navigation` where is_show = 1 ORDER BY `sort` DESC");
                                $result_name = $sql_result_v = S("sql_".$md5_key);
                                if(empty($sql_result_v))
                                {                            
                                    $result_name = $sql_result_v = \think\Db::query("SELECT * FROM `__PREFIX__navigation` where is_show = 1 ORDER BY `sort` DESC"); 
                                    S("sql_".$md5_key,$sql_result_v,86400);
                                }    
                              foreach($sql_result_v as $k=>$v): ?>-->
				<!--<li><a href="<?php echo $v[url]; ?>" <?php if($v[is_new] == 1): ?>target="_blank" <?php endif; ?> ><?php echo $v[name]; ?></a></li>-->
			<!--<?php endforeach; ?>-->
		</ul>
	</div>
</div>
<script>
    $('#navitems').find('li').eq(0).addClass('selected');
    $('#navitems').find('li').click(function () {
        $(this).addClass('selected').siblings().removeClass('selected');
    });
</script>
</div>
<!--header-e-->
<div class="operation_success_fail w710" >
    <?php if($code == 1) {?>
    <!--操作成功-s--->
    <div class="boxoperation p" >
        <div class="success_fial_img fl">
            <img src="__STATIC__/images/right_06.jpg"/>
        </div>
        <div class="success_describe fl">
            <div class="sd1">
                <i class="suc"></i>
                <span><?php echo(strip_tags($msg)); ?></span>
            </div>
            <div class="sd2">
                <a id="href" href="<?php echo($url); ?>">页面跳转中...</a>
                <span>等待时间：<em id="wait"><?php echo($wait); ?></em></span>
            </div>
            <div class="sd3">
                <a href="/">首页</a>
                <a href="/index.php?m=Home&c=Cart&a=index">购物车</a>
                <a href="/index.php?m=Home&c=User&a=index">用户中心</a>
            </div>
        </div>
    </div>
    <!--操作成功-s--->
<?php }else{?>
    <!--操作失败-s--->
    <div class="boxoperation p" >
        <div class="success_fial_img fl">
            <img src="__STATIC__/images/wrong_05.jpg"/>
        </div>
        <div class="success_describe fl">
            <div class="sd1">
                <i class="wro"></i>
                <span><?php echo(strip_tags($msg)); ?></span>
            </div>
            <div class="sd2">
                <a id="href" href="<?php echo($url); ?>">页面跳转中...</a>
                <span>等待时间：<em id="wait"><?php echo($wait); ?></em></span>
            </div>
            <div class="sd3">
                <a href="/">首页</a>
                <a href="/index.php?m=Home&c=Cart&a=index">购物车</a>
                <a href="/index.php?m=Home&c=User&a=index">用户中心</a>
            </div>
        </div>
    </div>
    <!--操作失败-e--->
    <?php }?>
</div>
<script src="__STATIC__/js/headerfooter.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    /**/
    (function () {
        var wait = document.getElementById('wait'), href = document.getElementById('href').href;
        var interval = setInterval(function () {
            var time = --wait.innerHTML;
            if (time <= 0) {
                location.href = href;
                clearInterval(interval);
            }
            ;
        }, 1000);
    })();

</script>
</body>
</html>