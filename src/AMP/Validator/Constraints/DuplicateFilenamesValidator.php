<?php
namespace AMP\Validator\Constraints;

use AMP\UploadManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Annotation
 */
class DuplicateFilenamesValidator extends ConstraintValidator
{
    public function validate($file, Constraint $constraint)
    {
        $isValid = true;
        
        if (!is_null($file)) {
            $uploadManager = $constraint->uploadManager;
            if (is_object($file)) {
                $isValid = $this->isValidUploadedFile($file, $uploadManager);
            } else {
                $isValid = $this->isValidUploadByURL($file, $uploadManager);
            }
        }
        
        if (!$isValid) {
            $this->context->addViolation($constraint->message);
        }
    }
    
    private function isValidUploadedFile(UploadedFile $file, UploadManager $uploadManager)
    {
        $filepath = $uploadManager->getFilePath($file->getClientOriginalName());
        return $this->isValidFilePath($filepath);
    }
    
    private function isValidUploadByURL($file, UploadManager $uploadManager)
    {
        $filename = basename($file);
        $filepath = $uploadManager->getFilePath($filename);
        return $this->isValidFilePath($filepath);
    }
    
    private function isValidFilePath($filepath)
    {
        if (file_exists($filepath)) {
           return false;
        }
        
        return true;
    }
}
