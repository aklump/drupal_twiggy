# Twiggy

Start using Twig for your Drupal 7 websites now.

## Install with Composer

This module requires that you are using composer.

If you are using a sitewide _composer.json_ file than need to do two things; we're assuming that the _composer.json_ file is one level above web root in this example.

1. Run this at the root level: `composer require twig/twig ^1.35`
2. Add this line to _settings.php_: `$conf['twiggy_vender_autoload'] = DRUPAL_ROOT . '/../vendor/autoload.php';`
    
Otherwise you need to do the following in your module directory:

    composer install

## Module Providing a New, Twig-Rendered Theme Item

1. In this example I'm writing a module called _itls_, which defines a new theme called _pull_quote_.
2. I want to use Twig for the _pull_quote_.
3. Notice I wrap the theme item definition with `twiggy_twig()` function.
4. Now create a Twig file in your module at _itls/templates/pull_quote.html.twig_.
5. Create the function `template_preprocess_pull_quote()` if needed.
6. That's it.
    
        /**
         * Implements hook_theme().
         */
        function itls_theme($existing, $type, $theme, $path) {
          $themes['pull_quote'] = twiggy_twig(array(
            'variables' => array(
              'quote' => '',
              'byline' => NULL,
            ),
          ));
        
          return $themes;
        }

## Theme Overriding a Twiggy Theme Item

1. In this example I want to override _pull_quote_ in my theme called _flower_.
2. Copy the file from _itls/templates/pull_quote.html.twig_ to _flower/templates/pull_quote.html.twig_ and modify as needed.

## Twig and Drupal Best Practices

<https://www.drupal.org/docs/8/theming/twig/twig-best-practices-preprocess-functions-and-templates>

* theme developers should call filters such as t and utility functions such as url() from within Twig templates. 

## Drupal-Added Twig Filters & Functions

### Functions

* url, e.g. `<a href="{{ url('node/1') }}">`

### Filters
* trans (this is in lieu of t, which is deprecated), e.g. `{{ 'Homepage'|trans }}`


## Troubleshooting

### Twiggy error: Unable to find template "... 

- Try clearing the theme cache.  A template file may have been deleted and you'll need to rediscover the twig files. 
