<?php
/**
 * Created by PhpStorm.
 * User: j.watanabe
 * Date: 2018/03/02
 * Time: 15:25
 */

$image = imagecreatefromjpeg('./pic_1024x768.jpg');

image2wbmp($image, './pic_1024x768.wbmp', 128);

imagedestroy($image);