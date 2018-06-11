<?php

namespace BeHappy\SyliusCartManagementPlugin\Repository;

use BeHappy\SyliusCartManagementPlugin\Entity\SavedCart;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ShopUserInterface;

/**
 * Class SavedCartRepository
 * @package BeHappy\SyliusCartManagementPlugin\Repository
 */
class SavedCartRepository extends EntityRepository
{
    /**
     * @param ShopUserInterface $user
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createByUserQueryBuilder(ShopUserInterface $user)
    {
        return $this->createQueryBuilder('sc')
            ->where('sc.user = :user')
            ->setParameter('user', $user);
    }

    /**
     * @param $token
     *
     * @return null|SavedCart|object
     */
    public function findByToken($token)
    {
        return $this->findOneBy([
            'token' => $token
        ]);
    }

    /**
     * @param $id
     * @param $user
     *
     * @return null|SavedCart|object
     */
    public function findByIdAndUser($id, $user)
    {
        return $this->findOneBy([
            'id' => $id,
            'user' => $user
        ]);
    }
}