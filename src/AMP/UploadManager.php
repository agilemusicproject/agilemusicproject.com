<?php
namespace AMP;

class UploadManager
{
    private $folderPath;
    
    public function __construct($folderPath)
    {
        $this->folderPath = $folderPath;
    }
    
    public function upload($file)
    {
        $filename = null;
        if (!is_null($file)) {
            $filename =  $file->getClientOriginalName();
            $file->move($this->folderPath, $filename);
            if(!file_exists($this->folderPath . '/thumbnails')) {
                mkdir($this->folderPath . '/thumbnails');
            }
            $this->createThumb($filename, 900);
        }
        return $filename;
    }
    
    public function delete($filename)
    {
        if (file_exists($this->folderPath . '/' . $filename)) {
            unlink($this->folderPath . '/' . $filename);
        }
    }
    
    public function deleteThumb($filename)
    {
        if (file_exists(($this->folderPath . '/thumbnails/thumb_' . $filename))) {
            unlink(($this->folderPath . '/thumbnails/thumb_' . $filename));
        }
    }
    
    public function createThumb($filename, $desired_width)
    {
        // File and new size
        //the original image has 800x600
        //the resize will be a percent of the original size
        
        // Content type
        header('Content-Type: image/jpeg');
        
        // Get new sizes
        list($width, $height) = getimagesize($this->folderPath . '/' . $filename);
        $percent = $desired_width/$width;
        $desired_height = $height * $percent;
        
        // Load
        $thumb = imagecreatetruecolor($desired_width, $desired_height);
        $source = imagecreatefromjpeg($this->folderPath . '/' . $filename);
        
        // Resize
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        
        // Output and free memory
        //the resized image will be 400x300
        imagejpeg($thumb, ($this->folderPath . '/thumbnails/thumb_' . $filename));
        imagedestroy($thumb);
    }
}
