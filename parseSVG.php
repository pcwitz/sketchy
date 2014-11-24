<?php

    function parseSVG($svg_path)

    {

        $doc = new DOMDocument();

        $doc->load($svg_path);

        $xpath = new domXPath($doc);

        $query = "//*";

        $xpathQuery = $xpath->query($query);



        $size = $xpathQuery->length;

        for ($i=0; $i<$size; $i++)

        {

            $shapes = array('rect','circle','line','ellipse','polygon','polyline','path');

            $node = $xpathQuery->item($i);

            foreach ($shapes as $shape)

            {

                if ($node->nodeName == $shape)

                {

                    $clonenode = $node->cloneNode(true);

                    foreach ($clonenode->attributes as $att)

                    {

                        $attributes[] = $att->nodeName . "='" . $att->nodeValue . "' ";

                    }

                $final = "<svg viewBox='0 0 600 780'><" . $clonenode->nodeName . " " . implode($attributes) . "/></svg>";

                echo "<div class='shapes'>";

                echo "<div class='svg_overlay'>";

                echo "<div onclick='alert(this.innerHTML)'>";

                echo $final;

                echo "</div>";//ends svg onclick alert

                echo "</div>";//end svg_overlay

                echo "</div>";//ends shapes

                $attributes = array();

                }    

            }

        }

    }

?>