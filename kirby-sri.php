<?php

/**
 * Kirby SRI - Subresource integrity hashing & cache-busting static assets for Kirby
 *
 * @package   Kirby CMS
 * @author    S1SYPHOS <hello@twobrain.io>
 * @link      http://twobrain.io
 * @version   0.4.0
 * @license   MIT
 */

if(!c::get('plugin.kirby-sri')) return;

// Helper function generating base64-encoded SRI hashes
function sri_checksum($input) {
  $algorithm = c::get('plugin.kirby-sri.algorithm') ? c::get('plugin.kirby-sri.algorithm') : 'sha512';
  $hash = hash($algorithm, $input, true);
  $hash_base64 = base64_encode($hash);

  return "$algorithm-$hash_base64";
}

// Loading core
load([
  's1syphos\\sri\\css' => __DIR__ . DS . 'core' . DS . 'css.php',
  's1syphos\\sri\\js'  => __DIR__ . DS . 'core' . DS . 'js.php'
]);

// Registering with Kirby's extension registry
kirby()->set('component', 'css', 'S1SYPHOS\\SRI\\CSS');
kirby()->set('component', 'js',  'S1SYPHOS\\SRI\\JS');
