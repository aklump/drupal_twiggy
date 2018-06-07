# Twiggy

Start using Twig for your Drupal 7 websites now.  This module implements **version 1.x of Twig** to be compatible with PHP 5.x. 

## Install with Composer

This module requires you to install its dependencies using Composer.

If you are using a sitewide _composer.json_ file than need to do two things; we're assuming that the _composer.json_ file is one level above web root in this example.

1. Copy the line from the module's _composer.json_ file that requires twig, e.g. `composer require twig/twig ~2` to your sitewide _composer.json_ file.
2. Now run `composer install --no-dev` for your entire site.
3. Add this line to _settings.php_: `$conf['twiggy_vender_autoload'] = DRUPAL_ROOT . '/../vendor/autoload.php';`
    
Otherwise you need to do the following from within Twiggy module directory:

1. `composer install --no-dev`
2. Depending on how you're managing dependencies you may or may not need to remove _twiggy/.gitignore_.

For either method above, you should now:

1. Enable the module.

## Configure the Module

1. The first thing to do is enable _Debug mode_ so you can see errors that occur in your templates.  Do so at _admin/config/content/twiggy_.  You will want to disable this in production.


## To Provide a New Twig Template to Your Custom Theme


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

## Convert a PhpTemplate theme to Twig

_If You Want to Use Twig instead of PhpTemplate for An Existing Theme Hook, e.g. _theme_field_._

1. Call `twiggy_use_twig` for each theme you want to convert to Twig in your module or theme's `hook_theme_registry_alter` as shown.
        
        /**
         * Implements hook_theme_registry_alter().
         */
        function flower_theme_theme_registry_alter(&$themes) {
          twiggy_use_twig('field, $themes);
          twiggy_use_twig('views_view_unformatted, $themes);
        }

## If You Want Your Theme to Override a module-defined Twig template.

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


