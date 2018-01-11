<?php
/**
 * @file Admin functions for the Twiggy module.
 */

/**
 * Form builder for the twiggy_settings form.
 *
 * Handle settings.
 *
 * @param array $form
 * @param array &$form_state
 *
 * @see     twiggy_settings_validate()
 * @see     twiggy_settings_submit()
 * @ingroup forms
 * @return mixed
 */
function twiggy_settings($form, &$form_state) {
  $defaults = _twiggy_defaults();
  $form['options'] = array(
    '#type' => 'fieldset',
    '#title' => t('Environment Options'),
    '#description' => t('For more information visit: <a href="!url">!url</a>', ['!url' => 'https://twig.symfony.com/doc/1.x/api.html']),
    '#collapsible' => FALSE,
  );
  $form['options']['twiggy_debug'] = array(
    '#type' => 'checkbox',
    '#title' => t('Debug mode'),
    '#default_value' => $defaults['twiggy_debug'],
  );
  $form['options']['twiggy_strict_variables'] = array(
    '#type' => 'checkbox',
    '#title' => t('Strict variables'),
    '#default_value' => $defaults['twiggy_strict_variables'],
  );
  $form['options']['twiggy_autoescape'] = array(
    '#type' => 'select',
    '#title' => t('Autoescape'),
    '#default_value' => $defaults['twiggy_autoescape'],
    '#options' => [
      FALSE => t('-none-'),
      'html' => 'html',
      'js' => 'js',
      'url' => 'url',
      'css' => 'css',
      'html_attr' => 'html_attr',
    ],
  );
  $form['options']['twiggy_charset'] = array(
    '#type' => 'textfield',
    '#title' => t('Character set'),
    '#default_value' => $defaults['twiggy_charset'],
  );

  return system_settings_form($form);
}
