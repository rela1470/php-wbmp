<?php
/**
 * Created by PhpStorm.
 * User: j.watanabe
 * Date: 2018/03/02
 * Time: 15:25
 */

// Path to the target png
$path = './pic_8x8.png';

// Get the image sizes
$image = getimagesize($path);

png2wbmp($path, './pic_8x8.wbmp', $image[1], $image[0], 7);