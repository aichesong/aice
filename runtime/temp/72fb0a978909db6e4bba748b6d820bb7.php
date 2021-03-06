<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:37:"./template/pc/rainbow/cart\index.html";i:1509695679;s:45:"./template/pc/rainbow/public\sign-header.html";i:1509676922;s:40:"./template/pc/rainbow/public\footer.html";i:1507883317;}*/ ?>
<!DOCTYPE html>
<html id="ng-app">
<head lang="zh">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/tpshop.css" />
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/base.css"/>
    <title>购物车-<?php echo $tpshop_config['shop_info_store_title']; ?></title>
    <meta name="keywords" content="<?php echo $tpshop_config['shop_info_store_keyword']; ?>" />
    <meta name="description" content="<?php echo $tpshop_config['shop_info_store_desc']; ?>" />
    <link href="__STATIC__/css/common.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="__STATIC__/css/jh.css">
    <script src="__STATIC__/js/jquery-1.11.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/global.js"></script>
    <script src="__PUBLIC__/js/pc_common.js"></script>
    <script src="__PUBLIC__/js/layer/layer.js"></script>
</head>
<style>
    a.disable {
        cursor: default;
        color: #e9e9e9;
    }
</style>
<body class="ng-scope">
<!-- 头部顶栏 start [[-->
<div class="m-top-bar editable" moduleid="1539923" style="position:relative;min-height:25px;">
    <div class="container">
        <ul class="fl">
            <div class="ls-dlzc fl nologin">
                <a href="<?php echo U('Home/user/login'); ?>">Hi,请登录</a>
            </div>
            <div class="ls-dlzc fl islogin">
                <a class="red userinfo" href="<?php echo U('Home/user/index'); ?>"></a>
                <a href="<?php echo U('Home/user/logout'); ?>">退出</a>
            </div>
            <script>
                $(function (){
                    var uname = getCookie('uname');
                    if (uname == '') {
                        $('.islogin').remove();
                        $('.nologin').show();
                    } else {
                        $('.nologin').remove();
                        $('.islogin').show();
                        $('.userinfo').html(decodeURIComponent(uname).substring(0,5));
                    }
                })

            </script>
            <li class="fl sep"></li>
        </ul>
        <ul class="fr bar-right">
            <li class="fl dropdown my-feiniu"><a class="menu-item" target="_blank" href="<?php echo U('/Home/User/index'); ?>">
                <span>商城</span><i class="dd"></i></a>
                <ul class="sub-panel">
                    <li><a class="J_chgurl" target="_blank" href="<?php echo U('Home/Order/order_list'); ?>">我的订单</a></li>
                    <li><a class="J_chgurl" target="_blank" href="<?php echo U('Home/User/goods_collect'); ?>">我的收藏夹</a></li>
                </ul>
            </li>
            <li class="fl sep"></li>
        </ul>
    </div>
</div>
<!-- 头部顶栏 end ]]-->
<div class="fn-cart-clearing">
    <div class="wrapper1190">
        <!-- cart-title -->
        <div class="order-header">
            <div class="layout after">
                <div class="fl">
                    <div class="logo pa-to-36 wi345"> <a href="/"><img src="__PUBLIC__/images/newLogo.png" alt=""></a> </div>
                </div>
                <div class="fr">
                    <div class="pa-to-36 progress-area">
                        <div class="progress-area-wd"></div>
                        <div class="progress-area-tx" style="display:none"></div>
                        <div class="progress-area-cg" style="display:none"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end cart-title -->
        <div class="ui_tab">
            <!-- ngIf: !status.overseasEmpty -->
            <div class="ui_tab_content">
                <div class="clearing-c cart-content">
                    <div class="layout after-ta">
                        <div class="sc-list">
                                <p class="shopcar_empty" <?php if(empty($cartList) || (($cartList instanceof \think\Collection || $cartList instanceof \think\Paginator ) && $cartList->isEmpty())): ?>style="text-align:center"<?php else: ?>style="display: none"<?php endif; ?> >
                                    <a href="/"><img src="__STATIC__/images/null_cart2.jpg"/></a>
                                </p>
                        <?php if(!(empty($cartList) || (($cartList instanceof \think\Collection || $cartList instanceof \think\Paginator ) && $cartList->isEmpty()))): ?>
                            <div class="sc-pro-list" id="tpshop-cart">
                                <table width="100%" border="0" cellspacing="0" cellpadding="1">
                                    <tr class="ba-co-danhui">
                                        <th class="pa-le-9" align="center" valign="middle">&nbsp;&nbsp;</th>
                                        <th align="center" valign="middle" colspan="2">商品</th>
                                        <th align="center" valign="middle">官方指导价（元）</th>
                                        <th align="center" valign="middle">爱车送销售价（元）</th>
                                        <th align="center" valign="middle">提车手续费（元）</th>
                                        <th align="center" valign="middle">操作</th>
                                    </tr>
                                    <?php if(is_array($cartList) || $cartList instanceof \think\Collection || $cartList instanceof \think\Paginator): $i = 0; $__LIST__ = $cartList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cart): $mod = ($i % 2 );++$i;?>
                                        <tr class="item-single" id="edge_<?php echo $cart['id']; ?>">
                                            <td class="pa-le-9" style="border-right:0" align="center" valign="middle">
                                                <input class="check-box checkCart checkCartItem" name="checkItem" value="<?php echo $cart['id']; ?>" type="checkbox" <?php if($cart[selected] == 1): ?>checked="checked"<?php endif; ?>>
                                            </td>
                                            <td style="border-left:0px;;border-right:0px" class="pa-to-20 pa-bo-20 bo-ri-0" width="80px" align="center" valign="top">
                                                <a class="gwc-wp-list di-bl wi63 hi63" href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$cart[goods_id])); ?>">
                                                    <img class="wi63 hi63" src="<?php echo goods_thum_images($cart['goods_id'],78,78); ?>">
                                                </a>
                                            </td>
                                            <td style="border-left:0px; border-right:0px"  class="pa-to-20 wi516" align="left">
                                                <p class="gwc-ys-pp">
                                                    <a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$cart[goods_id])); ?>" style="vertical-align:middle"><?php echo $cart['goods_name']; ?></a>
                                                    <!--团购--><?php if($cart[prom_type] == 2): ?><img  width="80" height="60" src="/public/images/groupby2.jpg" style="vertical-align:middle"><?php endif; ?>
                                                    <!--抢购--><?php if($cart[prom_type] == 1): ?><img  width="40" height="40" src="/public/images/qianggou2.jpg" style="vertical-align:middle"><?php endif; ?>
                                                </p>
                                                <p class="ggwc-ys-hs"><?php echo $cart['spec_key_name']; ?></p>
                                            </td>
                                            <td style="border-left:0px" align="center" valign="middle"><span>￥<?php echo $cart['market_price']; ?></span></td>
                                            <td style="border-left:0px" align="center" valign="middle" id="cart_<?php echo $cart['id']; ?>_goods_price"><span>￥<?php echo $cart['goods_price']; ?></span></td>
                                            <td style="border-left:0px" align="center" valign="middle"><span>￥3000</span></td>

                                            <!--<td align="center" valign="middle" class="quantity-form">-->
                                                <!--<div class="sc-stock-area">-->
                                                    <!--<div class="stock-area">-->
                                                            <!--<input class="wi43 fl" name="changeQuantity_<?php echo $cart['id']; ?>" type="text" id="changeQuantity_<?php echo $cart['id']; ?>" value="<?php echo $cart['goods_num']; ?>">-->
                                                    <!--</div>-->
                                                <!--</div>-->
                                            <!--</td>-->
                                            <td align="center" valign="middle"><a class="gwc-gb deleteGoods" data-cart-id="<?php echo $cart['id']; ?>" href="javascript:void(0);"></a></td>
                                        </tr>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </table>
                            </div>
                            <div class="sc-total-list ma-to-20 sc-pro-list">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class="pa-le-28 gwx-xm-dwz">
                                            <label >
                                                <input type="checkbox" class="checkCart checkCartAll"/>
                                            </label>
                                            <a href="javascript:void(0);" id="removeGoods"></a>
                                        </td>
                                        <td width="190" align="right"></td>
                                        <td width="69" align="right" id="goods_num"></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td width="190" align="right">支付提车手续费：</td>
                                        <td width="69" align="right" id="commission"><em>￥3000</em></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="sc-acti-list ma-to-20 ">
                                <a class="gwc-qjs" href="javascript:void(0)" data-url="<?php echo U('Home/Cart/cart2'); ?>">立即提车</a>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearing-recommend wrapper1190">
            <div class="cr-block-01 cr-block-preferbuy ng-scope ng-isolate-scope">
                <div class="cr-title" data-ys="0">
                    <ul class="fn-tab-nav fn-fl">
                        <li class="ng-scope"><a class="ng-binding titleon">为您推荐</a></li>
                    </ul>
                </div>
                <div class="cr-list-out ng-isolate-scope" data-is-show="true" data-type="1" data-index="tabData.listIndex" data-show-close-btn="false" data-extra-class="">
                    <div class="cr-list fixed">
                        <div class="slide-wrapper ng-scope">
                            <ul class="ng-scope">
                                <?php
                                   
                                $md5_key = md5("select * from `__PREFIX__goods` where  is_recommend = 1 limit 10");
                                $result_name = $sql_result_v = S("sql_".$md5_key);
                                if(empty($sql_result_v))
                                {                            
                                    $result_name = $sql_result_v = \think\Db::query("select * from `__PREFIX__goods` where  is_recommend = 1 limit 10"); 
                                    S("sql_".$md5_key,$sql_result_v,86400);
                                }    
                              foreach($sql_result_v as $k=>$v): ?>
                                    <li class="ng-scope">
                                        <a href="<?php echo U('/Home/Goods/goodsInfo',array('id'=>$v[goods_id])); ?>"><img ng-src="<?php echo goods_thum_images($v['goods_id'],80,80); ?>" alt="<?php echo $v[goods_name]; ?>" src="<?php echo goods_thum_images($v['goods_id'],80,80); ?>"></a>
                                        <p><a class="ng-binding" href="<?php echo U('/Home/Goods/goodsInfo',array('id'=>$v[goods_id])); ?>"><?php echo $v[goods_name]; ?></a></p>
                                        <div class="div-01">
                                            <em>¥</em>
                                            <span  class="ng-binding"><?php echo $v[shop_price]; ?></span>
                                        </div>
                                        <button class="btn add2cart" type="button" onclick="javascript:AjaxAddCart(<?php echo $v['goods_id']; ?>,1,1);">立即提车</button>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--footer-s-->
    <div class="tpshop-service">
	<ul class="w1224 clearfix">
		<li>
			<i class="ico ico-day7"></i>
			<p class="service">7天无理由退货</p>
		</li>
		<li>
			<i class="ico ico-day15"></i>
			<p class="service">15天免费换货</p>
		</li>
		<li>
			<i class="ico ico-quality"></i>
			<p class="service">正品行货 品质保障</p>
		</li>
		<li>
			<i class="ico ico-service"></i>
			<p class="service">专业售后服务</p>
		</li>
	</ul>
