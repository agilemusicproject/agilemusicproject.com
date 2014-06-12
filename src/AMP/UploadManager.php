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
            $image->move($this->folderPath, $filename);
        }
        return $filename;
    }
    
    public function delete($filename)
    {
        if (file_exists($folderPath . '/' . $filename)) {
            unlink($folderPath . '/' . $filename);
        }
    }
}
