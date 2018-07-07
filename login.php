<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Lej en ladcykel</title>
  <style>
    body {
    }
    
    * {
      box-sizing: border-box;
    }
    
    /* Add padding to containers */
    .container {
      padding: 16px;
      background-color: rgba(166, 197, 136, 0.74);
      margin: 0 auto;
      position: center;
      max-width: 70%;
    }
    
    /* Full-width input fields */
    input[type=password], input[type=email] {
      width: 100%;
      padding: 15px;
      margin: 5px 0 22px 0;
      display: inline-block;
      border: none;
      background: #f1f1f1;
    }
    
    input[type=password]:focus, input[type=email]:focus {
      background-color: #ddd;
      outline: none;
    }
    
    /* Overwrite default styles of hr */
    hr {
      border: 1px solid #f1f1f1;
      margin-bottom: 25px;
    }
    
    /* Set a style for the submit button */
    .registerbtn {
      background-color: #4CAF50;
      color: white;
      padding: 16px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 100%;
      opacity: 0.9;
    }
    
    .registerbtn:hover {
      opacity: 1;
    }
    
  </style>
</head>
<body>
<?php
include 'frontpage.html';
?>

<?php
session_start();

// define variables and set to empty values
$email = $password = "";

$message = '';

if (isset($_POST['email']) && isset($_POST['psw'])) {
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["psw"]);
    
    $db = mysqli_connect('localhost', 'root', '', 'hobby_project');
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to cennect to MySql: " . mysqli_connect_error();
    }
    
    $sql = sprintf("SELECT password,name FROM user WHERE email='%s'",
        mysqli_real_escape_string($db, $email)
    );
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $hash = $row['password'];
        print $hash;
        print $password;
        if (password_verify($password, $hash)) {
            echo "<script type='text/javascript'>alert('Login succesful.');</script>";
            $_SESSION['user'] = $row['name'];

        } else {
            echo "<script type='text/javascript'>alert('Row er true og Login failed.');</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('Row er false og Login failed.');</script>";
    
    }
    mysqli_close($db);
}


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>


<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class="container">
    <h1>Login</h1>
    <hr>
    
    <label for="email"><b>Email</b></label>
    <input type="email" placeholder="Udfyld email" name="email" required>
    
    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Udfyld password" name="psw" required>
    
    <hr>
    <button type="submit" name="submit" class="registerbtn" >Login</button>
  </div>
</form>


</body>
</html>

