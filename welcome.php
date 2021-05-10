<?php
    include 'signup.php';
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="icon" href="images/a2af8a605a9143b7bb7727d82e5114df.png">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/welcome_style.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aclonica">

</head>
<body onload="myFunction()" style="margin:0;">
    <!-- The Loader -->
    <div id="loader"></div>

    <div style="display:none;" id="myDiv" class="animate-bottom">
            <!-- The video -->
                <video autoplay muted loop id="myVideo" >
                    <source src="images/video_2.mp4" type="video/mp4">
            </video>
        <div class="content" >
            <h1 id="demo"> </h1>
            <div class="hg">
                <button  class="button" onclick="document.getElementById('id01').style.display='block'">Get Start</button>
                <!-- the signup form -->
                <div id="id01" class="modal">
                    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                    <form class="modal-content animate" action="welcome.php" method="post" enctype="multipart/form-data">
                        <div class="container">
                            <h1>Sign Up</h1>
                            <p>Please fill in this form to create an account.</p>
                            <hr>
                            <label for="username"><b>UserName</b></label>
                            <input type="text" placeholder="Enter UserName" name="username" value="<?php echo $username;?>" required>
                            <br>
                            <span class="error"><?php echo $errors['username'];?></span>
                            <br>

                            <label for="email"><b>Email</b></label>
                            <input type="email" placeholder="Enter Email" name="email" value="<?php echo $email; ?>" required>
                            <br>
                            <span class="error"><?php echo $errors['email'];?></span>
                            <br>
                            <label for="psw"><b>Password</b></label>
                            <input type="password" placeholder="Enter Password" id="psw" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" value="<?php echo $password; ?>" required>

                            <!-- Validation Password -->
                            <div id="message">
                                <h3>Password must contain the following:</h3>
                                <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                                <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                                <p id="number" class="invalid">A <b>number</b></p>
                                <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                            </div>

                            <label for="psw-repeat"><b>Repeat Password</b></label>
                            <input type="password" placeholder="Repeat Password" name="psw-repeat" value="<?php echo $rp_password ?>" required>
                            <br>
                            <span class="error"><?php echo $errors['rp_password'];?></span>
                            <br>

                            <label for="profile_image"><b>Profile Image</b></label>
                            <br><br>
                            <input type="file" name="file" ">
                            <br>
                            <span class="error"><?php echo $errors['file'];?></span>
                            <br>

                            <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>
                            <p>if you already have <a href="signin.php" style="color:dodgerblue">accont</a> .</p>
                            <div class="clearfix">
                                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                                <button type="submit" class="signupbtn">Sign Up</button>
                            </div>
                        </div>
                    </form>
                </div>
                <p id="demo1" class="footer" ></p>

    <script src="jq/jquery-3.6.0.min.js"></script>
    <script src="jq/welcome.js"></script>
</body>
