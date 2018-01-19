# Twiggy

Start using Twig for your Drupal 7 websites now.

## Install with Composer

This module requires that you are using composer.

If you are using a sitewide _composer.json_ file than need to do two things; we're assuming that the _composer.json_ file is one level above web root in this example.

1. Run this at the root level: `composer require twig/twig ^1.35`
2. Add this line to _settings.php_: `$conf['twiggy_vender_autoload'] = DRUPAL_ROOT . '/../vendor/autoload.php';`
    
Otherwise you need to do the following in your module directory:

    composer install

## If You are Writing a Module and You Want to Provide a New Theme Hook Using Twig

1. In this example I'm writing a module called _itls_, which defines a new theme called _pull_quote_.
2. I want to use Twig for the _pull_quote_.
3. Notice how each theme hook has the added key `twiggy` with `__FUNCTION__` as the value.
4. Now create a Twig file in your module at _itls/templates/pull-quote.html.twig_. **Notice the hyphen in the filename (_...pull-quote..._, not _...pull_quote..._) instead of underscore.**
5. Create the function `template_preprocess_pull_quote()` if needed.
6. That's it.
    
        /**
         * Implements hook_theme().
         */
        function itls_theme($existing, $type, $theme, $path) {
        
          $themes = [];
        
          $themes['pull_quote'] = array(
              'variables' => array(
                'quote' => '',
                'byline' => NULL,
              ),
              'twiggy' => __FUNCTION__,
            );
        
          return $themes;
        }

## If You Want to Use Twig instead of PhpTemplate for An Existing Theme Hook, e.g. _theme_field_.

1. Use _hook_theme_alter_ and add the _twiggy_ key as shown for each theme hook you want to use with Twig.

    /**
     * Implements hook_theme_alter().
     */
    function itls_theme_registry_alter(&$themes) {
      $themes['field']['twiggy'] = __FUNCTION__;
      $themes['views_view_unformatted']['twiggy'] = __FUNCTION__;
    }

## If You Want Your Theme to Override a Theme Hook Using Twig

1. In this example I want to override _pull_quote_ in my theme called _flower_.
2. Copy the file from _itls/templates/pull_quote.html.twig_ to _flower/templates/pull_quote.html.twig_ and modify as needed.

## Passing HTML to Templates

* Twig templates will autoescape variables as they are output unless they are objects implementing the _MarkupInterface_.
* Passing a string to `Markup::create()` returns such an object.  But this assumes it's safe for output...
* ... so, make it safe using your preferred method, e.g. `filter_xss` or `check_markup`.
* Here is an example:

        use Drupal\twiggy\Markup;
        ... 
        
        function template_preprocess_pull_quote(&$vars) {
          $vars['quote'] = Markup::create(filter_xss($vars['quote']));
        }
        
* If using `check_markup` you may want to create a format (e.g. _twig_safe_ that prepares the string for safe output and includes as the final filter _Markup object_, in which case you could do this:

        function template_preprocess_pull_quote(&$vars) {
          $vars['quote'] = check_markup($vars['quote'], 'twig_safe');
        }

## Text Formats

* When creating a text format, you may want to add the _Markup object_ as the last filter in the chain, if the output of the format is to be rendered directly in a Twig template, and is certainly safe, and contains HTML.  This will ensure that Twig does not escape what your format has already determined to be safe.
* In effect you are moving the onus for safe output from Twig to your custom text format..
    
## Twig and Drupal Best Practices

<https://www.drupal.org/docs/8/theming/twig/twig-best-practices-preprocess-functions-and-templates>

* theme developers should call filters such as t and utility functions such as url() from within Twig templates. 

## Drupal-Added Twig Filters & Functions

### Functions

* url, e.g. `<a href="{{ url('node/1') }}">`
* render, e.g. `{{ render(page) }}`

### Filters

* trans (this is in lieu of t, which is deprecated), e.g. `{{ 'Homepage'|trans }}`

## D8Now Module

By enabling the [D8Now module](https://github.com/aklump/drupal_d8now) you will also get:

* Automatic `$attribute` instance on each Twiggy hook.

## Attributes

<https://www.drupal.org/docs/8/theming-drupal-8/using-attributes-in-templates>

## Troubleshooting

### Twiggy error: Unable to find template "... 

- Try clearing the theme cache.  A template file may have been deleted and Twiggy needs to rediscover the twig files. 


