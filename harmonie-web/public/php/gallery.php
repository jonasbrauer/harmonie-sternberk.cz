<?php

function scanAllDir($target) {
  $partial_result = array();
  
  $files = glob( $target .'*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned
  foreach( $files as $file )
  { 
    if( is_dir($file) ){
      // $path -> dict key: strip slashes for cleaner dictionary keys
      // $file -> dict value: absolute/reachable paths for the 'src' attribute
      $path = $file;
      if( substr($path, -1) == '/') {
        $path = substr($path, 0, -1);
      }
      $path = substr($path, strrpos($path, '/') + 1) ?? $path;

      // recursively go through the dirtree
      $partial_result[$path] = scanAllDir($file);

    } else if(
      // filter files by image extension
      strpos($file, '.jpg') !== false ||
      strpos($file, '.JPG')  !== false ||
      strpos($file, '.png')  !== false ||
      strpos($file, '.PNG')  !== false 
    ) {
      if( is_null($partial_result['.'] ?? null) ) {
        $partial_result['.'] = array();
      }
      $partial_result['.'][] = '/' . str_replace('../', '', $file);
    }
  }
  return $partial_result;
}

$result = scanAllDir('../photos/gallery');

header('Content-Type: application/json');
echo json_encode($result, true);

exit();

?>