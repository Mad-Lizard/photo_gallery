<?php require_once("../../includes/initiallize.php");
if(!$session->is_logged_in()){redirect_to("login.php");}?>
<?php
if(empty($_GET['id'])){
    $session->message("Id комментария не определён.");
    redirect_to('list_photos.php');
}

$comment = Comment::find_by_id($_GET['id']);
if($comment && $comment->delete()){
    $session->message("Комментарий удалён.");
    redirect_to("comments.php?id={$_GET['id']}");
} else {
    $session->message("Не получилось удалить комментарий.");
    redirect_to('list_photos.php');
}


if(isset($db)){$db->close_connection();}?>