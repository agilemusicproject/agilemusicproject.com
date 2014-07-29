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

    public function upload($file, $newFileName = null)
    {
        $filename = is_null($newFileName) ? $file->getClientOriginalName() : $newFileName;
        $file->move($this->uploadDirectory, $filename);
        return $filename;
    }

    public function uploadPhoto($file, $newFileName = null)
    {
        $filename = is_null($newFileName) ? $this->upload($file) : $this->upload($file, $newFileName);
        $this->createThumbnail($filename, $this->thumbnailWidth);
        return $filename;
    }

    public function uploadPhotoUrl($file, $newFileName = null)
    {
        $filename = is_null($newFileName) ? basename($file) : $newFileName;
        file_put_contents($this->uploadDirectory . "/" . $filename, file_get_contents($file));
        $this->createThumbnail($filename, $this->thumbnailWidth);
        return $filename;
    }

    private function delete($filename)
    {
        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    public function deleteFileAndThumbnail($filename)
    {
        $this->deleteFile($filename);
        $this->deleteThumbnail($filename);
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
        if (!file_exists($this->getThumbnailDirectory())) {
            mkdir($this->getThumbnailDirectory());
        }
        list($width, $height) = getimagesize($this->getFilepath($filename));
        $percent = $desired_width/$width;
        $desired_height = $height * $percent;

        $thumb = imagecreatetruecolor($desired_width, $desired_height);

        $extension = substr($filename, strrpos($filename, '.')+1);
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
