<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>login</title>
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
        <a href="account.php" target="_blank">新規登録</a>
        <a href="login.php" class="login">トップ</a>
      </div>
    </div>
    </header>
    <div class="main">
    <div class="inner">
    <div class="title">ログイン</div>
    <!--<h3>登録したIDとパスワードを入力してください。</h3><!--少し大文字-->
    <form action="" method="post">
        <div class="left3">
        ログインID: <input type="text" name="id" class="left">
        </div>
        <div class="left2">
        パスワード: <input type="text" name="pass" class="left">
    <input type="submit" name="login" value="ログイン" class="btn-submit">
    </div>
    </form>
    <h2>
    <?php
    require_once './db.php';
    
    if( !empty ( $_POST["id"] ) && !empty ( $_POST["pass"] )){
        $id = $_POST["id"] ;
        $pass = $_POST["pass"] ;
        
        $sql = 'SELECT * FROM account';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            if( $row["id"] == $id && $row["pass"] == $pass ){
            header("Location:post-form.php");/*リンク先に飛ぶ*/
            }
        }
        if( $row["id"] != $id && $row["pass"] != $pass ){
            echo "<b>"."ログインIDまたはパスワードが違います。"."</b>"."<br>";
        }
    }
    /*IDとパスワードが両方、もしくはいずれか片方入力されていない*/
    if( !empty( $_POST["login"]) && (empty( $_POST["id"] ) || empty( $_POST["pass"] ))){
    echo "ログインIDかパスワード、またはその両方が入力されていません。" . "<br>";
    }
    ?>
    </h2>
    </div>
    </div>
    </body>
</html>