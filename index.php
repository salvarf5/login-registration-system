<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>LOGIN/REGISTER SYSTEM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
</head>

<body>
    <div class="container">
    <div class="row justify-content-md-center">
            <div class="col-xs-12 col-sm-12 col-md-auto col-lg-6 py-5">
            <?php
session_start();
?>
        <?php

        require_once('db.php');
            if(isset($_POST['create_user'])){
              DB::getInstance()->createUser();

            }
        if(isset($_POST['login'])){
                DB::getInstance()->loginUser();
            }
        if(isset($_POST['logout'])){
                DB::getInstance()->logoutUser();
            }

        ?>
        <?php

        if (!isset($_SESSION['uid'])){
           if (isset($_GET['success_pass'])){
               echo $_GET['success_pass'];
               header("refresh: 2; url = index.php");
           }
            echo isset($_GET['fail_pass'])?$_GET['fail_pass']:'';
                echo "<div class='card'>
                <div class='card-header'>
                <h3 class='card-title text-center'>LOGIN</h3>
                </div>
                    <div class='card-body'>
                    <form action='' method='post'>
                        <label>Username </label>
                        <div class='input-group'>
                        <input type='text' name='login_name' class='form-control' required autocomplete='off' /><br>
                        </div>
                        <br>
                        <label>Password </label>
                            <div class='input-group'>
                            <input type='password' class='form-control' id='password-field' name='password' pattern='.{8,}' title='must contain a minimum of 8 characters' required autocomplete='new-password' /> <div class='input-group-addon'><i toggle='#password-field' class='fa fa-eye-slash field-icon toggle-password' aria-hidden='true'></i>
                            </div>
                            </div><br>
                        <input type='submit' name='login' class='btn btn-primary' value='login' />
                    </form>
                    <br>
                    <div><a class='example_e' href='change_password.php'> Forgot your password?</a></div>
                    <div>Don't have an account?<a class='example_e' href='create_user.php'> Sign up</a></div>
                    </div>

                </div>";
        } else{
             if (isset($_GET['success'])){
               echo $_GET['success'];
               header("refresh: 1; url = index.php");
           }
             echo "<div class='card'><div class='card-header align-items-center d-flex justify-content-center'><form action='' method='post'>You have logged in  <i><a href='profile.php' title='profile'>".$_SESSION['login_name']."</a></i> <input type='submit' class='btn btn-primary' name='logout' value='logout'/></form></div></div>";



        }
                    ?>
                </div>
    </div>
        </div>
</body>

    <script>
function hideMessage() {
    document.getElementById("connectMsg").style.display = "none";
};
setTimeout(hideMessage, 2000);

if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

$(".toggle-password").click(function() {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});



        </script>

</html>
