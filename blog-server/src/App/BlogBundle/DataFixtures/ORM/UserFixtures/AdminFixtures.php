<?php

namespace App\BlogBundle\DataFixtures\ORM;

use App\BlogBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class UserFixtures extends AbstractFixture implements ContainerAwareInterface{

    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setFirstName('Mariia');
        $user->setLastName('Ostashevskaya');
        $user->setUsername('lycsona');
        $user->setEmail('lycsona@gmail.com');
        $user->setPassword('_2012#mary');
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
        $manager->flush();
    }
}
