<?php

namespace App\BlogBundle\DataFixtures\ORM;

use App\BlogBundle\Entity\Article;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class ArticleFixtures
 *
 * @package App\BlogBundle\DataFixtures\ORM
 */
class ArticleFixtures extends AbstractFixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $Article = new Article();

        $Article->setName('First article');
        $Article->setContent('My first story here.');

        $manager->persist($Article);
        $manager->flush();
    }
}
