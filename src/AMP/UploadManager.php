<?php
namespace AMP;

class UploadManager
{
    private $uploadDirectory;
    private $thumbnailsDirectoryName = '/thumbnails';
    private $thumbnailWidth = 250;
    private $thumbnailHeight = 250;
    
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
        $this->createThumbnail($filename, $this->thumbnailWidth, $this->thumbnailHeight);
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
    
    public function createThumbnail($filename, $thumb_width, $thumb_height)
    {
        list($width, $height) = getimagesize($this->getFilepath($filename));
        $original_aspect = $width/$height;
        $thumb_aspect = $thumb_width/$thumb_height;
        
        if ($original_aspect >= $thumb_aspect) {
            $new_height = $thumb_height;
            $new_width = $width / ($height/$thumb_height);
        } else {
            $new_width = $thumb_width;
            $new_height = $height / ($width/$thumb_width);
        }
        
        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
        
        $extension = substr($filename, strrpos($filename, '.')+1);
        var_dump($extension);
        switch($extension) {
            case 'jpeg':
            case 'jpg':
                $source = imagecreatefromjpeg($this->getFilepath($filename));
                break;
            case 'png':
                $source = imagecreatefrompng($this->getFilepath($filename));
                break;
            case 'gif':
                $source = imagecreatefromgif($this->getFilepath($filename));
                break;
        }
        
        imagecopyresized(
            $thumb,
            $source,
            0 - ($new_width - $thumb_width) / 2,
            0 - ($new_height - $thumb_height) / 2,
            0,
            0,
            $new_width,
            $new_height,
            $width,
            $height
        );
        
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
