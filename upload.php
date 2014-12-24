<?php
  session_start();
?><!DOCTYPE html>
<html lang=en>
  <head>
    <meta charset=utf-8>
    <link rel="stylesheet" type="text/css" href="sketchy.css">
    <title>Sketchy | Upload</title>
  </head>
  <body>
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
      
  if(isset($_POST['submit']) && $_POST['submit'] == "upload graphic")
  {
      
    $title = mysqli_real_escape_string($DBConnect, $_POST['title']);
    
    $tag1 = mysqli_real_escape_string($DBConnect, $_POST['tag1']);
    $tag2 = mysqli_real_escape_string($DBConnect, $_POST['tag2']);
    $tag3 = mysqli_real_escape_string($DBConnect, $_POST['tag3']);
    $filetype = ($_FILES["uploadedfile"]["type"]);
    
    if (!($filetype == "image/svg+xml" || $filetype == "text/xml"))
    {         
      die ("Only XML or SVG files may be uploaded." .
      htmlentities($_FILES['uploadedfile']['name']) . " is not a valid file"
      . "<br />\n");
    }      
    else if (empty($title))
    {
    echo "<p class='error'>Please try again to include a title.  This
    field is required.</p>";
    }  
    else
    {
    //renaming of file
    $orgname = basename ($_FILES['uploadedfile']['name']);
    
    $query1 = "SELECT MAX(sketchid) AS sid FROM sketch";
    $result1 = mysqli_query($DBConnect, $query1);
    while ($row = mysqli_fetch_array($result1))
    {
      $id = $row['sid'];
    }
    $sketchid = ++$id;
    $_SESSION['sketchid'] = $sketchid;
    
    $newname = str_replace($orgname,$sketchid . ".xml",$orgname);
  
    /*create a file folder for the sketcher using sketcherid to store his
    graphics unless a folder already exists*/
    $sketcherid = $_SESSION['sketcherid'];
    if (file_exists($sketcherid)) //{$_SESSION['sketcherid']}
    {
      //Folder where the file is going to be placed after temp location
      $target_path = $sketcherid . "/"; //$_SESSION['sketcherid']
      /*Add the original filename to our target path.  
      Result is "uploads/filename.extension" */
      $target_path = $target_path . basename ($newname); 
      //move_uploaded_file() function moves the uploaded file from its temp
      //to a perm destination. result is either true(successful) or false.
      $result = (move_uploaded_file($_FILES['uploadedfile']['tmp_name'],
      $target_path));
    }
    else
    {
      //
      mkdir($sketcherid,0755);
      //Folder where the file is going to be placed after temp location
      $target_path = $sketcherid . "/"; //$_SESSION['sketcherid']
      /*Add the original filename to our target path.  
      Result is "uploads/filename.extension" */
      $target_path = $target_path . basename ($newname); 
      //move_uploaded_file() function moves the uploaded file from its temp
      //to a perm destination. result is either true(successful) or false.
      $result = (move_uploaded_file($_FILES['uploadedfile']['tmp_name'],
      $target_path));
    }
      if ($result == TRUE)
      {
        $query2 =
        "INSERT INTO sketch (title, path, sketcherid) VALUES ('$title', '$target_path', $sketcherid)";
        $result2 = mysqli_query($DBConnect, $query2);
//todo: make next three queries into a function  
        if (!empty($tag1))
        { 
          //check to see if tag1 already exists
          $query_tag1Exists =
          "SELECT tagid FROM tags WHERE tag='$tag1'";
          $result_tag1Exists = mysqli_query($DBConnect, $query_tag1Exists);
          
          if (!mysqli_num_rows($result_tag1Exists))
          {
            $query_tag1 =
            "INSERT INTO tags (tag) VALUES ('$tag1')";
            $result_tag1 = mysqli_query($DBConnect, $query_tag1);
            $tagid1 = mysqli_insert_id($DBConnect);
            $query_desc1 =
            "INSERT INTO describes (sketchid, tagid) VALUES ($sketchid, $tagid1)";
            $result_desc1 = mysqli_query($DBConnect, $query_desc1);
          }
          else
          {
            while ($row = mysqli_fetch_assoc($result_tag1Exists))
            {
              $tagid1 = $row['tagid'];
            }
            $query_desc1 =
            "INSERT INTO describes (sketchid, tagid) VALUES ($sketchid, $tagid1)";
            $result_desc1 = mysqli_query($DBConnect, $query_desc1);
          }
        }
        if (!empty($tag2))
        { 
          //check to see if tag1 already exists
          $query_tag2Exists =
          "SELECT tagid FROM tags WHERE tag='$tag2'";
          $result_tag2Exists = mysqli_query($DBConnect, $query_tag2Exists);
          
          if (!mysqli_num_rows($result_tag2Exists))
          {
            $query_tag2 =
            "INSERT INTO tags (tag) VALUES ('$tag2')";
            $result_tag2 = mysqli_query($DBConnect, $query_tag2);
            $tagid2 = mysqli_insert_id($DBConnect);
            $query_desc2 =
            "INSERT INTO describes (sketchid, tagid) VALUES ($sketchid, $tagid2)";
            $result_desc2 = mysqli_query($DBConnect, $query_desc2);
          }
          else
          {
            while ($row = mysqli_fetch_assoc($result_tag2Exists))
            {
              $tagid2 = $row['tagid'];
            }
            $query_desc2 =
            "INSERT INTO describes (sketchid, tagid) VALUES ($sketchid, $tagid2)";
            $result_desc2 = mysqli_query($DBConnect, $query_desc2);
          }
        }
        if (!empty($tag3))
        { 
          //check to see if tag1 already exists
          $query_tag3Exists =
          "SELECT tagid FROM tags WHERE tag='$tag3'";
          $result_tag3Exists = mysqli_query($DBConnect, $query_tag3Exists);
          
          if (!mysqli_num_rows($result_tag3Exists))
          {
            $query_tag3 =
            "INSERT INTO tags (tag) VALUES ('$tag3')";
            $result_tag3 = mysqli_query($DBConnect, $query_tag3);
            $tagid3 = mysqli_insert_id($DBConnect);
            $query_desc3 =
            "INSERT INTO describes (sketchid, tagid) VALUES ($sketchid, $tagid3)";
            $result_desc3 = mysqli_query($DBConnect, $query_desc3);
          }
          else
          {
            while ($row = mysqli_fetch_assoc($result_tag3Exists))
            {
              $tagid3 = $row['tagid'];
            }
            $query_desc3 =
            "INSERT INTO describes (sketchid, tagid) VALUES ($sketchid, $tagid3)";
            $result_desc3 = mysqli_query($DBConnect, $query_desc3);
          }
        }
        /*code below from: http://us1.php.net/manual/en/domelement.setattribute.php
        uses DOM manipulation to change the width and height attributes
        of the svg element on upload because when these attributes are
        included the file cannot be appropriately scaled to a new page.
        width and height in an svg element creat a viewport which
        determines the size of the drawing seen in proportion to the
        entire drawing. By deleting width and height we make sure the
        viewport is the size of the viewBox, meaning you can see
        the entire graphic uploaded, not just a portion.  Also needs to
        made into a function.
                                        */
        $doc = new DOMDocument();
        $doc->load($target_path);
        foreach($doc->getElementsByTagName('svg') as $svg)
        {
          if($svg->hasAttribute('viewBox')===false)
          {
            $svg->setAttribute('viewBox','0 0 800 960');
          }
          foreach(array('width', 'height', 'preserveAspectRatio') as $attribute_to_remove)
          {
            if($svg->hasAttribute($attribute_to_remove))
            {
              $svg->removeAttribute($attribute_to_remove);
            }
        /*this is good code if needed in the future to change the
          attribute as well    
            if($attribute_to_remove=='height')
            {
              if(!$svg->hasAttribute($attribute_to_remove))
              {
                $svg->setAttribute($attribute_to_remove,'25%');
              } 
            }
            if($attribute_to_remove=='width')
            {
              if(!$svg->hasAttribute($attribute_to_remove))
              {
                $svg->setAttribute($attribute_to_remove,'25%');
              }
            }                                                     */       
          }
          $svg->setAttribute('preserveAspectRatio','xMinYMin meet');
          
        }
        $doc->save($target_path);
        header('Location: preview.php');
      }
      else
      {
        echo "Could not upload file.<br>\n";
      }   
    }//ends else of filetype
  }//ends if upload graphic submitted
    mysqli_close($DBConnect);
    }//ends successful DBConnect else statement
  } //ends php code on submission button
?>
    
  <div id="page-wrap">
    <div class="row">
      <header>
        <div class="col-1">
          <div id="headleft">
            <h1><a id="head" href='home.php'>Sketchy</a></h1>
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
    <section>
    <h2>Add a Sketch</h2>
        <form class="mid" enctype="multipart/form-data" action="upload.php" method="POST">
          <div class="center">
            <input class="upload" type="hidden" name="MAX_FILE_SIZE" value="250000" />
            <input class="upload" type="file" name="uploadedfile" accept="image/svg+xml"/><br>
            <input class="upload" type="text" name="title" placeholder="title" /><br>
            <input class="upload" type="text" name="tag1" placeholder="tag 1 (optional)" /><br>
            <input class="upload" type="text" name="tag2" placeholder="tag 2 (optional)" /><br>
            <input class="upload" type="text" name="tag3" placeholder="tag 3 (optional)" /><br>
            <input class="button" type="submit" name="submit" value="upload graphic" /><br>
          </div>
        </form>
    </section>
  </div><!--end page-wrap-->
  </body>
</html>
