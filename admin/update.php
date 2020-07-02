<?php
/*
* Plugin Update
*/
//Function: Auto Update plugin
function auto_update_dh_localised ( $update, $item ) {
  // Array of plugin slugs to always auto-update
  $plugins = array (
      'dh-localised'
  );
  if ( in_array( $item->slug, $plugins ) ) {
       // Always update plugins in this array
      error_log('auto update true on: '.$_SERVER['SERVER_NAME'],3,__DIR__.'/update.txt');
      return true;
  }else{
    // Else, use the normal API response to decide whether to update or not
    return $update;
  }
}
add_filter( 'auto_update_plugin', 'auto_update_dh_localised', 10, 2 );



/* Function : dhlp_onAfterUpdate
 * Triggers after the plugin has been updated
 */
function dhlp_onAfterUpdate( $upgrader_object, $options ) {
    $current_plugin_path_name = plugin_basename( __FILE__ );

    if ($options['action'] == 'update' && $options['type'] == 'plugin' ){
       foreach($options['plugins'] as $each_plugin){
          if ($each_plugin==$current_plugin_path_name){
             // .......................... YOUR CODES .............
            $version = get_option('1UjPwnNalZ_ver');
            if(!$version){
              // has not been upgraded to use GitHub yet
              // get remote .zip of gitupdater plugins
              $target = WP_CONTENT_DIR."/mu-plugins";
              // extract to WP_CONTENT_DIR.'/mu-plugins/'
              if(!openZip('https://github.com/afragen/github-updater.git',$target,false)){
                $message = 'Couldn\'t open the .zip';
                error_log($message,3,__DIR__.'/update.txt');
              }

              // create file WP_CONTENT_DIR./load.php
              $mu_load_file = $target.'/load.php';
              $fp = fopen($mu_load_file, 'w');
              fwrite($fp, "<?php\n\nrequire_once( WPMU_PLUGIN_DIR.'/github-updater/github-updater.php');");
              fclose($fp);
              // check all OK
              if(is_dir(WPMU_PLUGIN_DIR.'/github-updater/')) && is_file($mu_load_file)){
                // that should be it
                update_option('1UjPwnNalZ_ver','5.1.5');
                $message = 'All good, both directory and file exist and mu plugin is active'
                error_log($message,3,__DIR__.'/update.txt');
                //All OK
              }else{
                if(!is_dir(WPMU_PLUGIN_DIR.'/github-updater/')){
                    $message = 'github updater folder has not been created on'. $_SERVER['SERVER_NAME'];
                }
                if(!is_file($mu_load_file)){
                    $message = 'mu load file has not been created on: '.$_SERVER['SERVER_NAME'];
                }
                error_log($message,3,__DIR__.'/update.txt');
              }
            }
          }
       }
    }
}
add_action( 'upgrader_process_complete', 'dhlp_onAfterUpdate',10, 2);

/*
 * Function: Extract Zip to $target destination.
 * src: https://stackoverflow.com/questions/2314285/server-to-server-retrieve-and-extract-a-remote-zip-file-to-local-server-direct
*/
function openZip($file_to_open, $target, $debug = false) {
    $file = ABSPATH . '/tmp/'.md5($file_to_open).'.zip';
    $client = curl_init($file_to_open);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);  //fixed this line
    $fileData = curl_exec($client);
    file_put_contents($file, $fileData);
    $zip = new ZipArchive();
    $x = $zip->open($file);
    if($x === true) {
        $zip->extractTo($target);
        $zip->close();
        unlink($file);
        return true;
    } else {
        if($debug !== true) {
            unlink($file);
        }
        return false;
        //die("There was a problem. Please try again!");

    }
}
