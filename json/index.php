<?php
/**
 * color wall
 *
 * @author: dogstar 2014-11-04
 */

require_once dirname(__FILE__) . '/../common.php';

header('Content-Type', 'text/html;charset=utf-8');

header('Cache-control', 'max-age=36000');
header('Expires', gmdate('D, d M Y H:i:s', $_SERVER['REQUEST_TIME'] + 36000) . ' GMT');
header('Last-Modified: '. gmdate('D, d M Y H:i:s', $_SERVER['REQUEST_TIME'] + 36000) . ' GMT');

$inputJson = isset($_POST['inputJson']) ? $_POST['inputJson'] : '';

$json = json_decode($inputJson, true);

$jsonStr = '';
if ($json !== NULL) {
	/**
	ob_start();
	var_dump($json);
	ob_end_clean();
	$jsonStr = ob_get_contents();
	*/
	$jsonStr = print_r($json, true);
	$jsonStr = str_replace(' ', '&nbsp;', str_replace("\n", '<br/>', $jsonStr));
}
?> 

<?php
 /** ---------------------------------- Template -------------------------------**/
?>

<?php
require WEB_TOOLS_ROOT . '/header.html';
?>

<div class="projects-header page-header">
	<h2>请输入</h2>
	<p>请在下面输入您需要转换的json串 ，本地会实时转换；如果不行，请尝试<strong>智能转换</strong>。</p>
</div>

<div class="row">
<form action="" method="POST">
		
	<div class="row">
			<div class="row">
				<textarea class="form-control" rows="5" onKeyUp="tranJson();" id="inputJson" name="inputJson" ><?php echo $inputJson;?></textarea>
			</div>
	</div>
	
	<br /><br />
	<div class="row">
		<div class="well" id="tranJsonStr"><?php echo !empty($jsonStr) ? $jsonStr : '这里将会实时显示结果'; ?></div>
	</div>


	<br /><br />

如果不行：<input type="submit" class="btn btn-success btn-sm" value="智能转换" >

</form>

<br /><br />
更多选择：
<a href="http://www.kjson.com/jsonparser/">JSON在线视图</a>&nbsp;&nbsp;
</div> <!-- row -->

<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/json3/3.3.2/json3.js"></script>
<script type="text/javascript">
function tranJson() {
	var str = $("#inputJson").val();
	if (str == '') {
		str = $("#inputJson").text();
	}
	if (str == '') {
		return;
	}

	var obj = JSON.parse(str);

	var rs = dumpJson(obj, 0);

	$("#tranJsonStr").html(rs);
}

function dumpJson(obj, level) {
	var prefix = '';
	for (var i = 0; i < level * 5; i ++) {
		prefix += '&nbsp;';
	}
	
	var rs = '{<br />';
	var content = '';
	var suffix = ',<br />';
	for (var item in obj) {
		content += prefix + '"' + item + '":';
		
		var value = obj[item];
		
		if (typeof value == 'string') {
			content += '"' + value + '"';
		} else if (typeof value == 'number') {
			content += value;
		} else if (typeof value == 'boolean') {
			content += (value ? 'true' : 'false');
		} else if (typeof value == 'object') {
			content += dumpJson(value, level + 1);
		} else if (typeof value == 'null') {
			content += 'null';
		} else if (typeof value == 'undefined') {
		}

		content += suffix;
		//alert(content);
	}
	rs += content.substr(0, content.length - suffix.length) + prefix + '<br />}';
	
	return rs;
}
</script>

<?php
require WEB_TOOLS_ROOT . '/footer.html';
?>