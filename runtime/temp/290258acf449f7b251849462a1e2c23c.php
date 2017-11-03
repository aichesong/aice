<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:44:"./application/admin/view2/index\welcome.html";i:1508311136;}*/ ?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="__PUBLIC__/static/css/index.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/static/css/perfect-scrollbar.min.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/static/css/purebox.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/static/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="__PUBLIC__/static/js/jquery.js"></script>
    <script type="text/javascript" src="__PUBLIC__/static/js/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/static/js/jquery.cookie.js"></script>
    <style>
        .contentWarp_item .section_select .item_comment{
            padding: 83px 0 31px 38px;
        }
        .contentWarp_item .section_select .item {
            padding: 83px 0 38px 38px;
        }
        .contentWarp_item .section_order_select li{
            width: 23%;
        }
    </style>
</head>
<body class="iframe_body">
<div class="warpper">
    <div class="title">管理中心</div>
    <div class="content start_content">
        <div class="contentWarp">
            <div class="contentWarp_item clearfix">
                <div class="section_select">
                    <div class="item item_price">
                        <i class="icon"><img src="__PUBLIC__/static/images/1.png" width="71" height="74"></i>
                        <div class="desc">
                            <div class="tit"><?php echo $count['new_order']; ?></div>
                            <span>今日订单总数</span>
                        </div>
                    </div>
                    <div class="item item_order">
                        <i class="icon"><img src="__PUBLIC__/static/images/2.png"></i>
                        <div class="desc">
                            <div class="tit"><?php echo $count['new_users']; ?></div>
                            <span>今日会员总数</span>
                        </div>
                        <i class="icon"></i>
                    </div>
                    <div class="item item_comment">
                        <i class="icon"><img src="__PUBLIC__/static/images/3.png" width="90" height="86"></i>
                        <div class="desc">
                            <div class="tit"><?php echo $count['comment']; ?></div>
                            <span>今日待审评论数</span>
                        </div>
                    </div>
                    <div class="item item_flow">
                        <i class="icon"><img src="__PUBLIC__/static/images/4.png" width="86"></i>
                        <div class="desc">
                            <div class="tit"><?php echo $count['today_login']; ?></div>
                            <span>今日访问量</span>
                        </div>
                        <i class="icon"></i>
                    </div>
                </div>
            </div>
            <div class="contentWarp_item clearfix">
                <div class="section_order_select">
                    <ul>
                        <li>
                            <a href="<?php echo U('Admin/Order/index',array('order_status'=>0)); ?>">
                                <i class="ice ice_w"></i>
                                <div class="t">待处理订单</div>
                                <span class="number"><?php echo $count['handle_order']; ?></span>
                            </a>
                        </li>
                        <li>
                            <a  href="<?php echo U('Admin/Goods/goodsList'); ?>">
                                <i class="ice ice_y"></i>
                                <div class="t">商品数量</div>
                                <span class="number"><?php echo $count['goods']; ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo U('Admin/Article/articleList'); ?>">
                                <i class="ice ice_f"></i>
                                <div class="t">文章数量</div>
                                <span class="number"><?php echo $count['article']; ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo U('Admin/User/index'); ?>">
                                <i class="ice ice_n"></i>
                                <div class="t">会员总数</div>
                                <span class="number"><?php echo $count['users']; ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<div id="footer" style="position: static; bottom: 0px; font-size:14px;">
    <p><b>深圳爱车送云服股份有限公司</b></p>
</div>
<script type="text/javascript">
    $(function(){
        $("*[data-toggle='tooltip']").tooltip({
            position: {
                my: "left top+5",
                at: "left bottom"
            }
        });
    });
</script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.purebox.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/echart/echarts.min.js"></script>
<script type="text/javascript">
    set_statistical_chart(".section_order_count .filter_date a:first", "order", "week"); //初始设置
    set_statistical_chart(".section_total_count .filter_date a:first", "sale", "week"); //初始设置
    function set_statistical_chart(obj, type, date)
    {
        var obj = $(obj);
        obj.addClass("active");
        obj.siblings().removeClass("active");

        $.ajax({
            type:'get',
            url:'index.php',
            data:'act=set_statistical_chart&type='+type+'&date='+date,
            dataType:'json',
            success:function(data){
                if(type == 'order'){
                    var div_id = "order_main";
                }
                if(type == 'sale'){
                    var div_id = "total_main";
                }
                var myChart = echarts.init(document.getElementById(div_id));
                myChart.setOption(data);
            }
        })
    }

    var option = {
        title : {
            text: ''
        },
        tooltip : {
            trigger: 'axis',
            backgroundColor:"#f5fdff",
            borderColor:"#8cdbf6",
            borderRadius:"4",
            borderWidth:"1",
            padding:"10",
            textStyle:{
                color:"#272727",
            },
            axisPointer:{
                lineStyle:{
                    color:"#6cbd40",
                }
            }
        },
        toolbox: {
            show : true,
            orient:"vertical",
            x:"right",
            y:"60",
            feature : {
                magicType : {show: true, type: ['line', 'bar']},
                saveAsImage : {show: true}
            },
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                boundaryGap : false,
                axisLine:{
                    lineStyle:{
                        color:"#ccc",
                        width:"0",
                    }
                },
                data : ['07-01','07-02','07-03','07-04','07-05','07-06','07-07']
            }
        ],
        yAxis : [
            {
                type : 'value',
                axisLine:{
                    lineStyle:{
                        color:"#ccc",
                        width:"0",
                    }
                },
                axisLabel : {
                    formatter: '{value}个',
                }
            }
        ],
        series : [
            {
                name:'订单个数',
                type:'line',
                itemStyle:{
                    normal:{
                        color:"#6cbd40",
                        lineStyle:{
                            color:"#6cbd40",
                        }
                    }
                },
                data:[0, 5, 8, 3, 10, 15, 2],
                markPoint : {
                    itemStyle:{
                        normal:{
                            color:"#6cbd40"
                        }
                    },
                    data : [
                        {type : 'max', name: '最大值'},
                        {type : 'min', name: '最小值'}
                    ]
                }
            }

        ]
    }
//    $("#system_section").click(function(){
//        $("#system_warp").slideDown();
//    });
</script>
</body>

</html>