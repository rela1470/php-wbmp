<?php
/**
 * Created by PhpStorm.
 * User: j.watanabe
 * Date: 2018/03/02
 * Time: 15:30
 */

//webかcliか
$br = (php_sapi_name() == 'cli') ? "\n" : "<br>";

$file_name = './pic_1024x768.wbmp';

$handle = fopen($file_name, 'r');

if (! $handle) {
    echo $file_name . 'をオープンできませんでした';
}

//------------------------------
//WBMP type
$type = get_uintvar($handle);
if ( $type != 0) exit('WBMP type error');
//------------------------------

//------------------------------
//Fixed header
$header = bindec(bin2bit(fgetc($handle))); //1 octet
if ( $header != 0) exit('Fixed header error');
//------------------------------

//------------------------------
//width x height
$width  = get_uintvar($handle);
$height = get_uintvar($handle);
//------------------------------

echo "width:{$width} height:{$height}{$br}";

//------------------------------
//表示
$output_width = 0;
while (false !== ($bin = fgetc($handle))) {
    $byte = bin2bit($bin);

    for($i = 0; $i <= 7; $i ++) {
        echo ($byte[$i]) ? '□' : '■';
        $output_width ++;
        if ($output_width >= $width) {
            echo $br;
            $output_width = 0;
            break;
        }
    }
}
//------------------------------


/**
 * バイナリを2進数のビット表記に変換
 * @param $bin
 * @return string 01010101(ビット)
 */
function bin2bit($bin)
{
    $hex = bin2hex($bin);
    $bit = base_convert($hex, 16, 2);
    return sprintf("%08s",$bit);
}

/**
 * uintvar形式からint型に変換して取得
 * @see https://en.wikipedia.org/wiki/Variable-length_quantity
 * @param resource $handle
 * @return float|int
 */
function get_uintvar($handle)
{
    $return = '';
    while (false !== ($bin = fgetc($handle))) {
        $bit = bin2bit($bin);
        $return .= substr($bit, 1, 7);//最上位ビットは判断用

        if ($bit[0] == 0) { //このbyteでおわり
            return bindec($return);
        }
    }
}