<?php
  session_start();
?><!DOCTYPE html>
<html lang=en>
  <head>
    <meta charset=utf-8>
    <link rel="stylesheet" type="text/css" href="sketchy.css">
    <title>Sketchy | Search</title>
    <script src="js/masonry.pkgd.min.js"></script>      
  </head>
  <body>
    
  <div id="page-wrap">
    <div class="row1">
      <header>
        <div class="col-1">
          <div id="headleft">
            <h1><a id="head" href='home.php'>Sketchy</a></h1>
            <form method='get' action='search.php'>
            <input type=search name=s placeholder="search sketches">
            <input type='submit' value='search' name='submit'>
            </form>
            See All Sketches &rarr; <a href='sketches.php'>&oS;</a>
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
    <div class="row3">            
      <div class="col-1">
        <section>
        <h2>Sketches Search</h2>
        <h3><a href="upload.php" id="addsketch">(Add a Sketch)</a></h3>
        </section>                  
      </div>
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
      $search = mysqli_real_escape_string($DBConnect, $_GET["s"]);
      
    $query1 =
    "SELECT DISTINCT  sketch.sketchid, title, description, path, date, sketcherid FROM sketch, describes, tags
    WHERE title LIKE '%$search%' OR description like '%$search%' OR tag LIKE '%$search%'
    AND sketch.sketchid=describes.sketchid AND describes.tagid=tags.tagid
    ORDER BY sketchid DESC";
    $result1 = mysqli_query($DBConnect, $query1);
    echo "<div id='container' class='js-masonry''data-masonry-options='{'itemSelector':'.item'}'>";
      while ($row = mysqli_fetch_assoc($result1))
      {
        echo "<div class='item'>";
        echo "<div class='center'>";
        echo "<div class='title'>{$row['title']}</div>";
        echo "<div class='svg_overlay'>";
        echo "<div onclick='alert(this.innerHTML)'>";
        $svg_path = ($row['path']);
        echo file_get_contents($row['path']);
        echo "</div>";//ends svg onclick alert
        echo "</div>";//end svg_overlay
        echo "<div class='description'>{$row['description']}<br>";
        $date = "{$row['date']}";
        
        $query2=
        "SELECT sketcher.sketcherid, username FROM sketcher, sketch
        WHERE sketcher.sketcherid=sketch.sketcherid
        AND sketchid={$row['sketchid']}";
        $result2 = mysqli_query($DBConnect, $query2);
        
        $query3 =
        "SELECT tags.tagid, tag FROM tags, describes, sketch
        WHERE sketch.sketchid=describes.sketchid
        AND describes.tagid=tags.tagid
        AND sketch.sketchid={$row['sketchid']}";
        $result3 = mysqli_query($DBConnect, $query3);
        
        while ($row = mysqli_fetch_assoc($result2))
        {
          echo "<span class='date'>added by <a href='sketcher.php?sketcherid={$row['sketcherid']}&sketcher={$row['username']}'>{$row['username']}</a> on $date</span></div>";
        }
        
        echo "<div class='tag'>";
        while ($row = mysqli_fetch_assoc($result3))
        {
          echo "|<a href='tag.php?tagid={$row['tagid']}&tag={$row['tag']}'> {$row['tag']} </a>";
        }
        echo "|</div>";//ends tag div
        echo "<a class='deconstruct' href='search.php?s=$search&svg=$svg_path#decon'>deconstruct</a>";
        
        echo "</div>";
        echo "</div>";//div class item
      }
    echo "</div>";//end container
    
    if(isset($_GET['svg']))
    {
      echo "<span id='decon'>";
      $svg = $_GET['svg'];
      include("parseSVG.php");
      parseSVG($svg);
      echo "</span>"; //end shapes class and parseSVG function
    }
      
    mysqli_close($DBConnect);
    }//ends successful DBConnect else statement
  }
  ?>
  </div><!--end page-wrap-->
  </body>
</html>
