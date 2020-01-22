<?php

header("Content-Type:text/html;charset=utf-8");
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


//取得傳入值
$select_op = $_GET['select_op'];

$sql = "SELECT * FROM course WHERE class_id='$select_op'";
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