<!DOCTYPE html>
<html lang="ja">
    <head>
    <meta charset="UTF-8">
    <title>mission_1-22</title>
    <link rel="stylesheet" href="Mission6.css">
    <style>
        .class1{
            background-color:<?php if( !empty($_POST['bcolor']) ){ echo $bcolor} else { echo "white"}?>;
        }
        .class2{
            color:<?phpif( !empty($_POST['color']) ){ echo $color} else { echo "black"}?>;
        }
    </style>
</head>
<body>  

<div style = "Title">
    <?php
    include "Mission5.php";    
    ?>
</div>    
</body>

<?php

//【スコア2】改行を含む文章が投稿でき（textarea使用）、また、その投稿が表示される
//【スコア2】CSSファイルを用いて装飾表現をしている
//【スコア1】include を用いたプログラム構成にしている

?>
</body>
</html>