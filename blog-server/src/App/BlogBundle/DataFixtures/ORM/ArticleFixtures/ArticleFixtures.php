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

        $Article->setName('SAN ANTONIO');
        $Article->setContent(
            'SAN ANTONIO — If within the past few years you received a package,
             roamed a shopping mall, boarded a plane, train, ferry or cruise ship,
              went to a major sporting event, ran a marathon, attended a concert,
              gambled at a casino or visited a tourist attraction, chances are a 
              dog made sure it was safe for you to do so. With terrorists increasingly 
              attacking so-called soft targets, the demand for detection dogs that can
               sweep large areas for explosives has soared. So have prices, which can 
               exceed $25,000 for a single dog. Security experts warn that the supply
                of these dogs is dwindling worldwide and that the United States is especially
                 vulnerable because it relies primarily on brokers who source dogs 
                 from Eastern Europe. Technological alternatives have so far proven inadequate. 
                 Despite decades of trying, researchers have yet to develop a machine 
                 as exquisitely sensitive and discerning as a dog’s nose. Nor can a robot
                  rove with the agility and ease of a dog.');

        $manager->persist($Article);
        $manager->flush();
    }
}
