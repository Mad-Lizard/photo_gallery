<?php require_once("../../includes/initiallize.php");
if(!$session->is_logged_in()){redirect_to("login.php");}?>
<?php include_layout_template('admin_header.php'); 
$user = new User();
$user->username = test;
$user->password = 0;
$user->first_name = test;
$user->last_name = test;
$user->save();


include_layout_template('admin_footer.php');
?>