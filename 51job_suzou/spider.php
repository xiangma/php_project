<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>用PHP爬取51job上苏州地区的PHP职位信息</title>
	<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">  
	<link rel="stylesheet" type="text/css" href="css.css">
	<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="http://www.ichartjs.com/ichart.latest.min.js"></script>
	<script type="text/javascript">
			$(function(){
				  var interval = setInterval(increment,100);
				  var current = 0;
				  function increment(){
					    current++;
					    $('#counter').html(current+'%'); 
					    if(current == 100) { current = 0;}
					  }
			});


			function drawtable(yuanqu,gusuqu,yidi,xingqu,wuzhong,wujiang,xiangcheng,huqiu){
					var data = [
						{name : '园区',value : yuanqu,color:'#a5c2d5'},
					   	{name : '姑苏区',value : gusuqu,color:'#cbab4f'},
					   	{name : '异地招聘',value : yidi,color:'#76a871'},
					   	{name : '新区',value : xingqu,color:'#76a871'},
					   	{name : '吴中区',value : wuzhong,color:'#a56f8f'},
					   	{name : '吴江区',value : wujiang,color:'#c12c44'},
					   	{name : '相城区',value : xiangcheng,color:'#a56f8f'},
					   	{name : '虎丘区',value : huqiu,color:'#9f7961'}
					 ];
					var chart = new iChart.Column2D({
						render : 'canvasDiv',//渲染的Dom目标,canvasDiv为Dom的ID
						data: data,//绑定数据
						title : '51苏州PHP职位信息统计',//设置标题
						width : 800,//设置宽度，默认单位为px
						height : 400,//设置高度，默认单位为px
						animation : true,//开启过渡动画
				        animation_duration:1400,//800ms完成动画
						shadow:true,//激活阴影
						shadow_color:'#c7c7c7',//设置阴影颜色
						coordinate:{//配置自定义坐标轴
							scale:[{//配置自定义值轴
								 position:'left',//配置左值轴	
								 start_scale:0,//设置开始刻度为0
								 end_scale:390,//设置结束刻度为26
								 scale_space:30,//设置刻度间距
								 listeners:{//配置事件
									parseText:function(t,x,y){//设置解析值轴文本
										return {text:t+"条"}
									}
								}
							}]
						}
					});
		    		chart.draw();
			};

			$(document).ready(function() { $(".wrapper").remove(); });

	</script>
</head>
<body>
<h1 style="margin: 5PX;text-align: center;">用PHP爬取51job上苏州地区的PHP职位信息</h1>
<div class="wrapper">
	<div class="load-bar">   
		<div class="load-bar-inner" data-loading="0"> <span id="counter"></span> </div> 
	</div>  
	<h2 style="text-align:center;margin-bottom: -5px;">正在爬取数据</h2>  
	<p style="text-align:center;font-size: 17px;">请稍等... </p>
</div>
<div id='canvasDiv' style='margin-top: 95px;'></div>
    <div class="table-responsive">
		<table class="table table-hover table-condensed" style="margin: 0px auto;width: 85%;">
			<caption style="text-align: center;">51job苏州地区的PHP职位信息</caption>
		   <thead>
		      <tr>
		         <th>#</th>
		         <th>职位</th>
		         <th>公司</th>
		         <th>地区</th>
		         <th>薪资</th>
		         <th>发布时间</th>
		      </tr>
		   </thead>
		   <tbody>
