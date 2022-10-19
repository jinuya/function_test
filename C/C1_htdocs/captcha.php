<?php

        $str = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
        $code = '';
        for ($i = 0; $i < 5; $i++) {
            $code .= $str[rand(0, strlen($str) - 1)];
        }

        session()->set("captcha", $code);

        $im = imagecreatetruecolor(100, 80);
        $bg = imagecolorallocate($im, 22, 86, 165); // background color blue
        $fg = imagecolorallocate($im, 255, 255, 255); // text color white
        imagefill($im, 0, 0, $bg);
        imagestring($im, 5, 28, 30, $code, $fg);
        header('Content-type: image/png');
        imagepng($im);
        imagedestroy($im);