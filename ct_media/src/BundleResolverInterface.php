<?php

namespace Drupal\ct_media;

/**
 * Interface for media bundle resolvers.
 *
 * Media bundle resolvers are plugins which determine which media bundle(s) are
 * appropriate for handling an input value. The input value can be of any type,
 * and the resolver needs to figure out which media bundle -- singular! -- is
 * best suited to handle that input.
 */
interface BundleResolverInterface {

  /**
   * Attempts to determine the media bundle applicable for an input value.
   *
   * @param mixed $input
   *   The input value.
   *
   * @return \Drupal\media\MediaTypeInterface|false
   *   The applicable media bundle, or false if there isn't one.
   */
  public function getBundle($input);

}
