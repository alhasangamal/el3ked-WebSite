<?php
    define('servername' , 'localhost');
    define('username' , 'root');
    define('password' , '');
    define('dbname' , 'el3ked_website');
    $link = mysqli_connect(servername, username, password, dbname);
    if(!$link){
        die('Connection is Failed' . mysqli_connect_error());
    }
    $errors = array('email'=>'' ,  'password' => '' , 'conf_password' => '');
    $email = $new_password = $conf_password = '';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(empty(trim($_POST['email']))){
            $errors['email'] = 'Please Enter Email';
        }else{
            $sql = "SELECT id FROM users WHERE email = ?";
            if($stm = mysqli_prepare($link , $sql)){
                mysqli_stmt_bind_param($stm , "s" , $param_email);
                $param_email = trim($_POST['email']);
                if (mysqli_stmt_execute($stm)){
                    mysqli_stmt_store_result($stm);
                    if(mysqli_stmt_num_rows($stm) == 0){
                        $errors['email'] = "This Email is Not Found";
                        $email = trim($_POST['email']);
                    }else{
                        $email = trim($_POST['email']);
                    }
                }
                mysqli_stmt_close($stm);
            }
        }
        if(empty(trim($_POST['new_password']))){
            $errors['password'] = 'Please enter the new password.';
        }elseif (strlen(trim($_POST['new_password']))<8){
            $errors['password'] = 'Password must have at least 6 characters';
        }else{
            $new_password = $_POST['new_password'];
        }
        if(empty(trim($_POST['conf_password']))){
            $errors['conf_password'] = 'Please confirm the password';
        }else{
            $conf_password = trim($_POST['conf_password']);
            if(empty($errors['conf_password']) && ($new_password != $conf_password)){
                $errors['conf_password'] = 'Password did not Match';
            }
        }
        if(empty($errors['email'])&&empty($errors['password']) && empty($errors['conf_password'])){
            $sql = "UPDATE users SET password =? WHERE email =?";
            if($stm = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stm, "ss", $param_password, $param_email);
                $param_password    = password_hash($new_password, PASSWORD_DEFAULT);
                $param_email       = $email;
                if(mysqli_stmt_execute($stm)){
                    session_destroy();
                    header("location: signin.php");
                    exit();
                }else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
                mysqli_stmt_close($stm);
            }
        }
        mysqli_close($link);

    }
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="icon" href="images/a2af8a605a9143b7bb7727d82e5114df.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style2.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
<div class="bg-img">
    <!-- The video -->
    <video autoplay muted loop id="myVideo" >
        <source src="images/video_2.mp4" type="video/mp4">
    </video>
    <div class="container">
        <h1>Reset Password</h1>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control " value="<?php echo $email; ?>">
                <br>
                <span class="error"><?php echo $errors['email']; ?></span>
                <br>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" id="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" value="<?php echo $new_password; ?>">
                <!-- Validation Password -->
                <div id="message">
                    <h3>Password must contain the following:</h3>
                    <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                    <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                    <p id="number" class="invalid">A <b>number</b></p>
                    <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                </div>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="conf_password" class="form-control " value="<?php echo $conf_password; ?>">
                <br>
                <span class="error"><?php echo $errors['conf_password']; ?></span>
                <br>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link ml-2" href="signin.php">Cancel</a>
            </div>
        </form>
</div>
<script >
    // Validation Password
    var myInput = document.getElementById("psw");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");

    // When the user clicks on the password field, show the message box
    myInput.onfocus = function() {
        document.getElementById("message").style.display = "block";
    }

    // When the user clicks outside of the password field, hide the message box
    myInput.onblur = function() {
        document.getElementById("message").style.display = "none";
    }

    // When the user starts to type something inside the password field
    myInput.onkeyup = function() {
        // Validate lowercase letters
        var lowerCaseLetters = /[a-z]/g;
        if(myInput.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
        } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
        }

        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if(myInput.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if(myInput.value.match(numbers)) {
            number.classList.remove("invalid");
            number.classList.add("valid");
        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
        }

        // Validate length
        if(myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
    }

</script>
</body>
</html>

