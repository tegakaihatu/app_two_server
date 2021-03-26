<?php
$dsn = 'mysql:dbname=LAA0574800-appservertwo;host=mysql149.phy.lolipop.lan';
$user = 'LAA0574800';
$password = 'sora20200809';

//$dsn = 'mysql:dbname=app_one_server;host=localhost';
//$user = 'root';
//$password = '';

$user_id = isset($_GET['user_id'])?$_GET['user_id']:'1';

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
?>


<h1>アプリ</h1>
<p>User ID : <span id="user-id"><?= $user_id ?></span></p>
<p>App ID : <span id="app-id">2</span></p>
<hr>

<?php if (count($result) > 0) : ?>
  <h2>実績</h2>
  <p>Score : <span id="score"><?= $result[0]['score'] ?></span></p>
  <p>Passed : <span id="passed"><?= $result[0]['passed'] ?></span></p>
  <p>Start : <span id="start"><?= $result[0]['start'] ?></span></p>
  <p>End : <span id="end"><?= $result[0]['end'] ?></span></p>
  <input id="reset-button" type="button" value="実績削除">
  <hr>
<?php endif; ?>

<h2>広告一覧</h2>
<ul id="list" style="list-style: none;">

</ul>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
  let userId = $('#user-id').text();
  let appId = $('#app-id').text();
  let urlBase = "http://tegakaihatu.work/kentei_ad_server/public/";
  // let urlBase = "http://localhost/kentei_ad_server_2/public/";
  $.ajax({
    url: urlBase + `kentei_list?app_id=${appId}`,
    type: 'get',
    dataType: 'json'
  })
    .then(
      // 通信成功時
      function (data) {
        var $list = $('#list');
        $.each(data, function (index, value) {
          $list.append(`<li><a href="${urlBase}kentei?kentei_id=${value.id}&user_id=${userId}&app_id=${appId}">${value.name}</a></li>`);
        })
      },
      // 通信失敗時
      function (data) {
        alert('fail');
      });

  $(function () {
    $('#reset-button').click(function () {

      let resetUrl = "http://tegakaihatu.work/app_two_server/reset.php";
      // let resetUrl = "http://localhost/app_two_server/reset.php";
      $.ajax({
        url: resetUrl,
        type: 'get',
        dataType: 'json'
      })
        .then(
          // 通信成功時
          function (data) {
            alert('実績を削除しました。');
            window.location.reload();
          },
          // 通信失敗時
          function (data) {
            alert('fail');
          });



    });
  });


</script>