</div>
<div class="footer">
	<div class="w1224 clearfix">
		<div class="left-help-list clearfix">
		<?php
                                   
                                $md5_key = md5("select * from `__PREFIX__article_cat` where parent_id = 2 limit 5");
                                $result_name = $sql_result_v = S("sql_".$md5_key);
                                if(empty($sql_result_v))
                                {                            
                                    $result_name = $sql_result_v = \think\Db::query("select * from `__PREFIX__article_cat` where parent_id = 2 limit 5"); 
                                    S("sql_".$md5_key,$sql_result_v,86400);
                                }    
                              foreach($sql_result_v as $k=>$v): ?>
			<dl>
				<dt><?php echo $v[cat_name]; ?></dt>
				<?php
                                   
                                $md5_key = md5("select * from `__PREFIX__article` where cat_id = $v[cat_id]  and is_open=1 limit 5");
                                $result_name = $sql_result_v2 = S("sql_".$md5_key);
                                if(empty($sql_result_v2))
                                {                            
                                    $result_name = $sql_result_v2 = \think\Db::query("select * from `__PREFIX__article` where cat_id = $v[cat_id]  and is_open=1 limit 5"); 
                                    S("sql_".$md5_key,$sql_result_v2,86400);
                                }    
                              foreach($sql_result_v2 as $k2=>$v2): ?>
				<dd><a href="<?php echo U('Home/Article/detail',array('article_id'=>$v2[article_id])); ?>"><?php echo $v2[title]; ?></a></dd>
				<?php endforeach; ?>
			</dl>
		<?php endforeach; ?>	
		</div>
		<div class="right-contact-us">
			<h3 class="title">联系我们</h3>
			<span class="phone"><?php echo $tpshop_config['shop_info_phone']; ?></span>
			<p class="tips">周一至周日8:00-18:00<br />(仅收市话费)</p>
			<div class="qr-code-list clearfix">
				<a class="qr-code" href="javascript:;"><img class="w-100" src="__STATIC__/images/qrcode.png" alt="" /></a>
				<a class="qr-code qr-code-tpshop" href="javascript:;"><img class="w-100" src="__STATIC__/images/qrcode.png" alt="" /></a>
			</div>
		</div>
	</div>
