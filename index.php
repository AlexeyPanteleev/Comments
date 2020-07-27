<?php
// проверка POST запроса
if ($_POST["comment"]){
    $text = $_POST["comment"];
    header("Location: http://Comments/index.php");
}else{
    $text = null;
}
// проверка GET запроса
if ($_GET["page"]){
    $page_comments = $_GET["page"];
}else{
    $page_comments = 0;
}
// подключения файла стилей
include "style.php";
?>

<html>
 <head>
   <meta charset="utf-8">
   <title>Comments</title>
 </head>
 <body>
 <div class="container">
 <!-- форма для добавления комментариев -->
<form action="index.php" method="POST">
   <lable>Напишите свой комментарий</lable></br>
   <textarea name="comment" cols="60" rows="5" required></textarea></br>
   <input type="submit" value="Добавить комментарий">
</form>
</div>
<div class="container">
    
<?php
require_once("Comments.php"); // подключение к файлу с классом и методами
//создание экзапляра класса и обращение к функции
$add_comment = new Comments;
$add_comment->AddComment($text);

$view_comments = new Comments;
$view_comments->ViewComments($page_comments);
?>

</div>
 </body>
</html>