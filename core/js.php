<?php

namespace Kirby\Plugins\SRI;

use Asset;
use f;
use c;
use html;

class JS extends \Kirby\Component\JS
{

    /**
     * Builds the html script tag for the given javascript file
     *
     * @param string $src
     * @param boolean|array $async Either true for the async attribute or an array of attributes
     * @return string
     */

    public function tag($src, $async = false)
    {
        if (is_array($src)) {
            $js = array();
            foreach ($src as $s) {
                $js[] = $this->tag($s, $async);
            }
            return implode(PHP_EOL, $js) . PHP_EOL;
        }

        // auto template css files
        if ($src == '@auto') {
            $file = $this->kirby->site()->page()->template() . '.js';
            $root = $this->kirby->roots()->autojs() . DS . $file;
            $src  = $this->kirby->urls()->autojs() . '/' . $file;
            if (file_exists($root)) {
                $src = preg_replace('#^' . $this->kirby->urls()->index() . '/#', null, $url);
            }
        }

        $src = ltrim($src, '/');

        if (file_exists($src)) {
            // generate sri hash for css files
            $jsInput = (new Asset($src))->content();
            $jsIntegrity = sri_checksum($jsInput);

            if (c::get('fingerprinting')) {
                // add timestamp for cache-busting
                $modified = filemtime($src);
                $filename = f::name($src) . '.' . $modified . '.' . f::extension($src);
                $dirname  = f::dirname($src);
                $src = ($dirname === '.') ? $filename : $dirname . '/' . $filename;
            }

            // build an array of SRI-related attributes
            $jsOptions = array(
              'integrity' => $jsIntegrity, // generated SRI hash
              'crossorigin' => c::get('plugin.kirby-sri.crossorigin', 'anonymous'), // user-defined 'crossorigin'
            );
        }

        // build the array of HTML attributes
        $attr = array(
          'src' => url($src)
        );

        if (isset($jsOptions)) {
            $attr = array_merge($attr, $jsOptions);
        }

        if (is_array($async)) {
            // merge array with custom options
            $attr = array_merge($attr, $async);
        } elseif ($async === true) {
            // if there's no such array, just set async key
            $attr['async'] = true;
        }

        // return the proper 'script' tag
        return html::tag('script', '', $attr);
    }
}
