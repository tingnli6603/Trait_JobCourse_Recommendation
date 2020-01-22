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

$sql = "SELECT * FROM job WHERE class_id='$select_op'";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
	$job_name = $row['job_name'];
	$job_detail = $row['job_detail'];
	$city_name = $row['city_name'];
	$experience = $row['experience'];
	$edu_require = $row['edu_require'];
	$url_query = $row['url_query'];
	$company_name = $row['company_name'];
			
	echo '<a href="'.$url_query.'" style="display:block;" target="_blank">';
	echo "<ul>";
		echo "<li>";
			echo "<p style='font-size:22px;margin-bottom:20px;color: rgb(254,106,106);font-weight:bold;background:white;padding:10px;width:60%;text-align:center;margin:0 auto;box-shadow: 2px 2px 2px 2px rgba(20%,20%,40%,0.3);'>". $job_name ."</p>";
		echo "</li>";
		echo "<li>";
			echo "<p>".$company_name."&nbsp&nbsp&nbsp&nbsp".$city_name."</p>";
		echo "</li>";
		echo "<li>";
			echo "<p>"." 經驗要求:&nbsp".$experience."&nbsp&nbsp&nbsp&nbsp學歷要求:&nbsp".$edu_require."</p>";
		echo "</li>";
		echo "<li>";
			echo '<p style="line-height:22px;margin-top:15px;">'.$job_detail.'</p>';
		echo "</li>";
	echo "</ul>";
	echo "</a>";
}
?>