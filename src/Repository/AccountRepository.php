<?php

namespace App\Repository;

use App\Entity\Account;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Account>
 *
 * @method Account|null find($id, $lockMode = null, $lockVersion = null)
 * @method Account|null findOneBy(array $criteria, array $orderBy = null)
 * @method Account[]    findAll()
 * @method Account[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
    }

    public function save(Account $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Account $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function checkExistence(array $account_info){
        $em = $this->getEntityManager();
        return $em->getRepository(Account::class)->findOneBy(["name"=>$account_info["name"],"surname"=>$account_info["surname"],"mail"=>$account_info["email"]]);
    }

    public function addAccount(array $account_info){
        $em = $this->getEntityManager();
        $account = new Account();

        $account->setUsername($account_info["username"])
        ->setPassword($account_info["password"])
        ->setPhoneNumber($account_info["phone_number"])
        ->setName($account_info["name"])
        ->setSurname($account_info["surname"])
        ->setAge($account_info["age"])
        ->setMail($account_info["email"]);

        $em -> persist($account);
        $em -> flush();
    }

    public function loginAccount(array $account_info){
        $em = $this->getEntityManager();

        return $em->getRepository(Account::class)->findOneBy(["username"=>$account_info["username"],"password"=>$account_info["password"]]);
    }

//    /**
//     * @return Account[] Returns an array of Account objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Account
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
