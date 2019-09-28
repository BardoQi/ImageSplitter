# Simple Image Splitter

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Split large images into m x n equal-sized small pieces.

## Introduction
    
Split large images into m x n equal-sized small pieces.

## Install

Via Composer

``` bash
$ composer require bardoqi/image-splitte
```

## Usage

``` php
    use ImageSplitter\ImageSplitter;
    use ImageSplitter\ImageSplitterException;
   
    try{
      	ImageSplitter::getInstance($row_count,$col_count,$output_path,$output_type)
             ->splitToTile($src_filename,$file_prefix);
    }catch(ImageSplitterException $e){
         // Write your logFile;   
    }     
```
## Features

This library supports the following image_type:

* Png

* Gif

* Jpeg, Jpg
    
This library supports the parameters of config
  
* $row_count: The count of rows of the new image files.  
  
* $col_count: The count of columns of the new image files.  
  
* $output_path:  The output path of the new image files.  
  
* $output_type:  The output type of the new image files, available values are IMAGETYPE_PNG, IMAGETYPE_JPEG and IMAGETYPE_GIF. default value: IMAGETYPE_PNG

 

## Change log
    
Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.
    
## Testing

``` bash
$ composer test
```
 

## Contributing
    
Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.
    
## Security
    
If you discover any security related issues, please create an issue in the issue tracker.
    
## Credits

- [Bardo Qi][link-author]
- [All Contributors][link-contributors]

## License
   
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
    
[ico-version]: https://img.shields.io/packagist/v/bardoqi/imagesplitter.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/bardoqi/imagesplitter/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/bardoqi/imagesplitter.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/bardoqi/imagesplitter.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/bardoqi/imagesplitter.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/bardoqi/imagesplitter
[link-travis]: https://travis-ci.org/bardoqi/imagesplitter
[link-scrutinizer]: https://scrutinizer-ci.com/g/bardoqi/imagesplitter/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/bardoqi/imagesplitter
[link-downloads]: https://packagist.org/packages/bardoqi/imagesplitter
[link-author]: https://github.com/bardoqi
[link-contributors]: ../../contributors


