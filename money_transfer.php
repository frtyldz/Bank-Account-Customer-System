<?php
        $con_database = mysqli_connect('dijkstra.ug.bcc.bilkent.edu.tr', 'firat.yildiz', 'GUIALvOp','firat_yildiz');
        session_start();
        if (!$con_database) {
            echo "<h1>Conection Error</h1>";
        }
        $num_c = 0;
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['from_aid']) && isset($_POST['to_aid']) && $_POST['tr_amount'] && $_POST['to_aid'] != ''  && $_POST['from_aid'] != ''  && $_POST['tr_amount'] != ''){
                $from_aid = $_POST['from_aid'];
                $ccid = $_SESSION['cid'];
                $to_aid = $_POST['to_aid'];
                $tr_amount = $_POST['tr_amount'];
                $check = mysqli_query($con_database,"SELECT balance FROM account WHERE aid = '$from_aid'") or die(mysqli_error($con_database));
                $row = mysqli_fetch_assoc($check);
                $own_id = mysqli_query($con_database, "SELECT aid FROM customer NATURAL JOIN account NATURAL JOIN owns WHERE cid = '$ccid' ");
                while($row2 = mysqli_fetch_array($own_id)){
                    if($row2['aid'] == $from_aid){
                        $num_c = 1;
                    }
                }
                if($row['balance'] >= $tr_amount && $num_c == 1){
                    $up_to_sql = "UPDATE account  SET balance = balance + $tr_amount WHERE aid='$to_aid'";
                    $up_from_sql = "UPDATE account SET balance = balance - $tr_amount WHERE aid='$from_aid'";
                    if(mysqli_query($con_database, $up_from_sql) && mysqli_query($con_database, $up_to_sql)){
                        echo "<script LANGUAGE='JavaScript'>
                            window.alert('The bank account is updated successfully');
                            window.location.href = 'money_transfer.php';
                        </script>";
                    }
                    $num_c = 0;

                }else{
                    echo "<script type='text/javascript'>alert('UNSUCCESSFUL TRIAL!');</script>";
                }

            }
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
                    echo '<br />';
                  }
            }else{
                echo "There are 0 accounts.";
            }
            ?>
        </div>

        <div class="panel container-fluid">
            <h3 class="page-header" style="font-weight: bold;">Other Customer Accounts</h3>
            <?php
            echo "<table class=\"table table-lg table-striped\">
            <tr>
                <th>OTHER Account ID: </th>
                <th>OTHER Branch: </th>
                <th>OTHER Balance: </th>
                <th>OTHER Open Date: </th>
            </tr>";
            $res_sel = mysqli_query($con_database, "SELECT aid,branch,balance,openDate FROM customer NATURAL JOIN account NATURAL JOIN owns") or die(mysqli_connect_error());
            if (mysqli_num_rows($res_sel) > 0){
                while($row = mysqli_fetch_array($res_sel)) {
                    echo "<tr>";
                    echo "<td>" . $row['aid'] . "</td>";
                    echo "<td>" . $row['branch'] . "</td>";
                    echo "<td>" . $row['balance'] . "</td>";
                    echo "<td>" . $row['openDate'] . "</td>";
                    echo "</tr>";
                  }
            }else{
                echo "There are 0 accounts.";
            }
            echo "</table>";
            ?>
        </div>
    </div>
    <form action="" METHOD="POST">
        <div class = "form-row">
            <input type="text"  class="form-control col-md-4" name="from_aid" placeholder="From Account">
            <input type="text"  class="form-control col-md-4" name="to_aid" placeholder="To Account">
            <input type="text"  class="form-control col-md-4" name="tr_amount" placeholder="Transfer Amount">
            <button type="submit" class="btn btn-success btn-sm">Submit</button>
        </div>
    </form>
    <div style="text-align: bottom">
     <input type="button" onclick="window.location.href='welcome.php'" value="Go Back"/>
     <input type="button" onclick="window.location.href='logout.php'" value="Log Out"/>
    </div>
</body>
</html>
