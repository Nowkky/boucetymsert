<?php

namespace App\Repository;

use App\Entity\Messages;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Messages>
 *
 * @method Messages|null find($id, $lockMode = null, $lockVersion = null)
 * @method Messages|null findOneBy(array $criteria, array $orderBy = null)
 * @method Messages[]    findAll()
 * @method Messages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Messages::class);
    }

   /**
    * @return Messages[] Returns an array of Messages objects
    */
   public function findMessagesFromUsers(User $author, User $receiver): array
   {
       return $this->createQueryBuilder('m')
           ->where('m.author = :author')
           ->orWhere('m.author = :receiver')
           ->andWhere('m.receiver = :receiver')
           ->orWhere('m.receiver = :author')
           ->setParameters(['author' => $author, 'receiver' => $receiver])
           ->orderBy('m.created_at', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?Messages
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
