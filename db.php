<?php
class DB {
  private static $instance = null;
  private $pdo,
          $error = false,
          $dsn,
          $username,
          $db_pass,
          $login_name,
          $pass,
          $email,
          $my_session,
          $pass_encrypted;


private function __construct() {
    $this->dsn = "mysql:host=localhost;dbname=login";
    $this->username = 'root';
    $this->db_pass = '';
    $this->login_name = isset($_POST['login_name']) ? $_POST['login_name'] : null;
    $this->pass = isset($_POST['password']) ? $_POST['password'] : null;
    $this->email = isset($_POST['email']) ? $_POST['email'] : null;
    $this->pass_encrypted = password_hash($this->pass, PASSWORD_DEFAULT);
    set_exception_handler(array($this, 'myException'));
  try{
    $this->pdo = new PDO ($this->dsn, $this->username, $this->db_pass);
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  } catch(PDOException $e){
      die($e->getMessage());
  }
}

public static function getInstance() {
  if(!isset(self::$instance)){
    self::$instance = new DB();
  }
  return self::$instance;
}

public function createUser() {
    if(empty($this->login_name && $this->pass && $this->email)){
            echo "<p id='connectMsg' class='alert alert-danger'>All fields are required</p>";
           }else if(!$this->validateField($this->login_name) || !$this->validateField($this->pass)){
                echo "<p id='connectMsg' class='alert alert-danger'>Invalid Username or Password</p>";
    }else{

        $sql = 'SELECT * FROM users WHERE login_name LIKE ? OR email LIKE ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->login_name, $this->email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

       if(!$user){
          $sql2 = 'INSERT INTO users (login_name, password, email) VALUES (:name, :pass, :email)';
          $stmt2 = $this->pdo->prepare($sql2);
          $stmt2->execute(['name' => $this->login_name, 'pass' => $this->pass_encrypted, 'email' => $this->email]);
          echo "<p id='connectMsg' class='alert alert-success'>User created successfully</p>";
        } else{
           echo "<p id='connectMsg' class='alert alert-danger'>Username or email already in use. <a href='create_user.php' class='alert-link'> Try again using a different one</a></p>";
       }
                   }
    }



public function loginUser() {
    $sql = 'SELECT * FROM users WHERE login_name LIKE ?';
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$this->login_name]);
    $user = $stmt->fetchAll();
    $user_count = $stmt->rowCount();
    if(!$user_count){
       echo "<p id='connectMsg' class='alert alert-danger'>Username or password incorrect</p>";
    }else {
        foreach($user as $users){
            if(password_verify($this->pass,$users->password)){
           $_SESSION['uid'] = $users->uid;
           $_SESSION['login_name'] = $users->login_name;

    }else{
            echo "<p id='connectMsg' class='alert alert-danger'>Username or password incorrect</p>";
            }
       }
    }
}

public function profileUser() {

    $sql = 'SELECT * FROM users WHERE uid like ?';
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$_SESSION['uid']]);
    $user = $stmt->fetchAll();
    foreach ($user as $users) {
      $_SESSION['uid'] = $users->uid;
      $_SESSION['login_name'] = $users->login_name;
      echo "
      <div class='card' style='width: 18rem;''>
      <div class='card-header'>
        <h3 class='card-title'>PROFILE<h3>
      </div>
      <div class='card-body'>
      <form action='' method='post'>
      <label>Login Name:</label>
      <div class='input-group'>
       <input class='form-control' name='login_name' value=$users->login_name type='text' required>
      </div>
      <br>
      <label>Password:</label>
      <div class='input-group'>
        <input id='password-field' class='form-control' name='password' pattern='.{8,}' title='must contain a minimum of 8 characters' value=$users->password type='password' required><div class='input-group-addon'><span class='form-control-clear fa fa-remove' title='clear field'>
      </span></div>
       </div>
       <br>
       <label>Email:</label>
       <div class='input-group'>
        <input class='form-control 'name='email' value=$users->email type='text' class='card-footer text-muted' readonly>
       </div>
       <br>
       <input class='btn btn-primary btn-block' name='edit' value='edit' type='submit'>
       </form>
       </div>
       </div>
       ";
    }
}

public function updateProfile() {
  $data = [
    'login_name' => $this->login_name,
    'pass' => $this->pass_encrypted,
    'email' => $this->email,
    'uid' => $_SESSION['uid'],
  ];
  $sql = 'UPDATE users SET login_name = :login_name, password = :pass, email = :email WHERE uid = :uid';
  $stmt = $this->pdo->prepare($sql);
  $update = $stmt->execute($data);
  if($update){
    $_SESSION['login_name'] = $this->login_name;
    $success = "<p id='connectMsg' class='alert alert-success'>Profile Updated</p>";
    $success = urlencode($success);
    header( "location: index.php?success=$success" );
  } else{
    unset($_SESSION['message']);
    echo "<p id='connectMsg' class='alert alert-alert'>Unable to update profile</p>";
  }
}

public function changePassword() {
     if(empty($this->login_name && $this->pass)){
        echo "<p id='connectMsg' class='alert alert-danger'>All fields are required</p>";
    }else {
    $sql = 'SELECT * FROM users WHERE login_name LIKE ?';
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$this->login_name]);
    $user = $stmt->rowCount();
    if(!$user){
       echo "<p id='connectMsg' class='alert alert-danger'>No Username found. Try again or <a href='create_user.php' class='alert-link'> sign up</a></p>";
    } else if(!$this->validateField($this->pass)){
        echo "<p id='connectMsg' class='alert alert-danger'>Invalid Password</p>";
    }else{
         $sql2 = 'UPDATE users SET password = :pass WHERE login_name = :login_name';
        $stmt2 = $this->pdo->prepare($sql2);
        $update = $stmt2->execute(['pass' => $this->pass_encrypted, 'login_name' => $this->login_name]);
        if($update){
            $success = "<p id='connectMsg' class='alert alert-success'>Password successfully changed</p>";
            $success = urlencode($success);
            header( "location: index.php?success_pass=$success" );
            } else{
            echo $this->myException('Unable to change password');
            }
    }
         }
    }


public function validateField($data) {
    if(trim($data) == ''){
       return false;
    }else{
       return true;
    }
}

public function logoutUser() {
    unset($_SESSION['uid']);
    session_destroy();
}

function myException($e) {
  echo $e->getMessage();
}

}

?>
