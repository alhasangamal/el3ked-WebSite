<?php
    define('servername' , 'localhost');
    define('username' , 'root');
    define('password' , '');
    define('dbname' , 'el3ked_website');
    $link = mysqli_connect(servername , username , password , dbname);
    if(!$link){
        die('Connection is Failed' . mysqli_connect_error());
    }
