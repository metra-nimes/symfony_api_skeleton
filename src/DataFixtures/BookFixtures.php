<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BookFixtures extends BaseFixture implements DependentFixtureInterface
{
	protected $books = [
		'Война и мир',
		'На маяк',
		'Великий Гетсби',
		'Фиеста',
		'Американская Трагедия',
		'Сто лет одиночества',
		'Гроздья гнева',
		'Улисс',
		'Лолита',
		'Шум и ярость',
	];

    public function load(ObjectManager $manager)
    {
	    $this->manager = $manager;

	    $this->createMany(Book::class, 10000, function(Book $book) {
		    $book->setName($this->books[rand(0, count($this->books)-1)]);
		    $book->setAuthor($this->getRandomReference(Author::class));
	    });

	    $manager->flush();
    }

	public function getDependencies()
	{
		return [AuthorFixtures::class];
	}
}
