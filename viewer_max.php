<?php
/**
 * Created by PhpStorm.
 * User: j.watanabe
 * Date: 2018/03/02
 * Time: 15:30
 */

$br = (php_sapi_name() == 'cli') ? "\n" : "<br>";

$data = file_get_contents('./pic_127x127.wbmp');

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
$width = hexdec(array_shift($array));
$height = hexdec(array_shift($array));

echo "width:{$width} height:{$height}{$br}";
$output = [];
foreach ((array)$array as $bits) {
    $output[] = sprintf("%08s", decbin(hexdec($bits))). "{$br}";

}

$max = ($height > 8) ? 8 : $height;

$count = 0;
foreach ($output as $line) {
    for ($i = 0; $i < $max; $i ++) {
        $count ++;

        //行がオクテットの途中で終わった
        if ($count > $width) {
            echo "{$br}";
            $count = 0;
            continue;//あとのビットはパディング分なので無視する
        }

        echo ($line[$i]) ? '□' : '■';
    }

    //行がオクテットの末尾でちょうど終わった
    if ($count == $width) {
        echo "{$br}";
        $count = 0;
        continue;//あとのビットはパディング分なので無視する
    }
}