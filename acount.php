<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>account</title>
    <link rel="stylesheet" href="style.css" >
</head>
<body>
    <header>
    <div class="container">
      <div class="header-left">
        <a href="top.php">
        <img class="logo" src="imgs/header-logo.jpg">
        </a>
      </div>
      <div class="header-right">
        <a href="login.php" class="login">ログイン</a>
        <a href="top.php" target="_blank">TOP</a>
      </div>
    </div>
    </header>
    <div class="main">
    <div class="inner">
    <div class="title">アカウント作成</div> 
    <!--<h3>任意のIDとパスワードを登録してください。</h3>-->
    <form action="" method="post">
        <div class="left1">
            ログインID: <input type="text" name="id" class="left">
        </div>
        <div class="left2">
            パスワード: <input type="text" name="pass" class="left">
    <input type="submit" name="submit" value="作成" class="btn-submit">
    </form>
    </div>
<h2>
<?php

    require_once './db.php';   
    
    if( !empty( $_POST["id"] ) && !empty( $_POST["pass"] )){
        
        $id = $_POST["id"] ;
        $pass = $_POST["pass"] ;
        
        $sql = 'SELECT * FROM account';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            if ( $id == $row["id"]){
            echo "<b>" . "そのIDはすでに存在します。別のIDでアカウントを作成してください。" . "</b>" . "<br>";
            $errer = "エラー";
            }
        }
        if(empty( $errer)){ 
        // INSERT文 データを入力（データレコードの挿入）
        $sql = $pdo -> prepare("INSERT INTO account (id, pass) VALUES (:id, :pass)");
        $sql -> bindParam(':id', $id, PDO::PARAM_STR);
        $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
        $sql -> execute();
        echo "アカウント作成完了。下記リンクからログイン画面に移動してください。" . "<br>";
        }
        
    }
    
    
    if( !empty( $_POST["submit"]) && (empty( $_POST["id"] ) || empty( $_POST["pass"] ))){
    echo "ログインIDかパスワード、またはその両方が入力されていません。" . "<br>"; 
    }
    
?>

</h2>
<!---<h3>
<a href="login.php" class="href">ログイン画面へ移動</a>
</h3>--->
</div>
</div>
</body>
</html>