<?php require_once("../../includes/initiallize.php");
if(!$session->is_logged_in()){redirect_to("login.php");}
if(empty($_GET['id'])){
    $session->message("Id фотографии не был получен.");
    redirect_to('list_photos.php');
}
$photo = Photograph::find_by_id($_GET['id']);
$comments = $photo->comments();

include_layout_template('admin_header.php'); ?>
<a href="list_photos.php">&larr; Назад</a><br />
<br />

<h2>Комментарии к <?php echo $photo->filename; ?></h2>
<div id="comments">
   
    <?php 
    if(!empty($comments))
   { foreach($comments as $comment): ?>
<div class="comment" style="margin-bottom: 2em;">
    <div class="author">
        <?php echo htmlspecialchars($comment->author); ?> написал(а):
        </div>
    <div class="body">
    <?php echo strip_tags($comment->body, '<strong><em><p>');?>
        </div>
    <div class="meta-info" style="font-size: 0.8em;">
        <?php echo datetime_to_text($comment->created); ?>
        </div>
     <a href="delete_comment.php?id=<?php echo $comment->id;?>" onclick="return confirm('Вы уверены?')">Удалить</a>
    </div>
<?php endforeach;} else {
    echo "Нет комментариев.";
    }

include_layout_template('admin_footer.php');?>