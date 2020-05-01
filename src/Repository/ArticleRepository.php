<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }


    public function findArticlesByString($search)
    {

        $sql = 'SELECT
            *
            FROM article
            WHERE title LIKE :search
            LIMIT 5
        ';

        $query = $this->getEntityManager()->getConnection()->prepare($sql);

        $query->execute(['search' => "%{$search}%"]);

        return $query->fetchAll();
    }

    public function findLastArticles()
    {
        $sql =
            'SELECT
        *
        FROM article
        ORDER BY article.created_at DESC
        LIMIT 4
        ';

        $query = $this->getEntityManager()->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function findAllOrderByDesc()
    {
        $sql =
            'SELECT
        *
        FROM article
        ORDER BY article.created_at DESC
        ';

        $query = $this->getEntityManager()->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }
}