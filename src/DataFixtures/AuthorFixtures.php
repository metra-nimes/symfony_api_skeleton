<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use App\Entity\Author;

class AuthorFixtures extends BaseFixture
{
    public function load(ObjectManager $manager)
    {
	    $this->manager = $manager;

	    $this->createMany(Author::class, 10000, function(Author $author) {
		    $author->setName($this->faker->name);
	    });

	    $manager->flush();
    }
}
