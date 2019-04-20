<?php

namespace Drupal\Tests\twiggy;

use AKlump\DrupalTest\Drupal7\UnitTestCase;
use Drupal\twiggy\Twiggy;

/**
 * Test coverage for Twiggy.
 *
 * @group loft
 * @coversDefaultClass Twiggy;
 * @SuppressWarnings(PHPMD.StaticAccess)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class TwiggyFunctionsUnitTest extends UnitTestCase {

  /**
   * Define the class being tested, it's arguments and mock objects needed.
   *
   * @var array
   *   The schema array for this test.
   */
  protected function getSchema() {
    return [
      'classToBeTested' => FALSE,
    ];
  }

  /**
   * Provides data for test_twiggy_is_attributes_string.
   */
  public function dataForTest_twiggy_is_attributes_stringProvider() {
    $tests = array();
    $tests[] = array(
      'Sometimes strings are just strings',
      FALSE,
    );
    $tests[] = array(
      'class="t-explore-stories"',
      FALSE,
    );
    $tests[] = array(
      ' data-autofocus',
      TRUE,
    );
    $tests[] = array(
      ' class="t-explore-stories" data-autofocus data-amplitude="{&quot;do&quot;:&quot;re&quot;,&quot;mi&quot;:&quot;fa&quot;}" href="/library"',
      TRUE,
    );
    $tests[] = array(
      ' class="red-color" style="background-color: #ffff00;',
      TRUE,
    );
    $tests[] = array(
      ' class="red-color"',
      TRUE,
    );

    return $tests;
  }

  /**
   * @dataProvider dataForTest_twiggy_is_attributes_stringProvider
   */
  public function test_twiggy_is_attributes_string($subject, $control) {
    $this->assertSame($control, _twiggy_is_attributes_string($subject));
  }

}
