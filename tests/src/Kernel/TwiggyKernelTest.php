<?php

namespace Drupal\Tests\twiggy;

use AKlump\DrupalTest\Drupal7\KernelTestCase;
use Drupal\twiggy\Twiggy;

/**
 * Test coverage for Twiggy.
 *
 * @group loft
 * @coversDefaultClass Twiggy;
 * @SuppressWarnings(PHPMD.StaticAccess)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class TwiggyKernelTest extends KernelTestCase {

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

  public function testBannerVideoAndBannerVideoTeaserThemesCanCooexist() {
    $theme_registry = [];
    $theme_registry['banner_video'] = json_decode('{"twiggy":"gop5_theme_theme","variables":{"overlay_uri":"","video_uri":"","image_uri":"","attributes":null,"title_attributes":null,"content_attributes":null,"image_attributes":null,"link_attributes":null},"d8now":[],"type":"theme","theme path":"sites\/all\/themes\/gop5_theme","function":"gop5_theme_banner_video","preprocess functions":["d8now_theme_hook_preprocess","gop5_theme_preprocess_banner_video"],"process functions":["d8now_theme_hook_process"]}', TRUE);
    $theme_registry['banner_videoteaser'] = json_decode('{"twiggy":"gop5_theme_theme","variables":{"title":"","description":"","target_href":"","cta_title":"Watch the film","image_uri":"","image_style":"smaller_5to3","attributes":null,"title_attributes":null,"content_attributes":null,"image_attributes":null,"link_attributes":null},"d8now":[],"type":"theme","theme path":"sites\/all\/themes\/gop5_theme","function":"gop5_theme_banner_videoteaser","preprocess functions":["d8now_theme_hook_preprocess","gop5_theme_preprocess_banner_videoteaser"],"process functions":["d8now_theme_hook_process"]}', TRUE);

    // Assert the are correct before the function.
    $this->assertContains('gop5_theme_preprocess_banner_video', $theme_registry['banner_video']['preprocess functions']);
    $this->assertContains('gop5_theme_preprocess_banner_videoteaser', $theme_registry['banner_videoteaser']['preprocess functions']);
    twiggy_theme_registry_alter($theme_registry);

    // Assert the did not get corrupted in the function.
    $this->assertContains('gop5_theme_preprocess_banner_video', $theme_registry['banner_video']['preprocess functions']);
    $this->assertContains('gop5_theme_preprocess_banner_videoteaser', $theme_registry['banner_videoteaser']['preprocess functions']);
  }

  /**
   * @covers twiggy_theme_registry_alter
   */
  public function testAssertThemeRegistryAlterAffectsThemeWhenTwiggyVarIsSet() {
    $theme_registry = [];
    $theme_registry['resource_download_confirmation'] = [
      'twiggy' => 'gop5_theme_theme',
      'function' => 'gop5_theme_resource_download_confirmation',
      'theme path' => 'sites/all/themes/gop5_theme',
      'variables' => array('node' => NULL, 'sid' => NULL),
      'type' => 'theme',
    ];
    $before = $theme_registry;
    twiggy_theme_registry_alter($theme_registry);

    $subject = $theme_registry['resource_download_confirmation'];
    $this->assertNotSame($before, $theme_registry);
    $this->assertContains('twiggy_process', $subject['process functions']);

    $this->assertSame('twiggy', $subject['function']);
    $this->assertSame('sites/all/themes/gop5_theme', $subject['theme path']);

    $this->assertSame('resource_download_confirmation', $subject['twiggy']['base_hook']);
    $this->assertSame('gop5_theme', $subject['twiggy']['module']);
    $this->assertSame('sites/all/themes/gop5_theme/templates', $subject['twiggy']['template_dir']);
    $this->assertSame('resource-download-confirmation.html.twig', $subject['twiggy']['template_file']);
    $this->assertSame('theme', $subject['twiggy']['type']);
  }

  public function testAssertThemeRegistryAlterDoesNothingWhenTwiggyVarNotSet() {
    $theme_registry = [];
    $theme_registry['admin_alert'] = [
      'variables' => [
        'message' => [],
      ],
      'file' => 'includes/themes.inc',
    ];
    $before = $theme_registry;
    twiggy_theme_registry_alter($theme_registry);
    $this->assertSame($before, $theme_registry);
  }

  public function testConstructorSetsInternalProperties() {
    $this->assertConstructorSetsInternalProperties();
  }

}
