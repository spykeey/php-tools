<?php
  /**
   * Search an array for a given key and return all occurrences
   * @param  string $key    Key to seach the array for
   * @param  array $array   Array to search in
   * @return array          Return an array with found items
   */
  function array_pluck($key, $array) {
    if (is_array($key) || !is_array($array))
      return array();
    $funct = function ($e) use($key) {
      return ((is_array($e) && array_key_exists($key, $e)) ? $e[$key] : null);
    };
    return array_map($funct, $array);
  }

  /**
   * Reindex an array based on given options
   * @param  array  $array    Array to reindex
   * @param  string  $key     Key to search for and use as the new array key
   * @param  boolean  $ukey   Is the new key unique or not
   * @param  string  $skey    Secondary key to search for
   * @param  boolean $rem     Remove the relocated key from original array
   * @return array            Returns an array with reindexed keys
   */
  function reindexArray($array, $key, $ukey, $skey = '', $rem = true) {
    $response = array();

    if (is_array($array) && !empty($array) && !empty($key)) {
      array_walk($array, function(&$item) use($key, $ukey, $skey, $rem, &$response) {
        if (is_array($item) && isset($item[$key])) {
          $nkey = $item[$key];
          if ($rem) {
            unset($item[$key]);
          }
          if ($ukey) {
            $response[$nkey] = (!empty($skey) && isset($item[$skey])) ? $item[$skey] : $item;
          } else {
            $response[$nkey][] = (!empty($skey) && isset($item[$skey])) ? $item[$skey] : $item;
          }
        }
      });
    }

    return $response;
  }
