<?php

function KojnLog($msg) {
  $file = dirname(__FILE__) . '/kojn.log';
  $contents = date('d-m H:i:s').": ";

  if (is_array($contents))
    $contents = $contents . var_export($contents, true);
  else if (is_object($contents))
    $contents = $contents . json_encode($contents);

  file_put_contents($file, $contents."\n", FILE_APPEND);

  return $contents;
}

?>

