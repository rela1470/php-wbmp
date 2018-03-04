<?php
/**
 * Created by PhpStorm.
 * User: j.watanabe
 * Date: 2018/03/02
 * Time: 15:30
 */

$br = (php_sapi_name() == 'cli') ? "\n" : "<br>";
$fileName = './pic_127x127.wbmp';
$fileName = './pic_8x8.wbmp';

$handle = fopen($fileName, 'r');

if (! $handle) {
    echo $fileName . 'をオープンできませんでした';
}


//------------------------------
//WBMP type
$type = bindec(bin2bit(fgetc($handle)));
if ( $type != 0) exit('WBMP type error');
//------------------------------

//------------------------------
//Fixed header
$header = bindec(bin2bit(fgetc($handle)));
if ( $header != 0) exit('Fixed header error');
//------------------------------

while (false !== ($bin = fgetc($handle))) {
    echo sprintf("%08s",bin2bit($bin)). "{$br}";
}

function bin2bit($bin)
{
    $hex = bin2hex($bin);
    $bit = base_convert($hex, 16, 2);
    return sprintf("%08s",$bit);
}