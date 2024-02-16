<?php

/*
Plugin Name: Folders to Elements 
Description: Generates elements on your website to represent folders on the server.
Author: Alexander Marini
*/

// Uncomment line below for testing in a different environment.
// header('Access-Control-Allow-Origin: *');

function foldersToElements()
{
   $pluginDir = plugin_dir_path(__FILE__);

   // Base to find folders relative to this plugin.
   $scriptRelativeBase = $pluginDir . "../../../app-och-webb";
   $folders = array_filter(glob($scriptRelativeBase . '/*', GLOB_ONLYDIR), 'is_dir');

   // Base for URLs relative to the page document
   $pageRelativeBase = "../app-och-webb";

   $elements = "<div class='wp-block-columns alignwide'>";

   foreach ($folders as $folder) {
      $folderName = basename($folder);
      $link = $pageRelativeBase . '/' . $folderName;
      $icon = null;

      if (file_exists($folder . '/icon.png')) {
         $icon = $pageRelativeBase . '/' . $folderName . '/icon.png';
      } else {
         $icon = $pageRelativeBase . '/standard-icon.png';
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
               <a href='$link' data-type='link' data-id='$link'>$author<br />$title</a>
            </h3>
            <p>$description</p>
         </div>
      ";
   }

   $elements .= "</div>";

   return $elements;
}

add_shortcode('foldersToElements', 'foldersToElements');
