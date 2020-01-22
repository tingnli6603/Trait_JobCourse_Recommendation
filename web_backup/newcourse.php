<?php

header("Content-Type:text/html; charset=utf-8");
$servername = "localhost";
$username = "root";
$password = "group2good";
$dbname = "PersonalizedJob";

$conn = mysqli_connect($servername, $username, $password,$dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

#字元編碼
mysqli_set_charset($conn,"utf8");


?>

<!--人格特質讀入，找到相對應的工作類別-->
<?php

  // 輸出
  	$handle = fopen("/home/opendata2/R_needuse_data/output/a1.txt","r");
  	$trait = fgets($handle,10);

  //找到相對應的職業類別代碼
  $sql_traitclass = "SELECT class_id FROM trait_jobclass WHERE trait='".chop($trait)."'";
  $result_traitclass = mysqli_query($conn, $sql_traitclass);
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>適合職缺</title>
	<link rel="stylesheet" type="text/css" href="newcss.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="ajax_select.js"></script>
</head>
<body>
	<div class="backhome">
		<a href="http://140.127.220.232/personalizejob/">回首頁</a>
	</div>
	<div class="wrap">
		<div class="trait">
			<div class="line"></div>

			<div class="trait_name">
				<h2>您的<span style="color: rgb(254,215,102)">人格特質</span>為</h2>
				<?php
				echo "<p>".$trait."</p>";
				?>
			</div>

			<div class="suitable_job">
				<h3>適合的<stan style="color: rgb(254,215,102)">工作類別</stan></h3>

				<div class="class_selection">
				<?php
				//用找出的代碼找職業類別
				
				echo "<select id='select_op' onchange='checkcourse();hiddenblock()'>";
				while ($row_traitclass = mysqli_fetch_array($result_traitclass)) {

					$sql_jobclass = "SELECT class_id,class_name FROM job_class WHERE class_id='$row_traitclass[0]'";
				  	$result_jobclass = mysqli_query($conn, $sql_jobclass);

				 	while ($a =mysqli_fetch_array($result_jobclass)) {
				  		echo "<option value='".$a['class_id']."'>".$a['class_name']."</option>";
				  	}
				 }
				 echo "</select>";
				 
				?>
				</div>

			</div>

			<div class="trait_description">
				<h3>特質敘述</h3>
					<?php
						$sql_traitdescription = "SELECT description FROM trait_description WHERE trait='".chop($trait)."'";
  						$result_traitdescription = mysqli_query($conn, $sql_traitdescription);
  						while ($description =mysqli_fetch_array($result_traitdescription)) {

				  			echo "<p>".nl2br($description[0])."</p>";
				  	}
					?>
			</div>


			<div class="link_place">
				<a href="newjob.php">
					職缺推薦
				</a>
				<a href="newcourse.php">
					課程推薦
				</a>
			</div>
		</div>


<!--一開始顯示第一個人格特質的資訊
選擇select後，把fist_job_recommend隱藏
-->
<script type="text/javascript">
	function hiddenblock(){
		var hiddiv=document.getElementById("first_course_recommend");
		hiddiv.style.display="none";
	}
</script>


		<div class="course_recommend">
			<h2>課程推薦</h2>

			<!--ajax回傳-->
			<div id=message></div>

			<div id="first_course_recommend">
			<?php
				$sql_first_traitclass = "SELECT class_id FROM trait_jobclass WHERE trait='".chop($trait)."'";
  				$result_first_traitclass = mysqli_query($conn, $sql_first_traitclass);
  				$first_traitclass = mysqli_fetch_row($result_first_traitclass);

  				$sql = "SELECT * FROM course WHERE class_id='$first_traitclass[0]'";
				$result = mysqli_query($conn, $sql);

  				while ($row = mysqli_fetch_array($result)) {
					$start_unit = $row['start_unit'];
					$train_period = $row['train_period'];
					$train_timeslot = $row['train_timeslot'];
					$train_city = $row['train_city'];
					$train_location = $row['train_location'];
					$registration_date = $row['registration_date'];
					$test_time = $row['test_time'];
					$expense = $row['expense'];
					$contact_person = $row['contact_person'];
					$contact_number = $row['contact_number'];
					$course_name = $row['course_name'];
					$train_summary = $row['train_summary'];
					$course_content = $row['course_content'];

					echo "<ul>";
						echo "<li>";
							echo "<p style='font-size:22px;margin-bottom:20px;color: rgb(254,106,106);font-weight:bold;background:white;padding:10px;width:60%;text-align:center;margin:0 auto;box-shadow: 2px 2px 2px 2px rgba(20%,20%,40%,0.3);'>". $course_name ."</p>";
						echo "</li>";

						echo "<li>";
							echo "<p>"." 訓練地點:&nbsp".$train_city.$train_location."</p>";
						echo "</li>";

						echo "<li>";
							echo "<p>"." 訓練時間:&nbsp".$train_period."&nbsp&nbsp".$train_timeslot."</p>";
						echo "</li>";

						echo "<li>";
							echo "<p>"." 費用:&nbsp".$expense."</p>";
						echo "</li>";

						echo "<li>";
							echo "<p style='font-size:18px;font-weight:bold;'>訓練大綱:<br></p>";
							echo "<p style='line-height:18px;'>".nl2br($train_summary)."</p>";
						echo "</li>";

						echo "<li>";
							echo "<p style='font-size:18px;font-weight:bold;'>課程內容:<br></p>";
							echo "<p style='line-height:18px;'>".nl2br($course_content)."</p>";
						echo "</li>";

						echo "<li>";
							echo "<p>"." 聯絡單位:&nbsp".$contact_person."</p>";
						echo "</li>";

						echo "<li>";
							echo "<p>"." 聯絡電話:&nbsp".$contact_number."</p>";
						echo "</li>";

					echo "</ul>";
				}
  				
			?>
			</div>
		</div>
	</div>
</body>