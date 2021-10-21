<?php


namespace App\Doctrine;

use App\Entity\Customer;
use App\Entity\Invoice;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{   
    private $security;
    private $auth;

    public function __construct(Security $security, AuthorizationCheckerInterface $auth)
    {
        $this->security = $security;
        $this->auth = $auth;
    }

    private function addWhereToQuery(QueryBuilder $queryBuilder, string $resourceClass) {
        $user = $this->security->getUser();

        if(($resourceClass === Customer::class || $resourceClass === Invoice::class) 
            && !$this->auth->isGranted("ROLE_ADMIN") 
            && $user instanceof User) {            
            $rootAlias = $queryBuilder->getRootAliases()[0];
            // dd($queryBuilder); // dd($rootAlias);
            if($resourceClass === Customer::class) {
                $queryBuilder->andWhere("$rootAlias.user = :user");
            } else if ($resourceClass === Invoice::class) {
                $queryBuilder
                        ->join("$rootAlias.customer", "c")
                        ->andWhere("c.user = :user");
            }
            $queryBuilder->setParameter("user", $user);
        }
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?string $operationName = null)
    {
        $this->addWhereToQuery($queryBuilder, $resourceClass);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, ?string $operationName = null, array $context = [])
    {
        $this->addWhereToQuery($queryBuilder, $resourceClass);
    }
}