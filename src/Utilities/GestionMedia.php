<?php


namespace App\Utilities;


use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class GestionMedia
{
    private $mediaActivite;
    private $mediaRegion;
    private $mediConfig;

    public function __construct($activiteDirectory, $regionDirectory, $configDirectory)
    {
        $this->mediaActivite = $activiteDirectory;
        $this->mediaRegion = $regionDirectory;
        $this->mediConfig = $configDirectory;
    }

    /**
     * Enregistrement du fichier dans le repertoire approprié
     *
     * @param UploadedFile $file
     * @param null $media
     * @return string
     */
    public function upload(UploadedFile $file, $media = null)
    {
        // Initialisation du slug
        $slugify = new Slugify(); //dd($file);

        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugify->slugify($originalFileName);
        $newFilename = $safeFilename.'.'.$file->guessExtension(); //dd($this->mediaActivite);

        // Deplacement du fichier dans le repertoire dedié
        try {
            if ($media === 'activite') $file->move($this->mediaActivite, $newFilename);
            elseif ($media === 'configLogo') $file->move($this->mediaRegion, $newFilename);
            elseif ($media === 'configBg') $file->move($this->mediConfig, $newFilename);
            else $file->move($this->mediaActivite, $newFilename);
        }catch (FileException $e){

        }

        return $newFilename;
    }

    /**
     * Suppression de l'ancien media sur le server
     *
     * @param $ancienMedia
     * @param null $media
     * @return bool
     */
    public function removeUpload($ancienMedia, $media = null)
    {
        if ($media === 'activite') unlink($this->mediaActivite.'/'.$ancienMedia);
        elseif ($media === 'configLogo') unlink($this->mediaRegion.'/'.$ancienMedia);
        elseif ($media === 'configBg') unlink($this->mediConfig.'/'.$ancienMedia);
        else return false;

        return true;
    }
}