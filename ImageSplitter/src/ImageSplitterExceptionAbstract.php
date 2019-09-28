<?php
/**
 * Split large images into m x n small pieces
 *
 * Split large images into small equal-sized pieces to prevent
 * easy copying of images.
 *
 * @Original author   Jiang Kuan <kuan.jiang@gmail.com>
 * @version  v1.0 2007/10/01
 * @package  ImageSplitter
 *
 * @Modified by Sameer Borate http://www.codediesel.com
 * @version v1.2 2013/04/06
 *
 * @Modified by Bardo qi  <bardoqi@gmail.com>
 * @version v1.3 2019/10/01
 *
 */

namespace ImageSplitter;

use Exception;
use Throwable;

abstract class ImageSplitterExceptionAbstract extends Exception implements Throwable
{

}