<?php require_once("../../includes/initiallize.php");
if(!$session->is_logged_in()){redirect_to("login.php");}?>
<?php include_layout_template('admin_header.php'); ?>
            <h2>Меню</h2>
<ul>
    <li><a href="list_photos.php">Фотографии</a></li>
    <li><a href="logfile.php">Просмотр лог файла</a></li>
    <li><a href="logout.php">Выход</a></li>
</ul>
<?php include_layout_template('admin_footer.php');?>
