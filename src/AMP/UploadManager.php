<?php
namespace AMP;

class UploadManager
{
    private $folderPath;
    private $thumbnailsDirectory = '/thumbnails';
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
        if (!file_exists($this->getThumbnailDir())) {
            mkdir($this->getThumbnailDir());
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
    
    public function getThumbnailFolderPath()
    {
        return $this->folderPath . $this->thumbnailsDirectory;
    }
    
    public function getFilePath($filename)
    {
        return $this->folderPath . '/' . $filename;
    }
    
    public function getThumbnailFilePath($filename)
    {
        return $this->getThumbnailFolderPath() . '/thumb_' . $filename;
    }
}
