<html><body>
<form action='firstpage.php' method='get'>
輸入 N 值: <input type='text' name='n' />
<input type='submit' onclick="javascript:location.href='http://140.127.220.232/personalizejob/newjob.php'">
</form>
<?php


if(isset($_GET['n'])) {
  $n = $_GET['n'];
   
     exec("Rscript final.R $n");
  // 輸出
 
}
?>

</body></html>
