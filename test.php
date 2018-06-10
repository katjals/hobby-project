 <!DOCTYPE html>
 <html>
 <head>
     <title>PHP</title>
 </head>
 <body>
 <?php

 $name = '';
 $password ='';


 if (isset($_POST['submit'])) {
     $ok = true;
     if (!isset($_POST['name']) || $_POST['name'] === '') {
         $ok =false;
     } else {
         $name = $_POST['name'];
     }
     if (!isset($_POST['password']) || $_POST['password'] === '') {
         $ok =false;
     } else {
         $password = $_POST['password'];
     }


     if ($ok) {
          $hash = password_hash($password, PASSWORD_DEFAULT);
         // add database code here
         // connect to database
         $db = mysqli_connect('localhost', 'root', '', 'hobby_project');
         // assemble statements and make sure the properties are properly escaped
         $sql = sprintf("INSERT INTO owner (username, password, description, title, phonenumber, price, id) VALUES (
             '%s', '%s', 'cykel', 'min cykel', '11111', '20', '5'
         )", mysqli_real_escape_string($db, $name),
             mysqli_real_escape_string($db, $hash));
         // send it to database
         mysqli_query($db, $sql);
         // close database so it doesn't use space
         mysqli_close($db);
         // output to see what has happened
         echo '<p>User added.</p>';
     }
 }
 ?>
 <form method="post" action="">
     User name: <input type="text" name="name" value="<?php
         echo htmlspecialchars($name);
     ?>"><br>
     Password: <input type="password" name="password"><br>
          <input type="submit" name="submit" value="Submit">

 </form>

 <ul>

     <?php

     $db =mysqli_connect('localhost', 'root', '', 'hobby_project');
     $sql = 'SELECT * FROM owner';
     $result = mysqli_query($db, $sql);

     foreach ($result as $row) {
         printf('<li><span>%s (%s)</span></li>',
             htmlspecialchars($row['username']),
             htmlspecialchars($row['id']));
     }

     mysqli_close($db);

     ?>

 </ul>


 </body>
 </html>