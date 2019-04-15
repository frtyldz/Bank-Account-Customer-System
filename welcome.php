<?php
        $con_database = mysqli_connect('dijkstra.ug.bcc.bilkent.edu.tr', 'firat.yildiz', 'GUIALvOp','firat_yildiz');
        session_start();
        if (!$con_database) {
            echo "<h1>Conection Error</h1>";
        }

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $del_aid = $_POST['del_aid'];
            $cid = $_SESSION['cid'];
            $del_sql = "DELETE FROM owns WHERE aid ='$del_aid' AND cid='$cid'";
            $res_own = mysqli_query($con_database, $del_sql);
            $up_del_sql = "DELETE FROM account WHERE aid ='$del_aid' AND cid='$cid'";
            $res_acc= mysqli_query($db,$update_quota_query);
            echo "<script LANGUAGE='JavaScript'>
                window.alert('The bank account is deleted successfully');
                window.location.href = 'welcome.php';
            </script>";
            }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Accounts</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        p { margin-bottom: 10px; }
        th, td { padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <h5 class="navbar-text">This page is for customer,<?php echo htmlspecialchars($_SESSION['c_name']); ?></h5>

        </nav>
        <div class="panel container-fluid">
            <h3 class="page-header" style="font-weight: bold;">Customer Accounts</h3>
            <?php
            $ccid = $_SESSION['cid'];
            echo "<p><b>Customer ID:</b> " . $_SESSION['cid'] . "</p>";
            $res_sel = mysqli_query($con_database, "SELECT aid,branch,balance,openDate FROM customer NATURAL JOIN account NATURAL JOIN owns WHERE cid = '$ccid'") or die(mysqli_connect_error());
            if (mysqli_num_rows($res_sel) > 0){
                while($row = mysqli_fetch_array($res_sel)) {
                    echo 'Account ID: ' . $row['aid'] . ' Branch: ' . $row['branch'] . ' Balance: ' . $row['balance'] . ' Open Date: ' . $row['openDate'];
                    echo "<td> <form action=\"\" METHOD=\"POST\">
                        <button type=\"submit\" name = \"del_aid\"class=\"btn btn-danger btn-sm\" value =".$row['aid'] .">DELETE</button>
                        </form>

                      </td>";
                  }
            }else{
                echo "There are 0 accounts.";
            }
            ?>
        </div>
    </div>
    <div style="text-align: bottom">
     <input type="button" onclick="window.location.href='money_transfer.php'" value="Money Transfer"/>
     <input type="button" onclick="window.location.href='index.php'" value="Go Back"/>
     <input type="button" onclick="window.location.href='logout.php'" value="Log Out"/>
    </div>
</body>
</html>
