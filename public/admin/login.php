<?php require_once("../../includes/initiallize.php");
if($session->is_logged_in()){redirect_to("index.php");}

if(isset($_POST['submit'])){
   $username = trim($_POST['username']);
   $password = trim($_POST['password']);
    
$found_user = User::authenticate($username, $password);
    
if ($found_user){
    $session->login($found_user);
    log_action('Login', "{$found_user->username} logged in.");
    redirect_to("index.php");
} else {
  $message = "Имя пользователя и/или пароль не верны.";  
}

} else {
    $username = "";
    $password = "";
}
?>
<html>
    <head>
    <title>Фотогаллерея</title>
    <link href="../css/main.css" media="all" rel="stylesheet" type="text/css" />
   <?php include_layout_template('admin_header.php'); ?>
        <h2>Вход для администрирования</h2>
        <?php echo output_message($message); ?>
        
        <form action="login.php" method="post">
            <table>
             <tr>
                <td>Имя пользователя:</td>
                 <td>
                 <input type="text" name="username" maxlength="30" value="<?php echo ($username); ?>" />
                 </td>
             </tr>
            <tr>
                <td>Пароль:</td>
                <td>
                <input type="password" name="password" maxlength="30" value="" />
                </td>       
            </tr>  
            <tr>
                <td colsnap="2">
                <input type="submit" name="submit" value="Войти" />
                </td>
            </tr>
            </table>
        </form>
<?php include_layout_template('admin_footer.php');?>
<?php if(isset($database)){$database->close_connection();} ?>