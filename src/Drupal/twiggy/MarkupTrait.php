<?php

namespace Drupal\twiggy;

trait MarkupTrait {

  /**
   * The safe string.
   *
   * @var string
   */
  protected $string;

  /**
   * Creates a Markup object if necessary.
   *
   * If $string is equal to a blank string then it is not necessary to create a
   * Markup object. If $string is an object that implements MarkupInterface it
   * is returned unchanged.
   *
   * @param mixed $string
   *   The string to mark as safe. This value will be cast to a string.
   *
   * @return string|\Drupal\Component\Render\MarkupInterface
   *   A safe string.
   */
  public static function create($string) {
    if ($string instanceof MarkupInterface) {
      return $string;
    }
    $string = (string) $string;
    if ($string === '') {
      return '';
    }
    $safe_string = new static($string, _twiggy_defaults()['twiggy_charset']);

    return $safe_string;
  }

  /**
   * Returns a representation of the object for use in JSON serialization.
   *
   * @return string
   *   The safe string content.
   */
  public function jsonSerialize() {
    return $this->__toString();
  }

}
