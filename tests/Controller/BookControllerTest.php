<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookControllerTest extends WebTestCase
{
	public function testCreateBook()
	{
		$client = static::createClient();

		$client->request(
			'POST',
			'/api/book/create',
			[],
			[],
			['CONTENT_TYPE' => 'application/json'],
			'{"name":"Book", "author": "10"}'
		);

		$this->assertEquals(200, $client->getResponse()->getStatusCode());
	}
}