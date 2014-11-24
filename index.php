<?php
    session_start();
?><!DOCTYPE html>
<html lang=en>
    <head>
        <meta charset=utf-8>
        <link rel="stylesheet" type="text/css" href="sketchy.css">
        <title>Sketchy | Login</title>    
    </head>
    <body>

    <?php
        if (isset($_POST['submit']) && $_POST['submit'] == 'log in')
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
            
            $tempmail = mysqli_real_escape_string($DBConnect, $_POST["email"]);
            $email = strtolower($tempmail);
            $sword = sha1(mysqli_real_escape_string($DBConnect, $_POST["sword"]));
            

            $query = "SELECT * FROM sketcher WHERE email='$email' AND sword='$sword'";
            $result = mysqli_query($DBConnect, $query);
            $count = mysqli_num_rows($result);
            while ($row = mysqli_fetch_assoc($result))
            {
                $userid = $row['sketcherid'];
                $_SESSION['sketcherid'] = $userid;
            }
            if ($count==1) 
            {   
                header('Location: home.php');
            }
            else
            {
                echo "<p class='error'>Your email and password are not on record. Perhaps you
                would like to try again or <a href='registration.php'>Register</a>.</p>";
            }
            mysqli_close($DBConnect);
            }//ends successful DBConnect else statement
        }//ends POST submit
        
    ?>
    <div id="page-wrap">
        <div class="row">
            <header>
                <div class="col-1">
                    <div id="headleft">
                        <h1>Sketchy</h1>
                    </div>
                    
                    <span id="sub">SVG for You and Me</span>
                </div>        
            </header>
        </div>
        
        <div class="row">  
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

        <div class="row">            
            <div class="col-1">
                <section>

                <form action="index.php" method="post">
                    <table class="login">
                        <tr>
                        <td>Email:</td>
                        <td><input type = "text" name = "email" maxlength = "256" size = "50" />
                        </td>
                        </tr>
                        <tr>
                        <td>Password:</td>
                        <td><input type = "password" name = "sword" maxlength = "10" size = "10" />
                        (between 4 and 10 characters)</td>
                        </tr>
                    </table>
                    <br />
                    <input class="button" type="submit" name = "submit" value = "log in" />
                </form>

                <p>If you are new to the Sketchy community, please join us:
                <a href='registration.php'>Register</a>.</p>
  
                </section>                  
            </div>
        </div>
    </div><!--end page-wrap-->
    </body>
</html>

