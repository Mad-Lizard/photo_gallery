<?php require_once("../../includes/initiallize.php");
if(!$session->is_logged_in()){redirect_to("login.php");}?>
<?php
if(empty($_GET['id'])){
    $session->message("Id фотографии не определён.");
    redirect_to('index.php');
}

$photo = Photograph::find_by_id($_GET['id']);
if($photo && $photo->destroy()){
    $session->message("Фотография {$photo->filename} удалена.");
    redirect_to('list_photos.php');
} else {
    $session->message("Не получилось удалить фотографию.");
    redirect_to('index.php');
}


if(isset($db)){$db->close_connection();}?>