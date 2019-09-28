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

use ImageSplitter\ImageSplitterExceptionAbstract;

class ImageSplitterException extends ImageSplitterExceptionAbstract
{
    /**
     * @return ImageSplitterException
     */
    public static function filenameIsEmmpty(){
        return new self('The Scource image file name is empty!');
    }

    /**
     * @return ImageSplitterException
     */
    public static function imageTypeIsNotSupported(){
        return new self('The image tyoe is not supported!');
    }

    /**
     * @return ImageSplitterException
     */
    public static function OutputPathIsEmpty(){
        return new self('The output path is empty!');
    }

    /**
     * @return ImageSplitterException
     */
    public static function loadImageFileFailed(){
        return new self('Load image file failed! ' );
    }

    /**
     * @return ImageSplitterException
     */
    public static function ImageCopyFailed(){
        return new self('Failed to execute function imagecopyresampled()!');
    }

    /**
     * @param $fileName
     * @return ImageSplitterException
     */
    public static function failedTocreateImageFile($fileName){
        return new self("Failed to create image file $fileName !");
    }

    /**
     * @param $fileName
     * @return ImageSplitterException
     */
    public static function srcIimageFileNotFound($fileName){
        return new self("Filed to load source image file $fileName !");
    }

}