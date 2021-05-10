<?php
   session_start();
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
        header("location: profile.php");
        exit;
    }
    define('servername' , 'localhost');
    define('username' , 'root');
    define('password' , '');
    define('dbname' , 'el3ked_website');
    $link = mysqli_connect(servername, username, password, dbname);
    if(!$link){
        die('Connection is Failed' . mysqli_connect_error());
    }
$errors1 = array('name' => '' , 'password' => '' , 'login' => '');
$username = $password = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(empty(trim($_POST['username1']))){
        $errors1['name'] = 'Please Enter UserName';
        $username = trim($_POST['username1']);
    }else{
        $username = trim($_POST['username1']);
    }
    if(empty(trim($_POST['psw1']))){
        $errors1['password'] = 'Please Enter Password';
        $password = trim($_POST['psw1']);
    }else{
        $password = trim($_POST['psw1']);
    }
    if(empty($errors1['name'])&&empty($errors1['password'])){
        $sql = "SELECT id, username, email, password , filename FROM users WHERE username = ?";
        if($stm = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stm , "s" ,$param_username);
            $param_username = $username;
            if(mysqli_stmt_execute($stm)){
                mysqli_stmt_store_result($stm);
                if(mysqli_stmt_num_rows($stm) ==1){
                    mysqli_stmt_bind_result($stm, $id, $username,$param_email,$hashed_password,$param_file);
                    if(mysqli_stmt_fetch($stm)){
                        if(password_verify($password, $hashed_password )){
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"]       = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["email"]    = $param_email;
                            $_SESSION["image"]    = $param_file;
                            header("location: profile.php");
                        }else{
                            $errors1['login'] = 'Invalid username or password';
                        }
                    }
                }else{
                    $errors1['login'] = 'Invalid username or password';
                }
            }else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stm);
        }
    }
    mysqli_close($link);
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>SignIn</title>
    <link rel="icon" href="images/a2af8a605a9143b7bb7727d82e5114df.png">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/signin_style.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aclonica">

</head>
<body >

<div  id="myDiv" class="animate-bottom">
    <!-- The video -->
    <video autoplay muted loop id="myVideo" >
        <source src="images/video_2.mp4" type="video/mp4">
    </video>
    <div class="content" >
        <h1 id="demo"> </h1>
        <!-- SignIn form -->
        <div id="id02" class="modal1">

            <form class="modal-content1 animate" action="signin.php" method="post" enctype="multipart/form-data">
                <div class="imgcontainer">
                    <a href="welcome.php"><span  class="close1" title="Close Modal">&times;</a>
                    <img src="images/unnamed.png" alt="Avatar" class="avatar">
                </div>
                <br>
                <span class="error"> <?php echo $errors1['login'] ?></span>
                <br>

                <div class="container1">
                    <label for="email"><b>Name</b></label>
                    <input type="text" placeholder="Enter UserName" name="username1" required value="<?php echo $username ?>">

                    <br>
                    <span class="error"> <?php echo $errors1['name'] ?></span>
                    <br>

                    <label for="psw"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="psw1" required value="<?php echo $password ?>">

                    <br>
                    <span class="error"> <?php echo $errors1['password'] ?></span>
                    <br>

                    <button type="submit" class="signin" >SignIn</button>

                </div>

                <div class="container1" style="background-color:#f1f1f1">
                    <a href="welcome.php"> <button type="button" class="cancelbtn1">Cancel</button></a>
                    <span class="psw">Forgot <a href="reset-password.php">password?</a></span>
                </div>
            </form>
        </div>

    </div>
</div>
</div>
<script src="jq/jquery-3.6.0.min.js"></script>
</body>

