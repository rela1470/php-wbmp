<?php
/**
 * Created by PhpStorm.
 * User: j.watanabe
 * Date: 2018/03/02
 * Time: 15:30
 */

$data = file_get_contents('./pic_8x8.wbmp');

$string = bin2hex($data);

$array = str_split($string, 2);

//------------------------------
//WBMP type
$type = array_shift($array);
if ( $type != 0) exit('WBMP type error');

//------------------------------
//Fixed header
$type = array_shift($array);
if ( $type != 0) exit('Fixed header error');

//------------------------------
//size
$width = array_shift($array);
$height = array_shift($array);

echo "width:{$width} height:{$height}\n";

$output = [];
foreach ((array)$array as $bits) {
    $output[] = sprintf("%08s", decbin(hexdec($bits))). "\n";

}

foreach ($output as $line) {
    for ($i = 0; $i < $height; $i ++) {
        echo ($line[$i]) ? '□' : '■';
    }
    echo "\n";
}