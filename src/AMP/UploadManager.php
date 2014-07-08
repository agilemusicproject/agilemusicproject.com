<?php
namespace AMP;

class UploadManager
{
    private $folderPath;
    private $thumbnailDirectory = '/thumbnails';
    private $thumbnailWidth = 900;
    
    public function __construct($folderPath)
    {
        $this->folderPath = $folderPath;
    }
    
    public function upload($file)
    {
        $filename =  $file->getClientOriginalName();
        $file->move($this->folderPath, $filename);
        return $filename;
    }
    
    public function uploadPhoto($file)
    {
        $filename = $this->upload($file);
        if (!file_exists($this->folderPath . '/thumbnails')) {
            mkdir($this->folderPath . '/thumbnails');
        }
        $this->createThumbnail($filename, $this->thumbnailWidth);
        return $filename;
    }
    
    private function delete($filename)
    {
        if (file_exists($filename)) {
            unlink($filename);
        }
    }
    
    public function deleteFile($filename)
    {
        $this->delete($this->folderPath . '/' . $filename);
    }
    
    public function deleteThumbnail($filename)
    {
        $this->delete($this->folderPath . '/thumbnails/thumb_' . $filename);
    }
    
    public function createThumbnail($filename, $desired_width)
    {
        header('Content-Type: image/jpeg');
        
        list($width, $height) = getimagesize($this->folderPath . '/' . $filename);
        $percent = $desired_width/$width;
        $desired_height = $height * $percent;
        
        $thumb = imagecreatetruecolor($desired_width, $desired_height);
        $source = imagecreatefromjpeg($this->folderPath . '/' . $filename);
        
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        
        imagejpeg($thumb, $this->folderPath . '/thumbnails/thumb_' . $filename);
        imagedestroy($thumb);
    }
}
