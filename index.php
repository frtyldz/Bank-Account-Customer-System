<?php
    $con_database = mysqli_connect('dijkstra.ug.bcc.bilkent.edu.tr', 'user', 'password','firat_yildiz');
    session_start();
    if (!$con_database) {
        echo "<h1>Conection Error</h1>";
    }
    $cid = "";
    $name = "";

   if($_SERVER["REQUEST_METHOD"] == "POST") {

       // get username from database
        $name = mysqli_real_escape_string($con_database, $_POST['name']);
        $cid = mysqli_real_escape_string($con_database, $_POST['cid']);
        $sql = "SELECT cid, name FROM customer WHERE name = \"" . strtolower($name) . "\" AND cid = \"" . $cid . "\";";
        $r_s = mysqli_query($con_database, $sql);
        if (mysqli_num_rows($r_s) == 0) {
        	echo "<script type='text/javascript'>alert('Please Try Another Password');</script>";
        } else {
            session_start();
        	$_SESSION['cid'] = $_POST['cid'];
            $_SESSION['c_name'] = $_POST['name'];
        	header("Location: ./welcome.php");
        	die();
        }
        mysqli_close($con_database);
    }

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Log in</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        #centerwrapper { text-align: center; margin-bottom: 10px; }
        #centerdiv { display: inline-block; }
    </style>


</head>

<body>

    <div class="container">
        <nav class="navbar navbar-inverse bg-primary navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">Banking Customer Login System</a>
                </div>
            </div>
        </nav>
        <form class="form-signin" action="" method='post' accept-charset='UTF-8' style='width: 30%;margin-left: auto;margin-right: auto;margin-top: 250px;'>
            <h2>Entering to the System</h2>
            <label for="inp_name" class="sr-only">Enter your username</label>
            <input type="text" id="name" class="form-control" placeholder="enter your name" name="name" required
                   autofocus>
            <label for="inp_cid" class="sr-only">Enter your password</label>
            <input type="password" id="cid" class="form-control" placeholder="enter your password" name="cid" required>
            <button class="btn btn-lg btn-primary btn-block" style="margin-top: 50px" type="submit" name="lg_in">Enter</button>
        </form>
    </div>
</body>
</html>
