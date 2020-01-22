<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>適合職缺</title>
	<link rel="stylesheet" type="text/css" href="newcss.css">
</head>

<body>
		<div class="logo">
			<img src="./img/logo.png">
		</div>



	<div class="wrap_index">
		<div class="introduction">
			<h2>社群媒體人格分析之職缺<stan style='font-size: 44px; color: rgb(254,106,106);'><br>&nbsp&nbsp與</stan>職能培訓推薦系統
	     	</h2>
	     	<p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp本計畫旨為透過對求職者於<stan style='color: rgb(42,183,202);font-weight: bold;'>社群平台的貼文、發言</stan>等資訊，進行<stan style='color: rgb(42,183,202);font-weight: bold;'>文字探勘</stan>與分析，初步將使用者歸類於<stan style='color: rgb(254,106,106);font-weight: bold;'>MBTI人格</stan>理論的其一分類，依其結果進行<stan style='color: rgb(254,106,106);font-weight: bold;'>職缺媒合</stan>，由此協助求職者搜尋適性產業。依據使用者所選擇的適性職位，對其產業內多數類似職缺所需專業職能進行演算，統計類似職缺所需專業能力，並依結果於<stan style='color: rgb(42,183,202);font-weight: bold;'>相關開放資料集中使用關聯分析</stan>，以此推薦求職者所選職缺最相關的職能培養課程。
			</p>



			
		</div>


		<div class="mbti_intro">
			<h2><stan style="font-size: 60px;">MBTI</stan> 邁爾斯-布里格斯性格分類法</h2>
			<div class="yellowline"></div>
			<p>&nbsp&nbsp&nbsp&nbsp&nbsp<stan style="font-weight: bold;">邁爾斯-布里格斯性格分類法</stan>(Myers-Briggs Type Indicator,MBTI) 很常被使用在人格偵測上，雖然它的人格分類方法跟可信度備受爭議，但是它有很廣泛的應用空間，尤其是在工作職場上的應用是最常見的。MBTI模型由四種維度組成，各維度內會有兩種方向，各自分別被定義為：
			</p>

			<ul>
				<li><stan style="font-weight: bold;">心理能力</stan>：內向性(Introversion) / 外向性(Extraversion)</li>
				<li><stan style="font-weight: bold;">認知方式</stan>：實際型(Sensing) / 直覺型(iNtuition)</li>
				<li><stan style="font-weight: bold;">決策方式</stan>：思考型(Thinking) / 感覺型(Feeling)</li>
				<li><stan style="font-weight: bold;">對事物的態度</stan>：判斷型(Judging) / 感知型(Perceving)</li>
			</ul>

			<div class="yellowline" style="margin-top: 30px;"></div>
		</div>

		<div class="uploadfile">
			<h2>請上傳您的貼文</h2>
			<form method="post" enctype="multipart/form-data" action="index.php">
			 	<input type="file" name="my_file" style="">
			 	<input type="submit" value="上傳您的貼文" style="">
			</form>
		</div>

	</div>
</body>
</html>

<?php
# 檢查檔案是否上傳成功
if ($_FILES['my_file']['error'] === UPLOAD_ERR_OK){

	$path ="/home/opendata2/R_needuse_data/uploadfile/";

	function deldir($path){
		//如果是目錄則繼續
		if(is_dir($path)){
		//掃描一個資料夾內的所有資料夾和檔案並返回陣列
		$p = scandir($path);
		foreach($p as $val){
		//排除目錄中的.和..
		if($val !="." && $val !=".."){
		//如果是目錄則遞迴子目錄，繼續操作
		if(is_dir($path.$val)){
		//子目錄中操作刪除資料夾和檔案
		deldir($path.$val.'/');
		//目錄清空後刪除空資料夾
		@rmdir($path.$val.'/');
		}else{
		//如果是檔案直接刪除
		unlink($path.$val);
		}
		}
		}
		}
		}
		//呼叫函式，傳入路徑
		deldir($path);

 	/*
 	echo '檔案名稱: ' . $_FILES['my_file']['name'] . '<br/>';
 	echo '檔案類型: ' . $_FILES['my_file']['type'] . '<br/>';
 	echo '檔案大小: ' . ($_FILES['my_file']['size'] / 1024) . ' KB<br/>';
 	echo '暫存名稱: ' . $_FILES['my_file']['tmp_name'] . '<br/>';
	*/
    $file = $_FILES['my_file']['tmp_name'];
    $dest = '/home/opendata2/R_needuse_data/uploadfile/' . $_FILES['my_file']['name'];

    # 將檔案移至指定位置
    move_uploaded_file($file, $dest);
    exec("Rscript /var/www/html/R_data/final.R ");
    header("Location: http://140.127.220.232/personalizejob/newjob.php");
 }
?>