<?php
/* SVN FILE: $Id$ */
/**
 * Sass exception.
 * @author      Chris Yates <chris.l.yates@gmail.com>
 * @copyright   Copyright (c) 2010 PBM Web Development
 * @license      http://phamlp.googlecode.com/files/license.txt
 * @package      PHamlP
 * @subpackage  Sass
 */

/**
 * Sass exception class.
 * @package      PHamlP
 * @subpackage  Sass
 */
class SassException extends Exception
{
  /**
   * Sass Exception.
   * @param string $message Exception message
   * @param object $object object with source code and meta data
   */
  public function __construct($message, $object = NULL)
  {
    parent::__construct($message . (is_object($object) ? ": {$object->filename}::{$object->line}\nSource: {$object->source}" : ''));
  }
}
