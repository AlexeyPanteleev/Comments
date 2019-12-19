<?php

// проверка POST запроса
if ($_POST["comment"]){
    $text = $_POST["comment"];
    header("Location: http://comments/viewComments.php");
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
<form action="viewComments.php" method="POST">
   <lable>Напишите свой комментарий</lable></br>
   <textarea name="comment" cols="60" rows="5" required></textarea></br>
   <input type="submit" value="Добавить комментарий">
</form>
</div>
<div class="container">
<?php

class Comments {
    // функция добавления комментария в фаил
    public function AddComment ($text_comment){
        // проверка на наличие полученных данных
        if ($text_comment != null){
            // работа с Dom
            $dom = new DomDocument();
            // загрузка файла с комментариями
            $dom->load('comments.xml');
            $parent = $dom->documentElement;
            $first_item = $parent->getElementsByTagname('comment')->item(0);
            $new_comment = $dom->createElement ('comment');
            // добавление тега и комментария в фаил
            $new_text = $dom->createElement ('text', $text_comment);
            $new_comment->appendChild ($new_text);
            $parent->insertBefore ($new_comment, $first_item);
            // сохранение изменений в файле
            $dom->save('comments.xml');
        }
    }
    // функция просмотра комментариев из файла 
    public function ViewComments ($page){
        // подключение к файлу с комментариями
        $xml = simplexml_load_file("comments.xml");
        //количество коментариев которое должно выводится на одной странице
        $k = 5;
        // добавление тегов и вывод комментариев
        echo '<h3 align="center">Предыдущие комментарии</h3></br>';
        echo '<div class="container" style="border:1px solid #cecece;">';
        for ($i = $page * $k; $i < ($page+1)*$k; $i++){
            echo  $xml->comment[$i]->text.'<hr>';
        }
        echo '</div>';

        //длинна пагинации (количество страниц)
        $len = floor(count($xml)/$k);
        echo '<nav class="navbar"><ul class="pagination">';
        for ($i = 0; $i <= $len; $i++){
            echo '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.($i + 1).'</a></li>';
        };
        echo '</ul></nav>';
    }
};
//создание экзапляра класса и обращение к функции
$add_comment = new Comments;
$add_comment->AddComment($text);

$view_comments = new Comments;
$view_comments->ViewComments($page_comments);

?>
  </div>
 </body>
</html>