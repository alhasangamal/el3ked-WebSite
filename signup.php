<?php

    define('servername' , 'localhost');
    define('username' , 'root');
    define('password' , '');
    define('dbname' , 'el3ked_website');
    $link = mysqli_connect(servername, username, password, dbname);
    if(!$link){
        die('Connection is Failed' . mysqli_connect_error());
    }

    $errors =array('username' => '' , 'email' => '' , 'password' => '' , 'rp_password' => '' , 'file' => '' );
    $username = $email = $password =$rp_password = '';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(empty(trim($_POST['username']))){
            $errors['username'] = 'Please Enter UserName';
        }else{
            $sql = "SELECT id FROM users WHERE username = ?";
            if($stm = mysqli_prepare($link , $sql)){
                mysqli_stmt_bind_param($stm , "s" , $param_username);
                $param_username = trim($_POST['username']);
                if (mysqli_stmt_execute($stm)){
                    mysqli_stmt_store_result($stm);
                    if(mysqli_stmt_num_rows($stm) == 1){
                        $errors['username'] = "This UserName is Already Token";
                        $username = trim($_POST['username']);
                    }else{
                        $username = trim($_POST['username']);
                    }
                }
                mysqli_stmt_close($stm);
            }
        }
        if(empty(trim($_POST['email']))){
            $errors['email'] = 'Please Enter Email';
        }else{
            $sql = "SELECT id FROM users WHERE email = ?";
            if($stm = mysqli_prepare($link , $sql)){
                mysqli_stmt_bind_param($stm , "s" , $param_email);
                $param_email = trim($_POST['email']);
                if (mysqli_stmt_execute($stm)){
                    mysqli_stmt_store_result($stm);
                    if(mysqli_stmt_num_rows($stm) == 1){
                        $errors['email'] = "This Email is Already Token";
                        $email = trim($_POST['email']);
                    }else{
                        $email = trim($_POST['email']);
                    }
                }
                mysqli_stmt_close($stm);
            }
        }
        if (empty(trim($_POST['psw']))){
            $errors['password'] = 'Please Enter Password';
        }elseif (strlen(trim($_POST['psw']))<8){
            $errors['password'] = 'Password must have at least 8 characters';
        }else{
            $password = trim($_POST['psw']);
        }
        if (empty(trim($_POST['psw-repeat']))){
            $errors['rp_password'] = 'Please Confirm Password';
        }else{
            $rp_password = trim($_POST['psw-repeat']);
            if(empty($errors['password']) && ($password != $rp_password)){
                $errors['rp_password'] = 'Password do not match';
            }
        }
        $targetDir = "images/";
        $filename = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $filename;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        if(!empty($_FILES["file"]["name"])){
            // Allow certain file formats
            $allowTypes = array('jpg','png','jpeg','gif');
            if(in_array($fileType, $allowTypes)){
                move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath);
            }else{
                $errors['file'] = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.';
            }

        }else{
            $errors['file'] = 'Please enter image';
        }

        if(empty($errors['username'])&&empty($errors['email'])&&empty($errors['password'])&&empty($errors['rp_password'])&&empty($errors['file'])){
            $sql = "INSERT INTO users (username , email , password , filename) VALUES (? , ? , ? ,?)";
            if($stm = mysqli_prepare($link , $sql)){
                mysqli_stmt_bind_param($stm , "ssss" , $param_username , $param_email , $param_password , $param_file);
                $param_username = $username;
                $param_email = $email;
                $param_password = password_hash($password , PASSWORD_DEFAULT);
                $param_file = $filename;
                $username = $email = $password = $rp_password =  '';
                if(mysqli_stmt_execute($stm)){
                    header("location: welcome.php");
                }else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
                mysqli_stmt_close($stm);
            }

        }
        mysqli_close($link);

    }