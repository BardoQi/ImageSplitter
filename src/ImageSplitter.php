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
/**
 * Usage:
 * use ImageSplitter\ImageSplitter;
 * use ImageSplitter\ImageSplitterException;
 *
 * try{
 *   	ImageSplitter::getInstance($row_count,$col_count,$output_path,$output_type)
 *          ->splitToTile($src_filename,$file_prefix);
 * }catch(ImageSplitterException $e){
 *      // Write your logFile;
 * }
 *
 */
use ImageSplitter\ImageSplitterException;

class ImageSplitter{

    public static $instance = null;

    /**
     * @desc Output image type, available values are IMAGETYPE_PNG, IMAGETYPE_JPEG and IMAGETYPE_GIF. default value: IMAGETYPE_PNG
     * @access public
     */
     public $output_type = IMAGETYPE_PNG;

    /**
     * Source image filename with full path
     * @var string
     * @access private
     */
    private $src_filename;

    /**
     * Source image (resource)
     * @var resource
     * @access private
     */
    private $src_image;

    /**
     * Source image width
     * @var int
     * @access private
     */
    private $src_width;

    /**
     * Source image height
     * @var int
     * @access private
     */
    private $src_height;

    /**
     * Source image type
     * @var int
     * @access private
     */
    private $src_type;

    /**
     * Canvas width
     * @var int
     * @access private
     */
    private $canvas_width;

    /**
     * Canvas height
     * @var int
     * @access private
     */
    private $canvas_height;

    /**
     * The rows of new image
     * @var int
     * @access private
     */
    private $row_count = 0;

    /**
     * The cols of new image
     * @var int
     * @access private
     */
    private $col_count = 1;

    /**
     * The output path of new images
     * @var string
     * @access private
     */
    private $output_path = '';


    /**
     * ImageSplitter constructor.
     */
    protected function __construct()
    {

    }

    /**
     * @param $src_type
     * @return bool
     */
    private function isSupportedFormat($src_type)
    {
        if(in_array($src_type , [IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG]))
        {
            return true;
        }
        return false;
    }

    /**
     * Load a source image
     * @access public
     * @param string $src_filename image filename with full path
     * @return bool whether the source image is load successfully
     * @throws \ImageSplitter\ImageSplitterException
     */
    private function loadImageFile($src_filename){

        if(empty($src_filename)) {
            throw ImageSplitterException::filenameIsEmmpty();
        }

        if(!is_file($src_filename)){
            throw ImageSplitterException::srcIimageFileNotFound($src_filename);
        }

        $this->src_filename = $src_filename;
        $image_info = getimagesize($src_filename);
        if(!$image_info) return false;
        list($this->src_width, $this->src_height, $this->src_type)
            = array_values($image_info);
        if(!$this->isSupportedFormat($this->src_type)){
            throw ImageSplitterException::imageTypeIsNotSupported();
        }
        $this->canvas_width = ceil($this->src_width/$this->col_count);
        $this->canvas_height = ceil($this->src_height/$this->row_count);

        return true;
    }

    /**
     * @param $row_count
     * @param $col_count
     * @param $output_path
     * @param $output_type
     * @return static
     * @throws \ImageSplitter\ImageSplitterException
     */
    public static function getInstance($row_count,$col_count,$output_path,$output_type){
        if(null == self::$instance){
            self::$instance =  new static();
        }
        $that = self::$instance;
        if((empty($row_count))||(!is_numeric($row_count))){
            $row_count = 2;
        }
        if((empty($col_count))||(!is_numeric($col_count))){
            $col_count = 1;
        }
        $that->row_count = $row_count;
        $that->col_count = $col_count;
        if(empty($output_path)){
            throw ImageSplitterException::OutputPathIsEmpty();
        }
        $that->output_path = rtrim($output_path,'/')."/";
        $that->output_type = $output_type;
        return $that;
    }

    /**
     * @param $src_filename
     * @param $file_prefix
     * @return array $images_files
     * @throws ImageSplitterException
     */
    public function splitToTile($src_filename,$file_prefix='') {

        $this->loadImageFile($src_filename);
        $this->src_image = imagecreatefromstring(file_get_contents($this->src_filename));
        if(false === $this->src_image){
            throw ImageSplitterException::loadImageFileFailed();
        }
        $images_files = [];
        for($row=0; $row<$this->row_count;$row++){
            for($col=0; $col<$this->col_count; $col++){
                $im = imagecreatetruecolor($this->canvas_width, $this->canvas_height);

                $offset_x = $this->canvas_width * $col;
                $offset_y = $this->canvas_height * $row;
                $canvas_width = $this->canvas_width;
                if($this->canvas_width * ($col+1) > $this->src_width){
                    $canvas_width = $this->src_width - $this->canvas_width * $col;
                }
                $canvas_height =  $this->canvas_height;
                if($this->canvas_height * ($col+1) > $this->canvas_height){
                    $canvas_height = $this->src_height - $this->canvas_height * $col;
                }
                if(!imagecopyresampled($im, $this->src_image, 0, 0, $offset_x, $offset_y,
                    $canvas_width, $canvas_height, $canvas_width, $canvas_height)){
                    throw ImageSplitterException::ImageCopyFailed();
                }
                $image_path_info = pathinfo($this->src_filename);
                $image_extension = $image_path_info['extension'];
                $images_files[$row][$col] = sprintf("%s-%2d-%2d.%s",$file_prefix,$row,$col,$image_extension);
                $new_file = $this->output_path .DIRECTORY_SEPARATOR. $images_files[$row][$col];
                if(false ===  $this->outputImage($im,$new_file)){
                    throw ImageSplitterException::failedTocreateImageFile($new_file);
                }
            }
        }
        imagedestroy($this->src_image);
        return $images_files;
    }
    
    /**i
     * Get all tiles
     * @access private
     * @param resource $res Image resource to be output
     * @param string $target Output filename
     * @return resource
     */
    private function outputImage($res, $target){
        
        switch($this->output_type){
            case IMAGETYPE_GIF:
                return imagegif($res, $target);
            case IMAGETYPE_JPEG:
                return imagejpeg($res, $target);
            default:
                return imagepng($res, $target);
        }
    }
}

?>