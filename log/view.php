<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Demo</title>
</head>
<?php
	date_default_timezone_set('Asia/Chungking');
	$now = getdate();
	$year = $now[year];
	$month = $now[mon];
	$day = $now[mday];
	$d = cal_days_in_month(CAL_GREGORIAN,$month,$year);
?>
<body>
	<div>
		<select name="month" id="month">
			<?php for($i=1;$i<13;$i++){
				$num = $i>9?$i:'0'.$i;
				echo '<option value="'.$num.'"'.($month == $i?'selected="selected"':'').'>'.$i.'月</option>';
			}?>
		</select>
		<select name="day" id="day">
			<?php for($i=1;$i<=$d;$i++){
				$num = $i>9?$i:'0'.$i;
				echo '<option value="'.$num.'"'.($day == $i?'selected="selected"':'').'>'.$i.'日</option>';
			}?>
		</select>
		<select name="sitetype" id="sitetype">
			<option vaule="1">wap</option>
			<option vaule="2" selected="selected">H5</option>
		</select>
		<select name="logtype" id="logtype">
			<option vaule="1">log</option>
			<option vaule="2" selected="selected">error</option>
		</select>
		<input type="submit" value="查询" id="submit">
	</div>

	<table class="table">
		<tr>
			<th>Title</th>
			<th>URL</th>
			<th>sessionStorage</th>
			<th>localStorage</th>
			<th>cookie</th>
			<th>UA</th>
			<th>Time</th>
		</tr>
	</table>
	<script src=".js/zepto.min.js"></script>
	<script>
		$(function(){
			
			select();
			function select(){
				var month = $('#month').val();
				var day = $('#day').val();
				var sitetype = $('#sitetype').val();
				var logtype = $('#logtype').val();
				$.getJSON('./log_view.php',{
					month:month,
					day:day,
					sitetype:sitetype,
					logtype:logtype
				},function(data){
					//console.log(data);
					if(data && Array.isArray(data)){
						for(var i=0;i<data.length;i++){
							var line = JSON.parse(data[i]);
							var ss_html = '',ls_html = '';
							if(line.storage){
								var storage = line.storage;
								if(storage.ss && storage.ss.length > 2){
									var ss = JSON.parse(storage.ss);
									for(var s in ss){
										ss_html += '<p><span>'+s+'：</span><strong>'+ss[s]+'</strong></p>';
									}
								}
								if(storage.ls && storage.ls.length > 2){
									var ls = JSON.parse(storage.ls);
									for(var l in ls){
										ls_html += '<p><span>'+l+'：</span><strong>'+ls[l]+'</strong></p>';
									}
								}
							}

							var html = '<tr><td>'+line.title+'</td><td><a href="'+line.url+'">'+line.url+'</td><td>'+ss_html+'</td><td>'+ls_html+'</td><td>'+line.cookie+'</td><td>'+line.ua+'</td><td>'+line.timestamp+'</td></tr>';
							$('.table').append(html);
						}
						
					}
				});
			}
		});
	</script>
</body>
</html>