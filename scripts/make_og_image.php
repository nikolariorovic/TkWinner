<?php
$bgPath  = __DIR__ . '/../public/images/naslovna.jpeg';
$outPath = __DIR__ . '/../public/images/og-image.jpg';
$fontReg = 'C:/Windows/Fonts/arial.ttf';
$fontBold = 'C:/Windows/Fonts/arialbd.ttf';

$W = 1200;
$H = 630;

$canvas = imagecreatetruecolor($W, $H);
imagealphablending($canvas, true);

[$srcW, $srcH] = getimagesize($bgPath);
$src = imagecreatefromjpeg($bgPath);

$srcRatio = $srcW / $srcH;
$dstRatio = $W / $H;
if ($srcRatio > $dstRatio) {
    $cropH = $srcH;
    $cropW = (int) round($srcH * $dstRatio);
    $cropX = (int) round(($srcW - $cropW) / 2);
    $cropY = 0;
} else {
    $cropW = $srcW;
    $cropH = (int) round($srcW / $dstRatio);
    $cropX = 0;
    $cropY = (int) round(($srcH - $cropH) / 2);
}
imagecopyresampled($canvas, $src, 0, 0, $cropX, $cropY, $W, $H, $cropW, $cropH);
imagedestroy($src);

for ($y = 0; $y < $H; $y++) {
    $t = $y / ($H - 1);
    $alpha127 = 127 - (int) round(40 + $t * 70);
    if ($alpha127 < 0) $alpha127 = 0;
    $color = imagecolorallocatealpha($canvas, 12, 10, 9, $alpha127);
    imageline($canvas, 0, $y, $W, $y, $color);
}

$bandWidth = (int) ($W * 0.65);
for ($x = 0; $x < $bandWidth; $x++) {
    $t = 1 - ($x / $bandWidth);
    $opacity = (int) round(110 * $t);
    $alpha127 = 127 - $opacity;
    if ($alpha127 < 0) $alpha127 = 0;
    $color = imagecolorallocatealpha($canvas, 12, 10, 9, $alpha127);
    imageline($canvas, $x, 0, $x, $H, $color);
}

imagealphablending($canvas, true);

$white  = imagecolorallocate($canvas, 255, 255, 255);
$orange = imagecolorallocate($canvas, 249, 115, 22);
$muted  = imagecolorallocate($canvas, 226, 220, 213);
$accent = imagecolorallocate($canvas, 234, 88, 12);

imagettftext($canvas, 22, 0, 70, 200, $orange, $fontBold, 'TENISKI KLUB');
imagettftext($canvas, 130, 0, 70, 360, $white,  $fontBold, 'Winner');
imagettftext($canvas, 26, 0, 70, 420, $muted,  $fontReg,  'Smederevska Palanka');
imagefilledrectangle($canvas, 70, 460, 70 + 90, 465, $accent);
imagettftext($canvas, 18, 0, 70, 530, $white, $fontReg, 'Tri terena  •  Balon za zimu  •  Skola tenisa');
imagettftext($canvas, 16, 0, 70, 580, $muted, $fontReg, 'tk-winner.com');

imagejpeg($canvas, $outPath, 90);
imagedestroy($canvas);

echo "Wrote $outPath\n";
