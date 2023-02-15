<?php

namespace Drupal\ct_media;

use Drupal\media\MediaInterface;

/**
 * The definition of a media entity's source field's storage.
 */
trait SourceFieldTrait {

  /**
   * The field_config entity storage handler.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $fieldStorage;

  /**
   * Returns the source field definition for a media entity.
   *
   * @param \Drupal\media\MediaInterface $entity
   *   The media entity.
   *
   * @return \Drupal\Core\Field\FieldConfigInterface
   *   The source field config entity.
   */
  protected function getSourceField(MediaInterface $entity) {
    $type_config = $entity->getSource()->getConfiguration();
    $id = $entity->getEntityTypeId() . '.' . $entity->bundle() . '.' . $type_config['source_field'];

    return $this->fieldStorage->load($id);
  }

}
