<?php
namespace AMP;

class UploadManager
{
    private $uploadDirectory;
    private $thumbnailsDirectoryName = '/thumbnails';
    private $thumbnailWidth = 900;
    
    public function __construct($uploadDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
    }
    
    public function upload($file)
    {
        $filename =  $file->getClientOriginalName();
        $file->move($this->uploadDirectory, $filename);
        return $filename;
    }
    
    public function uploadPhoto($file)
    {
        $filename = $this->upload($file);
        if (!file_exists($this->getThumbnailDirectory())) {
            mkdir($this->getThumbnailDirectory());
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
        $this->delete($this->getFilePath($filename));
    }
    
    public function deleteThumbnail($filename)
    {
        $this->delete($this->getThumbnailFilePath($filename));
    }
    
    public function createThumbnail($filename, $desired_width)
    {
        list($width, $height) = getimagesize($this->getFilepath($filename));
        $percent = $desired_width/$width;
        $desired_height = $height * $percent;
        
        $thumb = imagecreatetruecolor($desired_width, $desired_height);
        $source = imagecreatefromjpeg($this->getFilepath($filename));
        
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        
        imagejpeg($thumb, $this->getThumbnailFilePath($filename));
        imagedestroy($thumb);
    }
    
    public function getThumbnailDirectory()
    {
        return $this->uploadDirectory . $this->thumbnailsDirectoryName;
    }
    
    public function getFilePath($filename)
    {
        return $this->uploadDirectory . '/' . $filename;
    }
    
    public function getThumbnailFilePath($filename)
    {
        return $this->getThumbnailDirectory() . '/thumb_' . $filename;
    }
}
