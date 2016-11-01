<?php require_once("../includes/initiallize.php"); ?>
<?php 
if(empty($_GET['id'])){
    $session->message("Id фотографии не был получен.");
    redirect_to('index.php');
}

$photo = Photograph::find_by_id($_GET['id']);
if(!$photo){
    $session->message("Фотография не найдена.");
    redirect_to('index.php');
}

if(isset($_POST['submit'])){
   
   $author = trim($_POST['author']);
   $body = trim($_POST['body']);
   if(empty($author)){$author = "Аноним";}

   $new_comment = Comment::make($photo->id, $author, $body);
   if($new_comment && $new_comment->save()){ 
    $session->message("Комментарий был успешно добавлен.");
   $new_comment->try_to_send_notification($body);
       redirect_to("photo.php?id={$photo->id}");   
   } else {
    $session->message("Не получилось сохранить комментарий.");
    redirect_to("photo.php?id={$photo->id}");   
   }
   } else {
    $author = "";
    $body = "";
   }

$comments = $photo->comments();

include_layout_template('header.php'); ?>
<a href="index.php?page=<?php $pagination->current_page; ?>">&larr; Назад</a><br />
<br />

<div style="margin-left: 20 px;">
<img src="<?php echo $photo->image_path(); ?>" />
<p><?php echo $photo->caption; ?></p>
</div>
<h4>Комментарии:</h4>
<div id="comments">
    <?php foreach($comments as $comment): ?>

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
    </div>
    <?php endforeach; ?>
    <?php if(empty($comments)){echo "Ещё никто не оставил комментариев.";} ?>

<div id="comment-form">
<h3>Добавить комментарий</h3>
<?php echo output_message($message); ?>
<form action="photo.php?id=<?php echo $photo->id;?>" method="post">
    <table>
    <tr>
        <td>Ваше имя:</td>
        <td><input type="text" name="author" value="<?php echo $author; ?>" /></td>
        </tr>
        <tr>
        <td>Комментарий:</td>
        <td><textarea name="body" cols="40" rows="8"><?php echo $body; ?></textarea></td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="submit" value="Отправить" /></td>
        </tr>
    </table>
    </form>
</div>

<?php include_layout_template('footer.php');?>