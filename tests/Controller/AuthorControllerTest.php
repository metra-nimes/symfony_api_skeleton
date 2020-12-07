<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthorControllerTest extends WebTestCase
{
	public function testCreateAuthor()
	{
		$client = static::createClient();

		$client->request(
			'POST',
			'/api/author/create',
			[],
			[],
			['CONTENT_TYPE' => 'application/json'],
			'{"name":"Author"}'
		);

		$this->assertEquals(200, $client->getResponse()->getStatusCode());
	}
}