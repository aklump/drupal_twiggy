<?php

namespace Drupal\twiggy;

/**
 * Provides DOMDocument helpers for parsing and serializing HTML strings.
 *
 * @ingroup utility
 */
class Html {

  /**
   * Decodes all HTML entities including numerical ones to regular UTF-8 bytes.
   *
   * Double-escaped entities will only be decoded once ("&amp;lt;" becomes
   * "&lt;", not "<"). Be careful when using this function, as it will revert
   * previous sanitization efforts (&lt;script&gt; will become <script>).
   *
   * This method is not the opposite of Html::escape(). For example, this method
   * will convert "&eacute;" to "é", whereas Html::escape() will not convert "é"
   * to "&eacute;".
   *
   * @param string $text
   *   The text to decode entities in.
   *
   * @return string
   *   The input $text, with all HTML entities decoded once.
   *
   * @see html_entity_decode()
   * @see \Drupal\Component\Utility\Html::escape()
   */
  public static function decodeEntities($text) {
    return html_entity_decode($text, ENT_QUOTES, 'UTF-8');
  }

  /**
   * Escapes text by converting special characters to HTML entities.
   *
   * This method escapes HTML for sanitization purposes by replacing the
   * following special characters with their HTML entity equivalents:
   * - & (ampersand) becomes &amp;
   * - " (double quote) becomes &quot;
   * - ' (single quote) becomes &#039;
   * - < (less than) becomes &lt;
   * - > (greater than) becomes &gt;
   * Special characters that have already been escaped will be double-escaped
   * (for example, "&lt;" becomes "&amp;lt;"), and invalid UTF-8 encoding
   * will be converted to the Unicode replacement character ("�").
   *
   * This method is not the opposite of Html::decodeEntities(). For example,
   * this method will not encode "é" to "&eacute;", whereas
   * Html::decodeEntities() will convert all HTML entities to UTF-8 bytes,
   * including "&eacute;" and "&lt;" to "é" and "<".
   *
   * When constructing @link theme_render render arrays @endlink passing the output of Html::escape() to
   * '#markup' is not recommended. Use the '#plain_text' key instead and the
   * renderer will autoescape the text.
   *
   * @param string $text
   *   The input text.
   *
   * @return string
   *   The text with all HTML special characters converted.
   *
   * @see htmlspecialchars()
   * @see \Drupal\Component\Utility\Html::decodeEntities()
   *
   * @ingroup sanitization
   */
  public static function escape($text) {
    return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
  }

}
