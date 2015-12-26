<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Symfony - Vue Todo App', $crawler->filter('h1')->text());
    }

    public function testGetTodos()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/todos');
    }

    public function testCreateTodo()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/todos');

        //{"description": "api task 6",}

    }

    public function testGetTodo()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/todos/{id}');
    }

    public function testEditTodos()
    {
        $client = static::createClient();
        $crawler = $client->request('PUT', '/api/todos/{id}');
    }

    public function testDeleteTodos()
    {
        $client = static::createClient();
        $crawler = $client->request('DELETE', '/api/todos/{id}');
    }

}
