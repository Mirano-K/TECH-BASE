<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>team</title>
        <link rel="stylesheet" href="style.css" >
    </head>
    <body>
    <header>
    <div class="container">
    <div class="header-left">
        <a href="top.html">
        <img class="logo" src="imgs/header-logo.jpg">
        </a>
      </div>
      <div class="header-right">
        <a href="top.html" target="_blank">TOP</a>
        <a href="logout.html" class="login">ログアウト</a>
      </div>
    </div>
    </header>
    <h1 class="header">投稿一覧</h1>
<?php
    require_once './db.php';
    
        //編集対象番号の取得
    if (!empty($_POST["enum"] )) {
    $enum = $_POST["enum"];
    $sql = 'SELECT * FROM space';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
        foreach ($results as $row){
            if ($row['id'] == $enum ) {
            $ename = $row['name'] ;           //企業名
            $etitle = $row['title'] ;         //インターンタイトル
            $edate = $row['date'];            //実施日
            $eterm = $row['term'];            //実施期間
            $eselection = $row['selection'];  //選考
            $ememo = $row['memo'];            //自由メモ欄
            $ednum = $row['id'];                                                    //フォームを指定する番号

            }
        }   
    }

    //編集後のテキストに書き換える
    if ( !empty($_POST["id"] )) {
        $id = $_POST["id"] ;                //id
        $name = $_POST["name"] ;            //企業名
        $title = $_POST["title"] ;          //インターンタイトル
        $date = $_POST["date"];             //実施日
        $term = $_POST["term"];             //実施期間
        $selection = $_POST["selection"];   //選考
        $memo = $_POST["memo"];             //自由メモ欄
        
    $sql = 'UPDATE space SET name=:name,title=:title,date=:date,term=:term,selection=:selection,memo=:memo WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':term', $term, PDO::PARAM_STR);
    $stmt->bindParam(':selection', $selection, PDO::PARAM_STR);
    $stmt->bindParam(':memo', $memo, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute(); 
    }
   
    //削除機能  

    if (isset($_POST["delete"] )) {
    $did = $_POST["dnum"];
    $sql = 'SELECT * FROM space';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
        foreach ($results as $row){
            if ( $row['id'] == $did){                 //削除番号と行番号が一致する＆パスワードがあってる
            $sql = 'delete from space where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $did, PDO::PARAM_INT);
            $stmt->execute();
            }
        }
    }
?>
<form action="" method="post">
    <input type="number" name="dnum"placeholder="削除対象番号"><br>
    <input type="submit" name="delete" value="削除" class="btn-submit"><br><br>
        
    <input type="number" name="enum"placeholder="編集対象番号"><br>
    <input type="submit" name="edit" value="編集" class="btn-submit"><br>
</form>
<h2>
<h3>
<a href="post-form.php">投稿フォーム</a>
</h3><br>
<?php
    $sql = 'SELECT * FROM space';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row) :
    ?>
<div class ="all">
<div class ="b">
    投稿番号<br>企業名<br>タイトル<br>実施日<br>実施期間<br>選考<br>メモ<br>
</div>

<div class ="a">
    <?php echo $row['id'];?><br>
    <?php echo $row['name'];?><br>
    <?php echo $row['title'];?><br>
    <?php echo $row['date'];?><br>
    <?php echo $row['term'];?><br>
    <?php echo $row['selection'];?><br>
    <?php echo nl2br($row['memo']);?><br>
</div>
</div>
<br>
<?php endforeach ?>
<footer>
  <div class="container">
    <img src="imgs/header-logo.jpg">
    <p>HELLO,WORLD WELCOME TO SPACE.</p>
  </div>
  </footer>
</body>
</html>