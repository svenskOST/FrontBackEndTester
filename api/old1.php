<?php
/*
Plugin Name: Project Generator
Description: Generates project elements on the site from project folders on the server.
Author: Alexander Marini
*/

function project_generator_shortcode()
{
   $baseFolder = 'https://elevsidor.kreativlink.se/app-och-webb';
   $projects = array_filter(glob($baseFolder . '/*', GLOB_ONLYDIR), 'is_dir');

   $columns = '';

   foreach ($projects as $project) {
      $icon = 0;

      if (file_exists($project . '/icon.png')) {
         $icon = $project . '/icon.png';
      } else {
         $icon = $baseFolder . '/standardIcon.png';
      }

      $data = json_decode(file_get_contents($project . '/settings.json'), true);
      $author = $data['author'];
      $title = $data['title'];
      $description = $data['description'];

      $columns .= "
         <!-- wp:column -->
         <div class='wp-block-column'>
            <!-- wp:spacer {'height':'46px'} -->
            <div style='height: 46px' aria-hidden='true' class='wp-block-spacer'></div>
            <!-- /wp:spacer -->
      
            <!-- wp:image {'align':'center','id':82,'width':'275px','height':'auto','sizeSlug':'full','linkDestination':'none','style':{'color':{}},'className':'is-style-rounded'} -->
            <figure class='wp-block-image aligncenter size-full is-resized is-style-rounded'>
               <img src='$icon' class='wp-image-82' style='width: 275px; height: auto'/>
            </figure>
            <!-- /wp:image -->
      
            <!-- wp:heading {'textAlign':'center','level':3} -->
            <h3 class='wp-block-heading has-text-align-center'>
               <a href='$project' data-type='link' data-id='$project'>$author<br />$title</a>
            </h3>
            <!-- /wp:heading -->
      
            <!-- wp:paragraph -->
            <p>$description</p>
            <!-- /wp:paragraph -->
         </div>
         <!-- /wp:column -->    
      ";
   }

   return "
      <!-- wp:columns {'align':'wide'} -->
      <div class='wp-block-columns alignwide'>"
      . $columns . "
      </div>
      <!-- /wp:columns -->";
}
add_shortcode('project_generator', 'project_generator_shortcode');
