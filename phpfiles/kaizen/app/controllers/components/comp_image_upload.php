<?php
class CompImageUploadComponent extends Object {
    function upload($name, $tmp_name, $path, $user_id) {
        // 画像アップロード
        if (!empty($name)) {
            $tmp_file = $tmp_name;
            $imginfo = getimagesize($tmp_file);

            clearstatcache();
            //200KB、JPEG・GIF・PNG
            if (filesize($tmp_file)>200000 || ($imginfo[2] < 1 || $imginfo[2] > 3)) {
                return ''; 
            } else {
                $upload_path = WWW_ROOT . $path . DS;
                $width_old  = $imginfo[0];
                $height_old = $imginfo[1];
                $width_new  = 100;  //リサイズ後の画像横幅
                $height_new = 100;  //リサイズ後の画像立て幅
    
                switch ($imginfo[2]) {
                    case 3: // png
                        $filename = sprintf("%05d.jpg", $user_id);
                        $png = imagecreatefrompng($tmp_file);
                        $png_new = imagecreatetruecolor($width_new, $height_new);
                        // アルファブレンディングを無効にし、アルファフラグを設定します
                        imagealphablending($png_new, false);
                        imagesavealpha($png_new, true);
                        $fillcolor = imagecolorallocatealpha($png_new, 0, 0, 0, 127);
                        imagefill($png_new, 0, 0, $fillcolor);
                        imagecopyresampled($png_new,$png,0,0,0,0,$width_new,$height_new,$width_old,$height_old);
                        imagepng($png_new, $upload_path . $filename, 0);    //png画像は、第3引数、０が無圧縮、9が最大圧縮
                        break;
                    case 2: // jpeg
                        $filename = sprintf("%05d.jpg", $user_id);
                        $jpeg = imagecreatefromjpeg($tmp_file);
                        $jpeg_new = imagecreatetruecolor($width_new, $height_new);
                        imagecopyresampled($jpeg_new,$jpeg,0,0,0,0,$width_new,$height_new,$width_old,$height_old);
                        imagejpeg($jpeg_new, $upload_path . $filename, 100);
                        break;
                    case 1: // gif
                        $filename = sprintf("%05d.jpg", $user_id);
                        $gif = imagecreatefromgif($tmp_file);
                        $gif_new = imagecreatetruecolor($width_new, $height_new);
                        //背景を透明にするための設定。pngとは若干勝手が異なる。この設定だと恐らく背景カラー白のみ透過可能で他色で透過している場合は背景職が黒になる。
                        $fillcolor = imagecolorallocatealpha($gif, 0, 0, 0, 127);
                        imagecolortransparent($gif_new, $fillcolor);
                        imagecopyresampled($gif_new,$gif,0,0,0,0,$width_new,$height_new,$width_old,$height_old);
                        imagegif($gif_new, $upload_path . $filename);   //gif画像は引数に画質intを持たない
                        break;
                    Default:
                        break;
                }
                return $filename;
            }
        } else {
            return  "";
        }
    }
}