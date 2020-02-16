<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>User functionality</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
</head>

<body>
        <div class="container">
            <div class="row justify-content-md-center">
            <div class="col-xs-12 col-sm-12 col-md-auto col-lg-6 py-5">

        <?php $login_name = ""; $password = "";;?>
         <?php

        require_once('db.php');
            if(isset($_POST['change_password'])){
              DB::getInstance()->changePassword();
            }


        ?>
                <div class="card">
                    <div class="card-header">
                        <div><a class='example_e' href='index.php'><i class="fa fa-home">Home</i></a></div><br>
                        <h3 class="card-title text-center">CHANGE PASSWORD</h3>
                        </div>
                        <div class="card-body">
                    <form action="" method="post">
                        <label>Confirm Your Username </label>
                        <div class="input-group">
                        <input type="text" name="login_name" class="form-control" value="<?php echo $login_name ?>" autocomplete="off" /><br>
                        </div>
                        <br>
                        <label>New Password </label>
                        <div class="input-group">
                        <input type="password" name="password" pattern=".{8,}" title="must contain a minimum of 8 characters" class="form-control" value="<?php echo $password ?>" autocomplete="off" pattern='[A-Za-z0-9_-]{1,15}'/><br>
                        </div>
                        <br>

                        <input type="submit" name="change_password" class="btn btn-primary btn-block" value="Change Password" />
                    </form>
                                               </div>

                    </div>
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


        </script>

</html>
