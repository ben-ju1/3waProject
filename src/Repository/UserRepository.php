<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findUsers()
    {
        $sql =
            'SELECT
                firstname, id, firstname, lastname, username, email, roles
            FROM user
            ORDER BY username 
            ';

        $query = $this->getEntityManager()->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }
// Inutile de faire circuler le mot passe dans une requete

    public function findAllOrderByDesc()
    {
        $sql =
            'SELECT
        id, firstname, lastname, username, email, roles
        FROM user
        ORDER BY user.id DESC
        ';

        $query = $this->getEntityManager()->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function changeRoleUser(string $newRole, int $id)
    {
        $sql =
            'UPDATE user
            SET roles = :newrole
            WHERE id = :id';

        $query = $this->getEntityManager()->getConnection()->prepare($sql);
        $query->execute([
            'newrole' => $newRole,
            'id' => $id,
        ]);
    }
    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
