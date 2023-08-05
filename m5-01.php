<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
    
<?php

$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザ名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

$sql = "CREATE TABLE IF NOT EXISTS Mission5"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date DATETIME,"
    . "pass TEXT"
    .");";
$stmt = $pdo->query($sql);    



if ( !empty($_POST["submit"] ) || !empty($_POST["delete"] )|| !empty($_POST["edit"] )){
$name = $_POST["name"];
$comment = $_POST["str"];
$id = $_POST["id"];
$pass = $_POST["pass"];
}

//入力機能
if ( !empty($_POST["name"] ) &&  !empty($_POST["str"] ) &&  !empty($_POST["pass"] ) && empty($_POST["id"] )) {
    $sql = $pdo -> prepare("INSERT INTO Mission5 (name, comment, date , pass) VALUES (:name, :comment, NOW(), :pass)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
    $sql -> execute();
}

//編集対象番号の取得
if (!empty($_POST["enum"] )) {
$enum = $_POST["enum"];
$epass = $_POST["epass"];    
$sql = 'SELECT * FROM Mission5';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
    foreach ($results as $row){
        if ($row['id'] == $enum && $row['pass'] == $epass) {
        $ename = $row['name'];                                                  //フォームに表示したい名前
        $estr = $row['comment'];                                                //フォームに表示したいコメント
        $ednum = $row['id'];                                                    //フォームを指定する番号
        $epass2 = $row['pass'];                                                 //フォームに表示したいパスワード
        }
    }   
}

//編集後のテキストに書き換える

if ( !empty($_POST["id"] )) {
$sql = 'SELECT * FROM Mission5';
    $sql = 'UPDATE Mission5 SET name=:name,comment=:comment,id=:id,pass=:pass,date=NOW() WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
    $stmt->execute();
}
   
//削除機能  

if (isset($_POST["delete"] )) {
$did = $_POST["dnum"];
$dpass = $_POST["dpass"];    
$sql = 'SELECT * FROM Mission5';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
    foreach ($results as $row){
        if ( $row['id'] == $did && $row['pass'] == $dpass ){                 //削除番号と行番号が一致する＆パスワードがあってる
        $sql = 'delete from Mission5 where id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $did, PDO::PARAM_INT);
        $stmt->execute();
        }
    }
}

?>
    
    <form action=""  method="post">
        あなたの好きな動物は？<br>
        <input type="text" name="name"placeholder="あなたの名前" value="<?php if( !empty($_POST['edit']) ){echo $ename;} ?>"><br>
        <input type="text" name="str"placeholder="好きな動物の名前" value="<?php if( !empty($_POST['edit']) ){echo $estr;} ?>"><br>
        <input type="text" name="pass"placeholder="パスワード" value="<?php if( !empty($_POST['edit']) ){echo $epass2;} ?>">
        <input type="hidden" name="id" value="<?php if( !empty($_POST['edit']) ){echo$ednum;} ?>">
        <input type="submit" name="submit"><br><br>
        
        <input type="number" name="dnum"placeholder="削除対象番号"><br>
        <input type="text" name="dpass"placeholder="パスワード">
        <input type="submit" name="delete" value="削除"><br><br>
        
        <input type="number" name="enum"placeholder="編集対象番号"><br>
        <input type="text" name="epass"placeholder="パスワード">
        <input type="submit" name="edit" value="編集">
    
    </form>

<?php

//テキストをプリント
echo "<hr>";
if ( !empty($_POST["submit"] ) || !empty($_POST["delete"] )){
    $sql = 'SELECT * FROM Mission5';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
        echo "<hr>";
    }
}    

?>
</body>
</html>