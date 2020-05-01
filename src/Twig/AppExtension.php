<?php


namespace App\Twig;


use App\Controller\AdminController;
use App\Entity\Article;
use App\Service\UploaderHelper;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension implements ServiceSubscriberInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('uploaded_asset', [$this, 'getUploadedAssetPath'])
        ];
    }

    public static function getSubscribedServices()
    {
        return [
            UploaderHelper::class,
        ];
    }

    public function getUploadedAssetPath($content)
    {
        return $this->container
            ->get(UploaderHelper::class)
            ->getImagePath($content);
    }


}