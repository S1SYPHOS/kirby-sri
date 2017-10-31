<?php

/**
 * Adding SRI Hash to css & js files and cache-busting them
 *
 * @version 0.3.0
 * @author S1SYPHOS <hello@twobrain.io>
 */

if(!c::get('sri-hash')) return;

function sri_checksum($input) {
  $algorithm = c::get('sri-hash.algorithm') ? c::get('sri-hash.algorithm') : 'sha512';
  $hash = hash($algorithm, $input, true);
  $hash_base64 = base64_encode($hash);

  return "$algorithm-$hash_base64";
}

load([
  's1syphos\\sri\\css' => __DIR__ . DS . 'core' . DS . 'css.php',
  's1syphos\\sri\\js'  => __DIR__ . DS . 'core' . DS . 'js.php'
]);

kirby()->set('component', 'css', 'S1SYPHOS\\SRI\\CSS');
kirby()->set('component', 'js',  'S1SYPHOS\\SRI\\JS');
