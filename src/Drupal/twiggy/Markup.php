<?php


namespace Drupal\twiggy;

/**
 * Class Markup
 *
 * @package Drupal\twiggy
 *
 * @link    https://drupal.stackexchange.com/a/184974/26195
 * @link    https://api.drupal.org/api/drupal/core%21lib%21Drupal%21Core%21Render%21Markup.php/class/Markup/8.2.x
 */
class Markup extends \Twig_Markup implements MarkupInterface {

  use MarkupTrait;

  public function asRenderArray() {
    return ['#markup' => strval($this)];
  }
}
