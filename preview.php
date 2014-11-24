<?php

    session_start();

?><!DOCTYPE html>

<html lang=en>

    <head>

        <meta charset=utf-8>

        <link rel="stylesheet" type="text/css" href="sketchy.css">

        <title>Sketchy | Preview</title>

    </head>

    <body>

    <div id="page-wrap">

        <div class="row1">

            <header>

                <div class="col-1">

                    <div id="headleft">

                        <h1><a id="head" href='home.php'>Sketchy</a></h1>

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



        <h2>Describe your Sketch</h2> 

        <div class="center">

            <form class="mid" action="preview.php" method="post">

                <textarea autofocus name="description" wrap="soft"></textarea><br>  

                <input class="button" type="submit" name="submit" value="post" /><br>

            </form>

        </div>

        

<?php

    if(!isset($_SESSION['sketcherid']))

    {

        die("<h3>Sorry, but you are not logged in. Try <a href='index.php'>logging

        in</a> again.</h3>");

    }

    else

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

                $sketchid = $_SESSION['sketchid'];

                $query1 =

                "SELECT title, path FROM sketch

                WHERE sketchid = $sketchid";

                $result1 = mysqli_query($DBConnect, $query1);



                while ($row = mysqli_fetch_assoc($result1))

                {

                    echo "<h1>{$row['title']}</h1>";

                    echo file_get_contents($row['path']);

                }

            

            if(isset($_POST['submit']) && $_POST['submit'] == "post")

            {

                $description = mysqli_real_escape_string($DBConnect, $_POST['description']);

                $date = date("Y-m-d H:i:s");

              

                $query2 =

                "UPDATE sketch

                SET description='$description',date='$date'

                WHERE sketchid=$sketchid";

                $result2 = mysqli_query($DBConnect, $query2);



                header('Location: home.php');

            } //ends php code on submission button

        mysqli_close($DBConnect);

        }//ends successful DBConnect else statement

    } //ends php code on submission button

?>

    </div><!--end page-wrap-->

    </body>

</html>