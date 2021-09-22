<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    /**
     * Find messages in conversations
     *
     * @param [type] $id
     * @return void
     */
    public function findByConversation($id)
    {
        return $this->createQueryBuilder('p')
            ->join('p.messaging', 'Conversation')
            ->andWhere('Conversation.id = :id')
            ->setParameter('id', $id)
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Count unread messages in conversations
     *
     * @param [type] $user
     * @return void
     */
    public function countMessages($user)
    {
        return $this->createQueryBuilder('m')
            ->select('COUNT(m)')
            ->join('m.messaging', 'C')
            ->andWhere(':user MEMBER OF C.participants')
            ->andWhere(':user NOT MEMBER OF m.readBy')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * get messages
     */
    public function getMessages(int $id)
    {
       // SELECT * FROM `message` m
        //INNER JOIN messaging msg ON msg.id = m.messaging_id
        //WHERE msg.id = 56

        return $this->createQueryBuilder('m')
            ->innerJoin('m.messaging', 'msg')
            ->andWhere('msg.id = :id')
            ->setParameter('id', $id)
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
