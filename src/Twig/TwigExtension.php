<?php

namespace Drupal\starter\Twig;

use Twig\Environment;
use Drupal\entity_reference_revisions\Plugin\Field\FieldFormatter\EntityReferenceRevisionsEntityFormatter;
use Drupal\block\Entity\Block;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

/**
 * Provides usual filters and functions for Twig.
 */
class TwigExtension extends AbstractExtension {

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return 'starter';
  }

  /**
   * {@inheritdoc}
   */
  public function getFilters() {
    return [
      'slugify' => new TwigFilter('slugify', 'slugify'),
      'debugstrip' => new TwigFilter('debugstrip', 'debugstrip'),
      'unescape' => new TwigFilter('unescape', 'unescape'),
      'ceil' => new TwigFilter('ceil', 'ceil'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFunctions() {
    return [
      new TwigFunction('base_root', $this->base_root(...), [
        'is_safe' => ['html'],
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('display_menu', $this->place_menu(...), [
        'is_safe' => ['html'],
        'needs_environment' => TRUE,
        'needs_context' => TRUE,
      ]),
      new TwigFunction('place_menu', $this->place_menu(...), [
        'is_safe' => ['html'],
        'needs_environment' => TRUE,
        'needs_context' => TRUE,
      ]),
      new TwigFunction('place_block', $this->place_block(...), [
        'is_safe' => ['html'],
        'needs_environment' => TRUE,
        'needs_context' => TRUE,
      ]),
      new TwigFunction('place_form', $this->place_form(...), [
        'is_safe' => ['html'],
        'needs_environment' => TRUE,
        'needs_context' => TRUE,
      ]),
      new TwigFunction('place_webform', $this->place_webform(...), [
        'is_safe' => ['html'],
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('place_node', $this->place_node(...), [
        'is_safe' => ['html'],
        'needs_environment' => TRUE,
        'needs_context' => TRUE,
      ]),
      new TwigFunction('place_term', $this->place_term(...), [
        'is_safe' => ['html'],
        'needs_environment' => TRUE,
        'needs_context' => TRUE,
      ]),
      new TwigFunction('place_view', $this->place_view(...), [
        'is_safe' => ['html'],
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('place_paragraphs', $this->place_paragraphs(...), [
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('place_entity', $this->place_entity(...), [
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('place_responsive_image', $this->place_responsive_image(...), [
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('get_theme_url', $this->get_theme_url(...), [
        'needs_environment' => TRUE,
        'needs_context' => TRUE,
      ]),
      new TwigFunction('get_taxonomy_terms', $this->get_taxonomy_terms(...), [
        'needs_environment' => TRUE,
        'needs_context' => TRUE,
      ]),
      new TwigFunction('get_active_theme', $this->get_active_theme(...), [
        'needs_environment' => TRUE,
        'needs_context' => TRUE,
      ]),
      new TwigFunction('get_image_path', $this->get_image_path(...), [
        'needs_environment' => TRUE,
        'needs_context' => TRUE,
      ]),
      new TwigFunction('get_path_segment', $this->get_path_segment(...), [
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('get_current_path', $this->get_current_path(...), [
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('get_theme_setting', $this->get_theme_setting(...), [
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('get_variable', $this->get_variable(...), [
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('get_config', $this->get_config(...), [
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('get_rendered_string', $this->get_rendered_string(...), [
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('dd', $this->dd(...), [
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('get_first_instance', $this->get_first_instance(...), [
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('safe_merge', $this->safe_merge(...), [
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('get_node', $this->get_node(...), [
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('set_meta', $this->set_meta(...), [
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('get_root', $this->get_root(...), [
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('get_node_path', $this->get_node_path(...), [
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      new TwigFunction('get_current_lang', $this->get_current_lang(...), [
        'needs_environment' => FALSE,
        'needs_context' => FALSE,
      ]),
      // twig wrapper for getenv function
      new TwigFunction('get_env', 'getenv'),
    ];
  }

  /**
   * Return a path alias from a node ID.
   */
  public function get_node_path($nid) {
    return \Drupal::service('path_alias.manager')->getAliasByPath('/node/' . $nid);
  }

  /**
   * Alias of get_root().
   */
  public function base_root() {
    return $this->get_root();
  }

  /**
   * Return the $base_root.
   */
  public function get_root() {
    global $base_root;

    return $base_root;
  }

  /**
   * Provides display_menu function for page layouts.
   *
   * @param Twig_Environment $env
   *   The twig environment instance.
   * @param array $context
   *   An array of parameters passed to the template.
   */
  public function place_menu(Environment $env, array $context, $menu_name, $min_depth = NULL, $max_depth = NULL, $theme = NULL) {
    $menu_tree = \Drupal::menuTree();

    // Build the typical default set of menu tree parameters.
    $parameters = $menu_tree->getCurrentRouteMenuTreeParameters($menu_name);

    // Min depth passed?
    if (!is_null($min_depth)) {
      $parameters->setMinDepth($min_depth);
    }

    // Max depth passed?
    if (!is_null($max_depth)) {
      $parameters->setMaxDepth($max_depth);
    }

    // Load the tree based on this set of parameters.
    $tree = $menu_tree->load($menu_name, $parameters);

    // Transform the tree using the manipulators you want.
    $manipulators = [
      // Only show links that are accessible for the current user.
      ['callable' => 'menu.default_tree_manipulators:checkAccess'],
      // Use the default sorting of menu links.
      ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort'],
    ];

    $tree = $menu_tree->transform($tree, $manipulators);

    // Finally, build a renderable array from the transformed tree.
    $menu = $menu_tree->build($tree);

    // Custom theme passed?
    if (!is_null($theme) && isset($menu['#theme'])) {
      $menu['#theme'] = $menu['#theme'] . '_' . $theme;
    }

    $render_service = \Drupal::service('renderer');

    return [
      '#markup' => $render_service->renderPlain($menu),
    ];
  }

  /**
   * Places a content block.
   *
   * @param Twig_Environment $env
   *   The twig environment instance.
   * @param array $context
   *   An array of parameters passed to the template.
   */
  public function place_block(Environment $env, array $context, $block_name) {
    $render = FALSE;

    // Get as entity block.
    $block = Block::load($block_name);
    if (!empty($block)) {
      $render = \Drupal::entityTypeManager()->getViewBuilder('block')->view($block);
    } else {
      // Try to load as plugin block.
      $plugin_block = \Drupal::service('plugin.manager.block')->createInstance($block_name, $config = []);
      if (!empty($plugin_block) && $plugin_block->getPluginId() != 'broken') {
        $render = $plugin_block->build();
      }
    }

    return $render;
  }

  /**
   * Places a form.
   *
   * @param Twig_Environment $env
   *   The twig environment instance.
   * @param array $context
   *   An array of parameters passed to the template.
   */
  public function place_form(Environment $env, array $context, $form_name) {
    return \Drupal::formBuilder()->getForm($form_name);
  }

  /**
   * Place a node.
   */
  public function place_node(Environment $env, array $context, $node_id, $node_view = 'full') {
    $node = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->load($node_id);

    if (empty($node)) {
      return '';
    }
    else {
      return \Drupal::entityTypeManager()
        ->getViewBuilder('node')
        ->view($node, $node_view);
    }
  }

  /**
   * Place a taxonomy term.
   */
  public function place_term(Environment $env, array $context, $term, $term_view = 'full') {
    if (empty($term)) {
      return '';
    }
    else {
      return \Drupal::entityTypeManager()->getViewBuilder($term->getEntityTypeId())->view($term, $term_view);
    }
  }

  /**
   * Place a Webform submission form.
   */
  public function place_webform($webform_name) {
    if (\Drupal::moduleHandler()->moduleExists('webform')) {
      $webform = \Drupal::entityTypeManager()->getStorage('webform')->load($webform_name);
      $webform = $webform->getSubmissionForm();
    }
    else {
      $webform = NULL;
    }

    return $webform;
  }

  /**
   * Place a view in a Twig template with an optional display mode.
   * Optionally allows parameters to be passed
   * Returns rendered view if exists, if not, null.
   */
  public function place_view($name, $display_id = 'default', $args = []) {
    $params = array_merge([$name, $display_id], $args);
    $view = call_user_func_array('views_embed_view', $params);

    if (!is_null($view)) {
      $drupal = \Drupal::service('renderer');
      return $drupal->render($view);
    }

    return NULL;
  }

  /**
   * Gets the current theme URL.
   */
  public function get_theme_url() {
    return '/' . \Drupal::theme()->getActiveTheme()->getPath();
  }

  /**
   * Slugifies a string.
   * Inspiration from https://gist.github.com/boboldehampsink/7354431.
   */
  public function slugify($slug) {
    // Check if path auto is installed.
    if (\Drupal::moduleHandler()->moduleExists('pathauto')) {
      $slug = \Drupal::service('pathauto.alias_cleaner')->cleanString($slug);
    }
    else {
      // Remove HTML tags.
      $slug = preg_replace('/<(.*?)>/u', '', $slug);

      // Remove inner-word punctuation.
      $slug = preg_replace('/[\'"‘’“”]/u', '', $slug);

      // Make it lowercase.
      $slug = mb_strtolower($slug, 'UTF-8');

      // Get the "words".  Split on anything that is not a unicode letter or number.
      // Periods are OK too.
      preg_match_all('/[\p{L}\p{N}\._-]+/u', $slug, $words);
      $slug = implode('-', array_filter($words[0]));
    }

    return $slug;
  }

  /**
   * Strips HTML tags from a string if Twig is in development mode.
   * Trims string regardless of mode.
   *
   * Returns a string.
   */
  public function debugstrip($string) {
    if (\Drupal::service('twig')->isDebug()) {
      $string = trim(strip_tags($string));
    }
    else {
      $string = trim($string);
    }

    return $string;
  }

  /**
   * Returns an array of taxonomy term names and IDs from a taxonomy vocabulary name.
   */
  public function get_taxonomy_terms(Environment $env, array $context, $taxonomy_name, array $other_fields = NULL) {
    $query = \Drupal::entityQuery('taxonomy_term')
      ->condition('vid', $taxonomy_name)
      ->accessCheck(TRUE);
    $tids = $query->execute();

    $entity_manager = \Drupal::entityTypeManager();
    $term_storage = $entity_manager->getStorage('taxonomy_term');
    $taxonomy_terms = $term_storage->loadMultiple($tids);

    $taxonomy_array = [];

    foreach ($taxonomy_terms as $term) {
      $tid = $term->hasTranslation($this->get_current_lang()) ? $term->getTranslation($this->get_current_lang())->get('tid')[0]->value : $term->getTranslation('en')->get('tid')[0]->value;

      $values = [
        'tid' => $tid,
        'name' => $term->hasTranslation($this->get_current_lang()) ? $term->getTranslation($this->get_current_lang())->get('name')[0]->value : $term->getTranslation('en')->get('name')[0]->value,
        'parent' => $term->hasTranslation($this->get_current_lang()) ? $term->getTranslation($this->get_current_lang())->get('parent')->target_id : $term->getTranslation('en')->get('parent')->target_id,
        'children' => isset($taxonomy_array[$tid]) ? $taxonomy_array[$tid]['children'] : [],
      ];

      if ($values['parent'] === "0") {
        $taxonomy_array[$tid] = $values;
      }
      else {
        $taxonomy_array[$values['parent']]['children'][$tid] = $values;
      }

      // Add extra fields if supplied.
      if (!is_null($other_fields)) {
        foreach ($other_fields as $field) {
          if ($values['parent'] === "0") {
            $taxonomy_array[$tid][$field] = $term->get($field)[0]->value;
          }
          else {
            $taxonomy_array[$values['parent']]['children'][$tid][$field] = $term->get($field)[0]->value;
          }
        }
      }
    }

    return $taxonomy_array;
  }

  /**
   * Returns active theme name.
   */
  public function get_active_theme(Environment $env, array $context) {
    return \Drupal::theme()->getActiveTheme()->getName();
  }

  /**
   * Returns image path, optionally for a specific image size.
   */
  public function get_image_path(Environment $env, array $context, $image, $style = FALSE) {

    // Check if $image is present.
    if (is_null($image)) {
      return FALSE;
    }

    // Have we been passed the file id?
    if (is_numeric($image) && (int) $image > 0) {
      $file = File::load($image);
    }
    // Have we only got an array with image target_id?
    elseif (is_array($image) && !empty($image['target_id'])) {
      $file = File::load($image['target_id']);
    }
    // we've got an object.
    else {
      // Object structure different, depending on if node.field_name, content.field_name or row._entity.field_name is passed.
      if (is_array($image) && isset($image['#items'])) {
        $image = $image['#items'];
      }
      elseif (is_array($image) && isset($image['#item'])) {
        $image = $image['#item'];
      }

      // Check $image->entity is set.
      if (!isset($image->entity)) {
        return FALSE;
      }
      else {
        $file = $image->entity;
      }
    }

    // we've got a valid image file.
    if (!empty($file)) {
      // Return original image file.
      if (!$style) {
        return $file->uri->url;
      }
      // Return specific image size.
      else {
        $image_style = ImageStyle::load($style);

        // If the image style doesn't exist, return the normal image.
        if (is_null($image_style)) {
          return $file->url();
        }

        return $image_style->buildUrl($file->getFileUri());
      }
    }
    else {
      return FALSE;
    }
  }

  /**
   * Get path segment from current request.
   *
   * @param int $segment
   *   - starting from 1 being the first section of the url after the first forward slash.
   * @param bool $underscores
   *   - convert dashes to underscores.
   *
   * @return string of path segment or null
   */
  public function get_path_segment($segment, $underscores = FALSE) {
    // Reduce segment index by 1 to account for array key starting with 0.
    $segment--;
    $path = \Drupal::request()->getPathInfo();
    $segments = explode('/', trim($path, '/'));

    if (isset($segments[$segment])) {
      if ($underscores) {
        return str_replace('-', '_', $segments[$segment]);
      }

      return $segments[$segment];
    }
    else {
      return NULL;
    }
  }

  /**
   * Returns the current path.
   */
  public function get_current_path() {
    $current_path = \Drupal::service('path.current')->getPath();
    $result = \Drupal::service('path_alias.manager')->getAliasByPath($current_path);

    return $result;
  }

  /**
   * Returns a theme setting.
   */
  public function get_theme_setting($theme_setting) {
    return theme_get_setting($theme_setting);
  }

  /**
   * Return a $_GET variable.
   */
  public function get_variable($variable) {
    return \Drupal::request()->get($variable);
  }

  /**
   * Return a config.
   */
  public function get_config($config) {
    return \Drupal::config($config);
  }

  /**
   * Return a rendered 'Paragraphs' field.
   */
  public function place_paragraphs($field_name, $node = NULL) {

    // Check if the 'Paragraphs' module exists.
    if (!\Drupal::moduleHandler()->moduleExists('paragraphs')) {
      return FALSE;
    }

    // If $node isn't passed, let's try and get it ourselves.
    if ($node === NULL) {
      $node = \Drupal::routeMatch()->getParameter('node');
    }

    if ($node) {
      if ($node->hasField($field_name)) {
        $field_definitions = $node->getFieldDefinitions();
        $field_config = $field_definitions[$field_name];

        $config = [
          'field_definition' => $field_config,
          'settings' => $field_config->getSettings(),
          'label' => $field_config->label(),
          'view_mode' => 'full',
          'third_party_settings' => [],
        ];

        $formatter = EntityReferenceRevisionsEntityFormatter::create(\Drupal::getContainer(), $config, NULL, NULL);

        // Required by EntityReferenceFormatterBase
        // getEntitiesToView(EntityReferenceFieldItemListInterface $items, $langcode)
        $parts = $node->get($field_name);
        foreach ($parts as $delta => $item) {
          $item->_loaded = TRUE;
        }

        $language_manager = \Drupal::service('language_manager');
        $languageId = $language_manager->getCurrentLanguage()->getId();
        $elements = $formatter->viewElements($parts, $languageId);

        return $elements;
      }
    }
  }

  /**
   * Render an entity.
   */
  public function place_entity($entity, $view_mode = 'full') {
    // View is the render array.
    $view = \Drupal::entityTypeManager()->getViewBuilder($entity->getEntityTypeId())->view($entity, $view_mode);

    // Render is the html output.
    return \Drupal::service('renderer')->render($view);
  }

  /**
   * More efficient than kint(), and will exit script.
   */
  public function dd($data, $exit = TRUE) {
    dump($data);

    if ($exit) {
      return exit;
    }

    return FALSE;
  }

  /**
   * Returns the first instance of a field's value from an array of fields.
   */
  public function get_first_instance($fields, $rows) {

    if (empty($rows)) {
      return NULL;
    }

    foreach ($rows[0]['#rows'] as $row) {
      $entity = $row['#row']->_entity;

      foreach ($fields as $field) {
        if ($entity->hasField($field)) {
          $value = $entity->get($field)->getValue();

          if (!empty($value)) {
            return $value;
          }
        }
      }
    }
    return NULL;
  }

  /**
   * Html entity decode the passed string.
   */
  public function unescape($html) {
    return html_entity_decode($html);
  }

  /**
   * Rounds a number up to the nearest whole number.
   *
   * Returns a integer.
   */
  public function ceil($string) {
    return ceil($string);
  }

  /**
   * Merges arrays or objects - source object / array is appended to destination object / array.
   */
  public function safe_merge($destination, $source) {

    if (!is_object($source)) {
      $source = (object) $source;
    }
    $object_properties = get_object_vars($source);
    if (is_object($destination)) {
      foreach ($object_properties as $property => $value) {
        $destination->{$property} = $value;
      }
    }
    else {
      foreach ($object_properties as $property => $value) {
        $destination[$property] = $value;
      }
    }
    return $destination;
  }

  /**
   * Return the node via the current path.
   */
  public function get_node() {
    return \Drupal::routeMatch()->getParameter('node');
  }

  /**
   * Set meta tags.
   */
  public function set_meta($attributes, $id = NULL) {

    if (is_null($id)) {
      $id = uniqid();
    }

    $meta = [
      '#tag' => 'meta',
      '#attributes' => $attributes,
    ];

    $html_head[]['#attached']['html_head'][] = [$meta, $id];

    $drupal = \Drupal::service('renderer');
    $drupal->render($html_head);

    return TRUE;
  }

  /**
   * Place a responsive image.
   * Credits: https://gist.github.com/szeidler/3526f21a89f93a318e5d
   */
  public function place_responsive_image($image, $image_style) {
    $file = $image->entity;

    if ($file) {
      $variables = [
        'responsive_image_style_id' => $image_style,
        'uri' => $file->getFileUri(),
      ];

      // The image.factory service will check if our image is valid.
      $image = \Drupal::service('image.factory')->get($file->getFileUri());
      if ($image->isValid()) {
        $variables['width'] = $image->getWidth();
        $variables['height'] = $image->getHeight();
      }
      else {
        $variables['width'] = $variables['height'] = NULL;
      }
      $logo_build = [
        '#theme' => 'responsive_image',
        '#width' => $variables['width'],
        '#height' => $variables['height'],
        '#responsive_image_style_id' => $variables['responsive_image_style_id'],
        '#uri' => $variables['uri'],
      ];
      // Add the file entity to the cache dependencies.
      // This will clear our cache when this entity updates.
      $renderer = \Drupal::service('renderer');
      $renderer->addCacheableDependency($logo_build, $file);
      // Return the render array as block content.
      return $logo_build;
    }

    return NULL;
  }

  /**
   * Returns the current language ID.
   */
  public function get_current_lang() {
    return \Drupal::languageManager()->getCurrentLanguage()->getId();
  }

  /**
   * Returns a string (mark up) of the passed render array
   */
  function get_rendered_string($render_array) {
    $renderer = \Drupal::service('renderer');
    return (string) $renderer->renderRoot($render_array);
  }
}
