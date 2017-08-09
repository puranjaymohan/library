<!DOCTYPE HTML>
<?php
session_start();
$get= mysqli_connect('localhost','root','','library');
if(isset($_POST['username']) && isset($_POST['password']) ) {
    if ($get) {
        $logquery = "SELECT username,password FROM login WHERE username ='" . $_POST['username'] . "' AND password ='" . $_POST['password'] . "'";
        $result = mysqli_query($get, $logquery);
        $row = mysqli_fetch_assoc($result);

    } else {
        die('error cant connect to database');
    }
}
$message='';

        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
            header("Location: admin.php?page=home&pg=1");

        }
        if(isset($_POST['username']) && isset($_POST['password'])){

            if ($row){
                $_SESSION['loggedin']=true;
                header("Location: admin.php?page=home&pg=1");

            }else{
                $message='WRONG USERNAME AND PASSWORD COMBINATION';
            }
        }
?>
<html>

    <head>
        <title>LOGIN</title>
        <link rel="stylesheet" type="text/css" href="./admincss/logcss.css">
    </head>

    <body>
        <div id="head"><h1>LOGIN TO LIBRARY ADMIN PANEL</h1></div>
        <form method="post" action="index.php" id="form">
            <h3 style="display: inline">USERNAME :</h3><input type="text" name="username"><br/>
            <h3 style="display: inline">PASSWORD :</h3><input type="password" name="password"><br/>
            <input type="submit" value="LOGIN" id="button">
        </form>
        <h2><?php echo $message;?></h2>
    </body>
</html>