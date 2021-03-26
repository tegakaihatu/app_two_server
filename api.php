<?php
$user_id = $_POST['user_id'];
$score = $_POST['score'];
$passed = $_POST['passed'];
$start = $_POST['start'];
$end = $_POST['end'];



$dsn = 'mysql:dbname=LAA0574800-appservertwo;host=mysql149.phy.lolipop.lan';
$user = 'LAA0574800';
$password = 'sora20200809';

//$dsn = 'mysql:dbname=app_one_server;host=localhost';
//$user = 'root';
//$password = '';


try {
  $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();
}

$sql = 'SELECT * FROM reports WHERE user_id = :user_id';
$prepare = $dbh->prepare($sql);
$prepare->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$prepare->execute();
$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

if(count($result) === 0){
  $sql = 'INSERT INTO `reports`(`user_id`, `score`, `passed`,`start`,`end`) VALUES (:user_id,:score,:passed,:start,:end)';
  $prepare = $dbh->prepare($sql);
  $prepare->bindValue(':user_id', $user_id, PDO::PARAM_INT);
  $prepare->bindValue(':score', $score, PDO::PARAM_INT);
  $prepare->bindValue(':passed', $passed, PDO::PARAM_INT);
  $prepare->bindValue(':start', $start, PDO::PARAM_STR);
  $prepare->bindValue(':end', $end, PDO::PARAM_STR);
  $prepare->execute();
}else{
  $user_id = $result[0]['user_id'];
  $sql = 'UPDATE `reports` SET `score`=:score,`passed`=:passed,`start`=:start,`end`=:end WHERE `user_id`=:user_id';
  $prepare = $dbh->prepare($sql);
  $prepare->bindValue(':user_id', $user_id, PDO::PARAM_INT);
  $prepare->bindValue(':score', $score, PDO::PARAM_INT);
  $prepare->bindValue(':passed', $passed, PDO::PARAM_INT);
  $prepare->bindValue(':start', $start, PDO::PARAM_STR);
  $prepare->bindValue(':end', $end, PDO::PARAM_STR);
  $prepare->execute();
}




echo json_encode(['user_id'=>$user_id,'score'=>$score,'passed'=>$passed]);