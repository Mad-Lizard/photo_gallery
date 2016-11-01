<?php require_once("../../includes/initiallize.php");
if(!$session->is_logged_in()){redirect_to("login.php");}?>
<?php //$photos = Photograph::find_all();
//current page number
$page = !empty($_GET['page'])? (int)$_GET['page']:1;
//records per page
$per_page = 5;
//total record count
$total_count = Photograph::count_all();

$pagination = new Pagination($page, $per_page, $total_count);
$sql = "SELECT * FROM photographs ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";
$photos = Photograph::find_by_sql($sql); 
?>

<?php include_layout_template('admin_header.php'); ?>
            <h2>Фотогалерея</h2>
<?php echo output_message($message); ?>
<table class="bordered">
<tr>
  <th>Изображение</th>
  <th>Название файла</th>
  <th>Описание</th>
  <th>Размер</th>
  <th>Тип</th>
  <th>Комментарии</th>
  <th>&nbsp;</th>
    </tr>
<?php foreach($photos as $photo): ?>
<tr>
  <td><img src="../<?php echo $photo->image_path();?>" width="200" /></td>
  <td><?php echo $photo->filename;?></td> 
  <td><?php echo $photo->caption;?></td>
  <td><?php echo $photo->size_as_text();?></td>
  <td><?php echo $photo->type;?></td>
  <td>
      <a href="comments.php?id=<?php echo $photo->id; ?>"><?php echo count($photo->comments()); ?></a>
        </td> 
        
    <td><a href="delete_photo.php?id=<?php echo $photo->id;?>" onclick="return confirm('Вы уверены?')">Удалить</a></td>
    </tr>
<?php endforeach; ?>
</table>
<br />
<a href="photo_upload.php">Загрузить новую фотографию</a>
<br />
<div id="pagination" style="clear: both;">
    <?php
    if($pagination ->total_pages() > 1){
       
             if($pagination->has_previous_page()){
            echo "<a href=\"list_photos.php?page=";
            echo $pagination->previous_page();
            echo "\">&laquo; Назад </a>  ";
        }
        for($i=1; $i<=$pagination->total_pages(); $i++){
            if($i == $page){
                echo " <span class=\"selected\">{$i}</span> ";
            } else {
            echo "<a href=\"list_photos.php?page={$i}\" >{$i}</a> ";
        }
        }
        
        if($pagination->has_next_page()){
            echo "<a href=\"list_photos.php?page=";
            echo $pagination->next_page();
            echo "\"> Вперёд &raquo;</a> ";
        }
   
    }
    
    ?>
</div>
<?php include_layout_template('admin_footer.php');?>