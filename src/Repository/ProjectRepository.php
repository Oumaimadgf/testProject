<?php


namespace App\Repository;

use App\Entity\Project;
use App\Entity\ProjectSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Migrations\Query\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function add(Project $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Project $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findAllProjects(ProjectSearch $search): \Doctrine\ORM\Query
    {
         $query= $this->createQueryBuilder('p');

        if($search->getStatus()){

            $query=   $query->andWhere('p.status LIKE :status');
            $query->setParameter('status',$search->getStatus());

        }
        if($search->getTitle()){

            $query=   $query->andWhere('p.title LIKE :title');
            $query->setParameter('title',$search->getTitle());

        }
        if($search->getFilename()){

            $query=   $query->andWhere('p.url LIKE :filename');
            $query->setParameter('filename',$search->getFilename());

        }
        return $query ->getQuery();
    }



    public function findProjects(): QueryBuilder {

        $query= $this->createQueryBuilder('p');

        return $query;
    }
}