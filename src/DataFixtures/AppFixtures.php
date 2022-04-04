<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (['Software', 'Hardware', 'Autres'] as $categoryName) {
            $category = (new Category())->setName($categoryName);
            $manager->persist((object)$category);
        }

        $manager->flush();
    }
}
