<?php

/*
Plugin Name: Folders to Elements 
Description: Generates elements on your website to represent folders on the server.
Author: Alexander Marini
*/

header('Access-Control-Allow-Origin: *'); // remove for dist (add for dev)

function folders_to_elements()
{
   // The base folder to run this plugin on
   $baseFolder = 'app-och-webb';
   $folders = array_filter(glob($baseFolder . '/*', GLOB_ONLYDIR), 'is_dir');

   $elements = "<div class='wp-block-columns alignwide'>";

   foreach ($folders as $folder) {
      $icon = null;

      if (file_exists($folder . '/icon.png')) {
         $icon = $folder . '/icon.png';
      } else {
         $icon = $baseFolder . '/standardIcon.png';
      }

      $data = json_decode(file_get_contents($folder . '/settings.json'), true);
      $author = $data['author'];
      $title = $data['title'];
      $description = $data['description'];

      $elements .= "
         <div class='wp-block-column'>
            <div style='height: 46px' aria-hidden='true' class='wp-block-spacer'></div>
            <figure class='wp-block-image aligncenter size-full is-resized is-style-rounded'>
               <img src='$icon' class='wp-image-82' style='width: 275px; height: auto'/>
            </figure>
            <h3 class='wp-block-heading has-text-align-center'>
               <a href='$folder' data-type='link' data-id='$folder'>$author<br />$title</a>
            </h3>
            <p>$description</p>
         </div>
      ";
   }

   $elements .= "</div>";

   echo $elements; // Return funkar också för WordPress?
}

folders_to_elements();

//add_shortcode('folders_to_elements', 'folders_to_elements');
