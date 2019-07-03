<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        <?php
            if (isset($title)) {
                echo $title;
            }
        ?>
        Online Ordering System 
    </title> 
    <?php 
        if (isset($headscript) && isset($headscript['style'])) {
            foreach($headscript['style'] as $st) {
                echo "<link rel='stylesheet' href='".$st."'/>";
            }
        }
       ?>
</head>
<body>
 <div id="wrapper">