</div>
    <!--footer-e-->
    <script>
        $(document).ready(function(){
            initDecrement();
            initCheckBox();
            AsyncUpdateCart();
        });
        //购物车对象
        function CartItem(id, goods_num,selected) {
            this.id = id;
            this.goods_num = goods_num;
            this.selected = selected;
        }
        //初始化计算订单价格
        function AsyncUpdateCart(){
            var cart = new Array();
            var inputCheckItem = $("input[name^='checkItem']");
            inputCheckItem.each(function(i,o){
                var id = $(this).attr("value");
                var goods_num = $(this).parents('.item-single').find("input[id^='changeQuantity']").attr('value');
                if ($(this).attr("checked") == 'checked') {
                    var cartItemCheck = new CartItem(id,goods_num,1);
                    cart.push(cartItemCheck);
                }else{
                    var cartItemNoCheck = new CartItem(id,goods_num,0);
                    cart.push(cartItemNoCheck);
                }
            })
            $.ajax({
                type : "POST",
                url:"<?php echo U('Home/Cart/AsyncUpdateCart'); ?>",//,
                dataType:'json',
                data: {cart: cart},
                success: function(data){
                    if(data.status == 1){
                        $('#goods_num').empty().html(data.result.goods_num+"件商品");
                        $('#total_fee').empty().html('￥'+data.result.total_fee);
                        $('#goods_fee').empty().html('-￥'+data.result.goods_fee);
                        var cartList =  data.result.cartList;
                        if(cartList.length > 0){
                            for(var i = 0; i < cartList.length; i++){
                                $('#cart_'+cartList[i].id+'_goods_price').empty().html('￥'+cartList[i].goods_price);
                                $('#cart_'+cartList[i].id+'_total_price').empty().html('￥'+cartList[i].total_fee);
                                $('#cart_'+cartList[i].id+'_market_price').empty().html('￥'+(cartList[i].member_goods_price*cartList[i].goods_num).toFixed(2)); //活动价格
                            }
                        }else{
                            $('.total_price').empty();
                            $('.cut_price').empty();
                        }
                    }
                }
            });
        }
        //减购买数量事件
        $(function () {
            $(document).on("click", '.decrement', function (e) {
                var changeQuantityNum = $(this).parent().find('input').val();
                if (changeQuantityNum > 1) {
                    $(this).parent().find('input').attr('value', parseInt(changeQuantityNum) - 1).val(parseInt(changeQuantityNum) -1);
                }
                initDecrement();
                changeNum(this);
            })
        })
        //加购买数量事件
        $(function () {
            $(document).on("click", '.increment', function (e) {
                var changeQuantityNum = $(this).parent().find('input').val();
                $(this).parent().find('input').attr('value', parseInt(changeQuantityNum) + 1).val(parseInt(changeQuantityNum) + 1);
                initDecrement();
                changeNum(this);
            })
        })
        //手动输入购买数量
        $(function () {
            $(document).on("blur", '.quantity-form input', function (e) {
                var changeQuantityNum = parseInt($(this).val());
                if(changeQuantityNum <= 0){
                    layer.alert('商品数量必须大于0', {icon:2});
                    $(this).val($(this).attr('value'));
                }else{
                    $(this).attr('value', changeQuantityNum);
                }
                initDecrement();
                changeNum(this);
            })
        })
        //更改购买数量对减购买数量按钮的操作
        function initDecrement(){
            $("input[id^='changeQuantity']").each(function(i,o){
                if($(o).val() == 1){
                    $(o).parent().find('.decrement').addClass('disable');
                }
                if($(o).val() > 1){
                    $(o).parent().find('.decrement').removeClass('disable');
                }
            })
        }
        //更改购物车请求事件
        function changeNum(obj){
            var input = $(obj).parents('.quantity-form').find('input');
            var cart_id = input.attr('id').replace('changeQuantity_','');
            var goods_num = input.attr('value');
            var cart = new CartItem(cart_id, goods_num, 1);
            $.ajax({
                type: "POST",
                url: "<?php echo U('Home/Cart/changeNum'); ?>",//+tab,
                dataType: 'json',
                data: {cart: cart},
                success: function (data) {
                    if(data.status == 1){
                        AsyncUpdateCart();
                    }else{
                        input.val(data.result.limit_num);
                        input.attr('value',data.result.limit_num);
                        layer.alert(data.msg,{icon:2});
                    }
                }
            });
        }
        //多选框点击事件
        $(function () {
            $(document).on("click", ".checkCart", function (e) {
                //选中一个
                if($(this).hasClass('checkCartItem')){
                    if($(this).is(':checked')){
                        $(this).attr('checked', 'checked');
                    }else{
                        $(this).removeAttr('checked');
                    }
                }
                //选中全选多选框
                if($(this).hasClass('checkCartAll')){
                    if($(this).is(':checked')){
                        $(".checkCart").each(function(i,o){
                            $(this).attr('checked', 'checked');
                        })
                    }else{
                        $(".checkCart").each(function(i,o){
                            $(this).removeAttr('checked');
                        })
                    }
                }
                initCheckBox();
                AsyncUpdateCart();
            })
        })
        /**
         * 检测选项框
         */
        function initCheckBox(){
            var checkBoxsFlag = true;
            $("input[name^='checkItem']").each(function(i,o){
                if ($(this).attr("checked") != 'checked') {
                    checkBoxsFlag = false;
                }
            })
            if(checkBoxsFlag == false){
                $('.checkCartAll').removeAttr('checked');
            }else{
                $('.checkCartAll').attr('checked', 'checked');
            }
        }

        //删除购物车商品
        $(function () {
            //删除购物车商品事件
            $(document).on("click", '.deleteGoods', function (e) {
                var cart_ids = new Array();
                cart_ids.push($(this).attr('data-cart-id'));
                $.ajax({
                    type : "POST",
                    url:"<?php echo U('Home/Cart/delete'); ?>",
                    dataType:'json',
                    data: {cart_ids: cart_ids},
                    success: function(data){
                        if(data.status == 1){
                            for (var i = 0; i < cart_ids.length; i++) {
                                $('#edge_' + cart_ids[i]).remove();
                            }
                            var inputCheckItemAll = $("input[name^='checkItem']");
                            if(inputCheckItemAll.length == 0){
                                $('#tpshop-cart').remove();
                                $('.shopcar_empty').show();
                            }
                        }else{
                            layer.msg(data.msg,{icon:2});
                        }
                        AsyncUpdateCart();
                    }
                });
            })
        })
        //删除购物车商品确定事件
        $(function () {
            $(document).on("click", '#removeGoods', function (e) {
                var cart_ids = new Array();
                //多个删除
                $("input[name^='checkItem']").each(function(i,o){
                    if($(this).is(':checked')){
                        cart_ids.push($(this).val());
                    }
                })
                $.ajax({
                    type : "POST",
                    url:"<?php echo U('Home/Cart/delete'); ?>",//,
                    dataType:'json',
                    data: {cart_ids: cart_ids},
                    success: function(data){
                        if(data.status == 1){
                            for (var i = 0; i < cart_ids.length; i++) {
                                $('#edge_' + cart_ids[i]).remove();
                            }
                            var inputCheckItemAll = $("input[name^='checkItem']");
                            if(inputCheckItemAll.length == 0){
                                $('#tpshop-cart').remove();
                                $('.shopcar_empty').show();
                            }
                        }else{
                            layer.msg(data.msg,{icon:2});
                        }
                        AsyncUpdateCart();
                    }
                });
            })
        })
        $('.gwc-qjs').click(function(){
            var user_id = '<?php echo $user_id; ?>';
            if(user_id == '0'){
                layer.open({
                    type: 2,
                    title: '<b>登陆TPshop</b>',
                    skin: 'layui-layer-rim',
                    shadeClose: true,
                    shade: 0.5,
                    area: ['490px', '460px'],
                    content: "<?php echo U('Home/User/pop_login'); ?>",
                });
            }else{
                window.location.href = $(this).attr('data-url');
            }
        })


        function  passjudge(){
            layer.alert('您还没有通过后台管理员的认证，请耐心等待', {'icon':5}) ;
        }
    </script>
</body>
</html>