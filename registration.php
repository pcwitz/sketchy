<?php
  session_start();
?><!DOCTYPE html>
<html lang=en>
  <head>
    <meta charset=utf-8>
    <link rel="stylesheet" type="text/css" href="sketchy.css">
    <title>Sketchy | Registration</title>
  </head>
  <body>
    
  <div id="page-wrap">
    <div class="row1">
      <header>
        <div class="col-1">
          <div id="headleft">
            <h1>Sketchy</h1>
          </div>
          
          <span id="sub">SVG for You and Me</span>
        </div>        
      </header>
    </div>
    
    <div class="row2">  
      <nav>
        <div class="col-1-3">
          <a href='#'>about</a>
        </div>
        <div class="col-1-3">
          <a href='#'>resources</a>
        </div>
        <div class="col-1-3">
          <a href='#'>terms and conditions</a>
        </div>
      </nav> 
    </div>
  <?php
    if(isset($_POST['submit']) && $_POST['submit'] == "register")
    {
    include("inc_sketchy_connect.php");
    
    if ($DBConnect === FALSE)
    {
      die("<p>Connection error: " . mysqli_error() . "</p>\n");
    }
    else
    {
      if ($DBSelect === FALSE)
      {
      die("<p>Could not select the \"$DBName\" " . "database: " . 
      mysqli_error($DBConnect) . "</p>\n"); 
      }
      //making email address lowercase in all cases:
      $tempmail = mysqli_real_escape_string($DBConnect, $_POST["email"]);
      $email = strtolower($tempmail);
      $user = mysqli_real_escape_string($DBConnect, $_POST["user"]);
      $sword = sha1(mysqli_real_escape_string($DBConnect,$_POST["sword"]));
      
      if (empty($email))
      {
        echo "<p class='error'>Please try again to register below. All fields are
        required.</p>";
      }  
      
      else if (empty($user) || empty($sword))
      {
        echo "<p class='error'>Please try again to register simply. Enter a username
        and password.</p>";
      } 
      //must see if this person is already registered:
      else if (!empty($email))
      { 
        $query = "SELECT * FROM sketcher WHERE email='$email'";
        $result = mysqli_query($DBConnect, $query);
        $count = mysqli_num_rows($result);
        
        if ($count==1)
        {
          die( "<p class='error'>It seems you are already registered with
          Sketchy.  Please visit the <a href='index.php'>Login</a> Page.</p>");
        }
      else
      { 
        $query1 =
        "INSERT INTO sketcher
        (username, email, sword)
        VALUES ('$user', '$email', '$sword')";
        $result1 = mysqli_query($DBConnect, $query1);
        
        $query2 =
        "SELECT * FROM sketcher;";
        $result2 = mysqli_query($DBConnect, $query2);
        $sketcherid = mysqli_num_rows($result2);
        $_SESSION['sketcherid'] = $sketcherid;
        $_SESSION['user'] = $user;
        
        header('Location: home.php');
      }//ends error checking registration else statement
      }//ends the final else if
    mysqli_close($DBConnect);
    }//ends successful DBConnect else statement
  }//ends POST submit
?>
    <section>
       <form action="registration.php" method="post">
          <table class="login">          
            <tr>
            <td>Username:</td>
            <td><input type = "text" name = "user" maxlength = "10" size = "10" />
            (between 4 and 10 characters)</td>
            </tr><tr>
            <tr>
            <td>Password:</td>
            <td><input type = "password" name = "sword" maxlength = "10" size = "10" />
            (between 4 and 10 characters)</td>
            </tr>
            <td>Email:</td>
            <td><input type = "text" name = "email" maxlength = "256" size = "50" />
            </td>
            </tr>
          </table>
          <br />
          <input class="button" type="submit" name = "submit" value = "register" />
        </form>
      </section>
  </div><!--end page-wrap-->
  </body>
</html>
