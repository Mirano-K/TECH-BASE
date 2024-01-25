<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>team</title>
        <link rel="stylesheet" href="style.css" >
        <style type="text/css">

        input.example1 { width: 600px;height: 3em; }
        input.example2 { width: 600px;height: 3em; }

        textarea {
            width: 600px;height: 6em;
            }
            
            table,tr,td,th{
        border: solid 1px black; border-collapse: collapse;
    }
    td{
        background:white;
    }
    th{
        background: #6495ed;
    
    }

        </style>
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
        <a href="timeline.html" target="_blank">タイムライン</a>
        <a href="logout.html" class="login">ログアウト</a>
      </div>
    </div>
    </header>

<?php
    require_once './db.php';
    
    if( !empty( $_POST["name"] ) && !empty( $_POST["title"] ) && !empty( $_POST["date"] ) && !empty( $_POST["term"] ) && !empty( $_POST["selection"] ) && !empty( $_POST["memo"] ) && empty( $_POST["id"]) ){
        
        $name = $_POST["name"] ;           
        $title = $_POST["title"] ;         //インターンタイトル
        $date = $_POST["date"];            //実施日
        $term = $_POST["term"];            //実施期間
        $selection = $_POST["selection"];  //選考
        $memo = $_POST["memo"];            //自由メモ欄
        
        
        // INSERT文 データを入力（データレコードの挿入）
        $sql = "INSERT INTO space (name, title, date, term, selection, memo) VALUES (:name, :title, :date, :term, :selection, :memo)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':term', $term, PDO::PARAM_STR);
        $stmt->bindParam(':selection', $selection, PDO::PARAM_STR);
        $stmt->bindParam(':memo', $memo, PDO::PARAM_STR);
        $stmt->execute(); 
        header("Location:timeline.php");
    }
    
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
　　<div class = "box1">
    <h1 class="header" align="center">入力画面</h1>
    <h3 align="center">あなたのインターンシップの体験談をシェアしてください</h3>
    <form action="" method="post" style="margin: auto; width: 600px;">
        <input type="text" name="name" class="example1" placeholder="企業名"cols="48"value="<?php if( !empty($_POST['edit']) ){echo $ename;} ?>"><br>
        <input type="text" name="title" class="example1" placeholder="タイトル"value="<?php if( !empty($_POST['edit']) ){echo $etitle;} ?>"><br>
        <input type="date" name="date" class="example2" value="<?php if( !empty($_POST['edit']) ){echo $edate;} ?>">
        <input type="number" name="term" class="example2" placeholder="実施期間"value="<?php if( !empty($_POST['edit']) ){echo $eterm;} ?>"><br>
        <input type="text" name="selection" class="example1" placeholder="選考"value="<?php if( !empty($_POST['edit']) ){echo $eselection;} ?>"><br>
        <textarea name="memo" rows="3" cols="48"placeholder="メモ・備考欄"><?php if( !empty($_POST['edit']) ){echo $ememo;} ?></textarea><br>
        <input type="hidden" name="id" value="<?php if( !empty($_POST['edit']) ){echo$ednum;} ?>">
        <input type="submit" name="submit" class="btn-submit"><br><br>

        <input type="number" name="dnum" class="example1" placeholder="削除対象番号"><br>
        <input type="submit" name="delete" value="削除" class="btn-submit"><br><br>
        
        <input type="number" name="enum" class="example1" placeholder="編集対象番号"><br>
        <input type="submit" name="edit" value="編集" class="btn-submit"><br>
    </form>
    </div>
    
    <div class = "box2">
    <h1 class="header" align="center">投稿一覧</h1>
    <?php
    $sql = 'SELECT * FROM space';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row) :
    ?>
<div class ="all">
<div class ="">
    <?php 
        echo 
        '<table width="100%">'.
        '<tr>'.
        '<th width="10%" align="center">'."投稿番号".'</th>'.
        '<th width="20%" align="center">'."企業名".'</th>'.
        '<th width="15%" align="center">'."タイトル".'</th>'.
        '<th width="15%" align="center">'."実施日".'</th>'.
        '<th width="10%" align="center">'."実施期間".'</th>'.
        '<th width="10%" align="center">'."選考".'</th>'.
        '<th width="30%" >'."メモ:".'</th>'.
        '</tr>'.
        
        '<tr>'.
        '<td align="center">'.$row['id'].'<br>'.'</td>'.
        '<td align="center">'.$row['name'].'<br>'.'</td>'.
        '<td align="center">'.$row['title'].'<br>'.'</td>'.
        '<td align="center">'.$row['date'].'<br>'.'</td>'.
        '<td align="center">'.$row['term'].'<br>'.'</td>'.
        '<td align="center">'.$row['selection'].'<br>'.'</td>'.
         nl2br('<td>'.$row['memo'].'<br>'.'</td>'.'</tr>'.'</table>');?><br>
</div>
</div>
<br>
<?php endforeach ?>
</div>
<h3>
<!--<a href="timeline.php">投稿一覧</a>-->
</h3><br>
<footer>
  <div class="container">
    <img src="imgs/header-logo.jpg">
    <p>HELLO,WORLD WELCOME TO SPACE.</p>
  </div>
  </footer>
</body>
</html>