<?php


namespace App\Service;


use App\Entity\Article;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class UploaderHelper
{
//    Constante qui pointe directement vers le fichier source d'images (à changer si changement vers cloud...)

    const FOLDER_UPLOADS = 'uploads/article_image/';

    private $requestStackContext;


    public function __construct(RequestStackContext $requestStackContext)
    {
        $this->requestStackContext = $requestStackContext;
    }

    // Twig Extension "uploaded_asset" qui permet de pointer directement vers le folder d'image

    public function getImagePath($content)
    {
        return self::FOLDER_UPLOADS . $content;
    }

    public function uploadFile($uploadedFile)
    {
        if ($uploadedFile === null) {
            return false;
        }
        $destination = self::FOLDER_UPLOADS;

        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

        $newFileName = Urlizer::urlize($originalFilename) . '-' . uniqid() . '.' . $uploadedFile->guessExtension();

        $uploadedFile->move($destination, $newFileName);

        return $newFileName;
    }

    public function deleteFile(Article $article)
    {
        $filesystem = new Filesystem();
        if ($article->getImage() !== "" && $filesystem->exists(UploaderHelper::FOLDER_UPLOADS . $article->getImage())) {
            $filesystem->remove(UploaderHelper::FOLDER_UPLOADS . $article->getImage());
            return $article->getImage();
//            return true;
        }
            return new Response("Aucune image n'a été supprimé.", 200);
    }
}