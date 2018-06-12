<!DOCTYPE html>
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
        input[type=text], input[type=password], input[type=number], input[type=email] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
        }
        
        input[type=text]:focus, input[type=password]:focus, input[type=number]:focus, input[type=email]:focus {
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

        .error {color: #FF0000;}

    </style>
</head>
<body>
<?php
include 'frontpage.html';
?>

<?php

// define variables and set to empty values
$nameErr = $emailErr = $phoneErr = $pswErr = "";
$name = $email = $phone = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ok = true;
    if (!empty($_POST["name"])) {
        $name = test_input($_POST["name"]);
    }
    
    if (!empty($_POST["phone"])) {
        $phone = test_input($_POST["phone"]);
        if (strlen($phone) != 8 ) {
            $phoneErr = "Telefonnummeret skal på 8 tegn";
            $ok = false;
        }
    }
    
    if (!empty($_POST["email"])) {
        $email = test_input($_POST["email"]);
    }
    
    if ((!empty($_POST["psw"]) && !empty($_POST["pswRepeat"])) && ($_POST["psw"] != $_POST["pswRepeat"])) {
        $password = test_input($_POST["psw"]);
        $pswErr = "Forskellige passwords";
        $ok = false;
    }
    
    if ($ok) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        // connect to database
        $db = mysqli_connect('localhost', 'root', '', 'hobby_project');
        // assemble statements and escape the properties
        $sql = sprintf("INSERT INTO user (name, phoneNumber, email, password) VALUES (
             '%s', '%s', '%s', '%s'
         )",
            mysqli_real_escape_string($db, $name),
            mysqli_real_escape_string($db, $phone),
            mysqli_real_escape_string($db, $email),
            mysqli_real_escape_string($db, $hash));
        // send it to database
        mysqli_query($db, $sql);
        // close database
        mysqli_close($db);
        // output to see what has happened
        
        echo "<script type='text/javascript'>alert('Highfive! Du er oprettet');</script>";
    }
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
      <h1>Opret en bruger</h1>
        <p>Opret en bruger for at leje og udleje ladcykler.</p>
        <hr>
        
        <label for="name"><b>Navn</b></label>
        <input type="text" placeholder="Udfyld navn" name="name" value="<?php echo $name;?>" required>
        
        <label for="phone"><b>Telefonnummer</b></label>
        <span class="error"><?php echo $phoneErr;?></span>
        <input type="number" placeholder="Udfyld dansk telefonnummer" name="phone" value="<?php echo $phone;?>" required>
        
        <label for="email"><b>Email</b></label>
        <span class="error"><?php echo $emailErr;?></span>
        <input type="email" placeholder="Udfyld email" name="email" value="<?php echo $email;?>" required>
        
        <label for="psw"><b>Password</b></label>
        <span class="error"><?php echo $pswErr;?></span>
        <input type="password" placeholder="Udfyld password" name="psw" required>
        
        <label for="pswRepeat"><b>Gentag password</b></label>
        <span class="error"><?php echo $pswErr;?></span>
        <input type="password" placeholder="Gentag password" name="pswRepeat" required>
        <hr>
        <button type="submit" name="submit" class="registerbtn" >Opret</button>
    </div>
</form>

</body>
</html>

