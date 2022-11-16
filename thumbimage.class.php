<?php
// thumbimage.class.php
class ThumbImage
{
    private $source;

    public function __construct($sourceImagePath)
    {
        $this->source = $sourceImagePath;
    }

    public function createThumb($destImagePath, $thumbWidth=100)
    {
        file_put_contents("log.txt", print_r($destImagePath, 1));
        $ext = explode(".", $destImagePath);
        $ext = end($ext);
        $sourceImage = "";
        if($ext == 'jpeg' | $ext == 'jpg')
            $sourceImage = imagecreatefromjpeg($this->source);
        else if($ext == 'png')
            $sourceImage = imagecreatefrompng($this->source);
        else if($ext == 'bmp')
            $sourceImage = imagecreatefrombmp($this->source);
        else if($ext == 'gif')
            $sourceImage = imagecreatefromgif($this->source);
        $orgWidth = imagesx($sourceImage);
        $orgHeight = imagesy($sourceImage);
        $thumbHeight = floor($orgHeight * ($thumbWidth / $orgWidth));
        $destImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
        imagecopyresampled($destImage, $sourceImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $orgWidth, $orgHeight);

        if($ext == 'jpeg' | $ext == 'jpg')
            imagejpeg($destImage, $destImagePath);
        else if($ext == 'png')
            imagepng($destImage, $destImagePath);
        else if($ext == 'bmp')
            imagebmp($destImage, $destImagePath);
        else if($ext == 'gif')
            imagegif($destImage, $destImagePath);

        imagedestroy($sourceImage);
        imagedestroy($destImage);
    }
}