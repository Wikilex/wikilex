<?php

namespace Drupal\outline;

use Drupal\Core\Entity\BundleEntityFormBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\language\Entity\ContentLanguageSettings;
use Drupal\outline\entity\Entry;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Base form for outline edit forms.
 */
class OutlineForm extends BundleEntityFormBase {

  /**
   * The outline storage.
   *
   * @var \Drupal\outline\OutlineStorageInterface.
   */
  protected $outlineStorage;

  /**
   * Constructs a new outline form.
   *
   * @param \Drupal\outline\OutlineStorageInterface $outline_storage
   *   The outline storage.
   */
  public function __construct(OutlineStorageInterface $outline_storage) {
    $this->outlineStorage = $outline_storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.manager')->getStorage('outline')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $outline = $this->entity;
    if ($outline->isNew()) {
      $form['#title'] = $this->t('Add outline');
    }
    else {
      $form['#title'] = $this->t('Edit outline');
    }

    if ($outline->isNew()) {
      $form['name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Name'),
        '#default_value' => $outline->label(),
        '#maxlength' => 255,
        '#required' => TRUE,
      ];
    }
    $form['oid'] = [
      '#type' => 'machine_name',
      '#default_value' => $outline->id(),
      '#maxlength' => EntityTypeInterface::BUNDLE_MAX_LENGTH,
      '#machine_name' => [
        'exists' => [$this, 'exists'],
        'source' => ['name'],
      ],
    ];
    $form['description'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Description'),
      '#default_value' => $outline->getDescription(),
    ];
    $form['render'] = [
      '#type' => 'select',
      '#options' => [
        Entry::RENDER_AS_DISPLAY => t('Display
      '),
        Entry::RENDER_AS_FORM => t('Form'),
      ],
      '#title' => $this->t('Render As'),
      '#default_value' => $outline->getRender(),
    ];
    $form['hide_name'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Hide name field'),
      '#default_value' => $outline->getHideName(),
    ];
    $form['hide_site'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Hide site entry'),
      '#default_value' => $outline->getHideSiteEntry(),
    ];
    // $form['langcode'] is not wrapped in an
    // if ($this->moduleHandler->moduleExists('language')) check because the
    // language_select form element works also without the language module being
    // installed. https://www.drupal.org/node/1749954 documents the new element.
    $form['langcode'] = [
      '#type' => 'language_select',
      '#title' => $this->t('Outline language'),
      '#languages' => LanguageInterface::STATE_ALL,
      '#default_value' => $outline->language()->getId(),
    ];
    if ($this->moduleHandler->moduleExists('language')) {
      $form['default_entries_language'] = [
        '#type' => 'details',
        '#title' => $this->t('Entries language'),
        '#open' => TRUE,
      ];
      $form['default_entries_language']['default_language'] = [
        '#type' => 'language_configuration',
        '#entity_information' => [
          'entity_type' => 'outline_entry',
          'bundle' => $outline->id(),
        ],
        '#default_value' => ContentLanguageSettings::loadByEntityTypeBundle('outline_entry', $outline->id()),
      ];
    }

    $form = parent::form($form, $form_state);
    return $this->protectBundleIdElement($form);
  }

  /**
   * {@inheritdoc}
   */
  public
  function save(array $form, FormStateInterface $form_state) {

    $outline = $this->entity;

    // Prevent leading and trailing spaces in outline names.
    $outline->set('name', trim($outline->label()));

    $status = $outline->save();
    $edit_link = $this->entity->link($this->t('Edit'));
    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created new outline %name.', ['%name' => $outline->label()]));
        $this->logger('outline')
          ->notice('Created new outline %name.', [
            '%name' => $outline->label(),
            'link' => $edit_link,
          ]);
        $form_state->setRedirectUrl($outline->toUrl('canonical'));
        break;

      case SAVED_UPDATED:
        drupal_set_message($this->t('Updated outline %name.', ['%name' => $outline->label()]));
        $this->logger('outline')
          ->notice('Updated outline %name.', [
            '%name' => $outline->label(),
            'link' => $edit_link,
          ]);
        $form_state->setRedirectUrl($outline->toUrl('canonical'));
        break;
    }

    $form_state->setValue('oid', $outline->id());
    $form_state->set('oid', $outline->id());
  }

  /**
   * Determines if the outline already exists.
   *
   * @param string $oid
   *   The outline ID.
   *
   * @return bool
   *   TRUE if the outline exists, FALSE otherwise.
   */
  public
  function exists($oid) {
    $action = $this->outlineStorage->load($oid);
    return !empty($action);
  }

}
