<?php

/**
 * Kirby SRI - Subresource integrity hashing & cache-busting static assets for Kirby
 *
 * @package   Kirby CMS
 * @author    S1SYPHOS <hello@twobrain.io>
 * @link      http://twobrain.io
 * @version   0.6.0
 * @license   MIT
 */

if (c::get('plugin.kirby-sri', false)) {
    // Loading SRI helper function
    require_once __DIR__ . DS . 'utility' . DS . 'helper.php';

    // Loading settings & core
    load([
      'kirby\\plugins\\sri\\css' => __DIR__ . DS . 'core' . DS . 'css.php',
      'kirby\\plugins\\sri\\js'  => __DIR__ . DS . 'core' . DS . 'js.php'
    ]);

    // Registering with Kirby's extension registry
    kirby()->set('component', 'css', 'Kirby\Plugins\\SRI\\CSS');
    kirby()->set('component', 'js', 'Kirby\Plugins\\SRI\\JS');
}
