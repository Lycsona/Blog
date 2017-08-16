<?php

namespace App\BlogBundle\DataFixtures\ORM;

use App\BlogBundle\Entity\Tag;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class TagFixtures
 *
 * @package App\BlogBundle\DataFixtures\ORM
 */
class TagFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $tag = new Tag();

        $tag->setName('Tag test');

        $manager->persist($tag);

        $this->addReference('tag-test', $tag);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 1;
    }
}
