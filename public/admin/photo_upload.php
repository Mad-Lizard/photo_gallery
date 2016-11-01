<?php require_once ("../../includes/initiallize.php");
if(!$session->is_logged_in()) { redirect_to("login.php"); }

$max_file_size = 2000000;

if(isset($_POST['submit'])){
    $photo = new Photograph();
    $photo->caption = $_POST['caption'];
    $photo->attach_file($_FILES['file_upload']);
    if($photo->save()){
        $session->message("Фотография успешно загружена.");
        redirect_to('list_photos.php');
    } else {
        $message = join("<br />", $photo->errors);
    }
}
var_dump($photo->temp_path);
include_layout_template('admin_header.php'); ?>

<h2>Загрузка фотографий</h2>
<?php echo output_message($message); ?>
  <form action="photo_upload.php" enctype="multipart/form-data" method="POST">
     <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
      <p><input type="file" name="file_upload" /></p>
      <p>Описание: <input type="text" name="caption" value="" /></p>   
     <input type="submit" name="submit" value="Загрузить" />
   </form>


<?php include_layout_template('admin_footer.php');?>
