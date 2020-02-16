<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>User functionality</title>
    <link rel="stylesheet" type="text/css" href="estilos/style.php" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
       <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <style>
        .form-control-clear:hover{
            opacity: 0.5;
            cursor: pointer;
        }
    </style>
</head>

<body>
     <div class="container">
    <div class="row justify-content-md-center">
            <div class="col-xs-12 col-sm-12 col-md-auto col-lg-4 py-5">
        <div><a class='example_e' href='index.php'><i class="fa fa-arrow-left">Go Back</i></a></div>
            <?php
session_start();
        require_once('db.php');
        DB::getInstance()->profileUser();
        if(isset($_POST['edit'])){
            DB::getInstance()->updateProfile();
        }
        ?>
        <br>
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


$(".form-control-clear").click(function() {
    if(confirm("Want to clear password field?")){

   $("#password-field").val("").trigger('propertychange').focus();;
        }
});


        </script>

</html>