<?php
// header('Content-Type: text/html; charset=UTF-8');  
include 'simple_html_dom.php';
   
        $time= date('Y-m-d H:i:s',time());
        echo '<p style="width: 100%;position: absolute;text-align: center;top: 50px;">爬取时间:<b>'.$time.'</b><p><br><br>';
   
        $stime=microtime(true); //开始计时
        ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; 4399Box.560; .NET4.0C; .NET4.0E)');
        $html = file_get_html('http://search.51job.com/list/070300,000000,0000,00,9,99,PHP,2,1.html?lang=c&stype=&postchannel=0000&workyear=99&cotype=99&degreefrom=99&jobterm=99&companysize=99&providesalary=99&lonlat=0%2C0&radius=-1&ord_field=0&confirmdate=9&fromType=&dibiaoid=0&address=&line=&specialarea=00&from=&welfare=');

 		$pages=$html->find("div[class=p_wp] div[class=p_in] span[class=td]");
 		$page=preg_replace('/[^0-9]/','',$pages[0]); //获取页数
 		$number=0;      //初始化总职位个数
 		$xingqu=0;      //新区
 		$yuanqu=0;      //园区
 		$gusuqu=0;      //姑苏区
 		$huqiu=0;       //虎丘
 		$yidi=0;        //异地
 		$wuzhong=0;     //吴中
 		$xiangcheng=0;  //相城
 		$wujiang=0;     //吴江
 		
        for ($x=1; $x<=$page; $x++) {
		            $html = file_get_html('http://search.51job.com/jobsearch/search_result.php?fromJs=1&jobarea=070300%2C00&district=000000&funtype=0000&industrytype=00&issuedate=9&providesalary=99&keyword=PHP&keywordtype=2&curr_page='.$x.'&lang=c&stype=1&postchannel=0000&workyear=99&cotype=99&degreefrom=99&jobterm=99&companysize=99&lonlat=0%2C0&radius=-1&ord_field=0&list_type=0&fromType=14&dibiaoid=0&confirmdate=9');
			 		$pageinfo=$html->find("div[id=resultList] div[class=el]");
			 		array_shift($pageinfo);//去除第一条不对的信息
			 		foreach ($pageinfo as $key) {
			 			$jobname=$key->find("p[class=t1] span a")[0];
				        $company=$key->find("span[class=t2] a")[0];
				 		$address=$key->find("span[class=t3]")[0]->plaintext;
				 		$address=trim($address);
				 		$money=$key->find("span[class=t4]")[0]->plaintext;
				 		$publishtime=$key->find("span[class=t5]")[0]->plaintext;
				 		countadd($address);
				        $number++;
				        echo '<tr><td>'.$number.'</td><td>'.$jobname.'</td><td>'.$company.'</td><td>'.$address.'</td><td>'.$money.'</td><td>'.$publishtime.'</td></tr>';
			        };
		}
		function countadd($add){
           switch ($add){
				case "苏州-高新区":
				  global $xingqu;
				  $xingqu++;
				  break;
				case "苏州-工业园区":
				  global $yuanqu;
				  $yuanqu++;
				  break;
				case "异地招聘":
				  global $yidi;
				  $yidi++;
				  break;
				case "苏州-虎丘区":
				  global $huqiu;
				  $huqiu++;
				  break;
				case "苏州-姑苏区":
				  global $gusuqu;
				  $gusuqu++;
				  break;
				case "苏州-相城区":
				  global $xiangcheng;
				  $xiangcheng++;
				  break;
				case "苏州-吴中区":
				  global $wuzhong;
				  $wuzhong++;
				  break;
				case "苏州-吴江区":
				  global $wujiang;
				  $wujiang++;
				  break;
				case "苏州":
				  global $yuanqu;
				  $yuanqu++;
				  break;
				default:
				  echo "其他";
				}
		} 

		$etime=microtime(true);//获取程序执行结束的时间
        $total=$etime-$stime;   //计算差值
        
		echo '<p style="text-align:center;position:absolute;top:70px;width: 100%;">用时：<b>'.$total.'</b>秒。<br>苏州一共有<b>'.$number.'</b>条PHP职位需求信息。</p>';
		echo '<script>drawtable('.$yuanqu.','.$gusuqu.','.$yidi.','.$xingqu.','.$wuzhong.','.$wujiang.','.$xiangcheng.','.$huqiu.');</script>';

		$html->clear();                 
?>
		   </tbody>
		</table>
	</div>
</body>
</html>
