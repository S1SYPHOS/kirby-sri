<?php

namespace S1SYPHOS\SRI;

use Asset;
use f;
use settings;
use html;

class CSS extends \Kirby\Component\CSS {

  /**
   * Builds the html link tag for the given css file
   *
   * @param string $url
   * @param string|array $media Either a media string or an array of attributes
   * @return string
   */

  public function tag($url, $media = null) {

    if(is_array($url)) {
      $css = array();
      foreach($url as $u) $css[] = $this->tag($u, $media);
      return implode(PHP_EOL, $css) . PHP_EOL;
    }

    // auto template css files
    if($url == '@auto') {
      $file = $this->kirby->site()->page()->template() . '.css';
      $root = $this->kirby->roots()->autocss() . DS . $file;
      $url  = $this->kirby->urls()->autocss() . '/' . $file;
      if(!file_exists($root)) return false;
      $url = preg_replace('#^' . $this->kirby->urls()->index() . '/#', null, $url);
    }

    $url = ltrim($url, '/');

    if(file_exists($url)) {
      // generate sri hash for css files
      $cssInput = (new Asset($url))->content();
      $cssIntegrity = sri_checksum($cssInput);

      // add timestamp for cache-busting
      $modified = filemtime($url);
      $filename = f::name($url) . '.' . $modified . '.' . f::extension($url);
      $dirname  = f::dirname($url);
      $url = ($dirname === '.') ? $filename : $dirname . '/' . $filename;

      // build an array of SRI-related attributes
      $cssOptions = array(
        'integrity' => $cssIntegrity, // generated SRI hash
        'crossorigin' => settings::crossorigin(), // user-defined 'crossorigin' attribute
      );
    }

    // build the array of HTML attributes
    $attr = array(
      'rel'  => 'stylesheet',
      'href' => url($url)
    );

    if(file_exists($url)) {
      $attr = array_merge($attr, $cssOptions);
    }

    if(is_array($media)) {
      // merge array with custom options
      $attr = array_merge($attr, $media);
    } else if(is_string($media)) {
      // if there's no such array, just set media key
      $attr['media'] = $media;
    }

    // return the proper 'link' tag
    return html::tag('link', null, $attr);
  }
}
