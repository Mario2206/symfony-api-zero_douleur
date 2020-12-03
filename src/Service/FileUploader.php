<?php 

namespace App\Service;

use DateTime;
use Exception;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader {

    private $slugger;

    private $targetDirectory;

    private $filesystem;


    
    public function __construct($targetDirectory, SluggerInterface $slugger, Filesystem $filesystem )
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
        $this->filesystem = $filesystem;
    }

    /**
     * For uploading media file
     * 
     * @param UploadedFile $mediaFile
     * 
     * @return void
     */
    public function upload ($mediaFile) : string
    {
        
        if( gettype($mediaFile) !== "object" ||  get_class($mediaFile) !== UploadedFile::class) {
            throw new Exception("The uploaded file isn't file");
        }

        $newFileName = "";
                
        try {
            
            $uploadedAt = new DateTime();

            $originalFileName = pathinfo($mediaFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFileName =  $this->slugger->slug($originalFileName);
            $newFileName = $safeFileName . "-" . uniqid() . "-" . $uploadedAt->format("Y-m-d") . "." . $mediaFile->guessExtension();
    
            
    
            $mediaFile->move(
                $this->getTargetDirectory(),
                $newFileName
            );
            
            return $newFileName;
            
        } catch(FileException $e) {
            
            throw new UploadException("An error occured during the file upload", HTTP_SERVER_ERROR);
            
        }

        catch(Exception $e) {

            $this->deleteFile($newFileName);

            throw new UploadException("A problem occured during the persisting of data", HTTP_SERVER_ERROR);

        }


    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    public function deleteFile(string $filename) 
    {
        try {

             $this->filesystem->remove($this->targetDirectory . "/" . $filename);

        } catch(IOException $e) {

            throw new IOException("An error ocurred during file removing");

        }
       
    }

}