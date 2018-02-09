<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TagFixture extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $tags = array();

        // Création des tags
        for ($i = 0; $i <= 15; $i++) {
            $tag = new Tag();
            $tag->setName('tag' . $i);
            $manager->persist($tag);
            $tags[] = $tag;
        }
        
        // Associations tags produits
        for ($i = 1; $i <= 40; $i++) {
            $nbTags = rand(1, 5);
            $product = $this->getReference('product' . $i);
            for ($j = 0; $j < $nbTags; $j++) {
                $tag = $tags[rand(0, 14)];
                // pour ne pas avoir deux fois le même le tag
                $product->addTag($tag);
            }
            $manager->persist($product);
        }
        
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProductFixture::class
        ];
    }

}