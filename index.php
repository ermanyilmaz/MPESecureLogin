<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1
header("Pragma: no-cache");
sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
    header('Location: protected_page.php');

} else {
    $logged = 'out';
}
// I made change there
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Secure Login MPE: Log In</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="js/jquery.min.js"></script>
        
        <script src="js/bootstrap.min.js"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="./css/sign-in.css" rel="stylesheet">
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script> 
    </head>
    <body>
        <?php
        echo "<div class=\"container-fluid\">
                <div class=\"row enterancebar\">
                <div align=\"left\" class=\"col-sm-3\">";
        if (login_check($mysqli) == true) {

            echo '<p>Currently logged ' . $logged . ' as Commander <span style="font-style: italic; color:mediumpurple "> ' . htmlentities($_SESSION['username']) . '</span></p></div>';
            echo "<div align=\"center\" class=\"col-sm-6\">Mission Planner and Executer</div>";
            echo '<div align="right" class="col-sm-3"><p>Do you want to change user? <a href="./includes/logout.php">Log out</a>.</p></div>';
        } else {
            echo '<p>Currently logged ' . $logged . '.</p></div>';
            echo "<div align=\"center\" class=\"col-sm-6\">Mission Planner and Executer</div>";
            echo '<div align="right" class="col-sm-3">You need to Log-in</div>';
        }
        echo "</div>";
        ?> 

        <div>
            <p style="color: seagreen; font-size: 20px;"> Welcome <span style="font-style: italic; color:mediumseagreen "><?php echo php_uname('n'); ?></span></p>
        </div>
        <div>

        </div>
        <div align="center">

            <h1>MPE</h1>
        </div>

        <?php
        echo '</div>'; // div of container fluid
        ?> 



        <form action="./includes/process_login.php" method="post" name="login_form" class="form-signin">                      


            <h2 style="color: #000000; text-align: center;" class="form-signin-heading">Commander Log-in</h2>
            <label for="usr" class="sr-only">Email address</label>
            <input type="text" id="login" name="un" class="form-control" placeholder="Your User Name" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="password" name="pw" class="form-control" placeholder="Password" required>
            <button type="submit"  value="LOGIN" class="btn btn-lg btn-primary btn-block" >
                Login</button>


        </form>
        <?php
        if (isset($_GET['error'])) {
            echo "<h1 style=\"color: red; text-align: center;\">Wrong User Information</h1>";
        }
        ?> 


    </body>

</html>