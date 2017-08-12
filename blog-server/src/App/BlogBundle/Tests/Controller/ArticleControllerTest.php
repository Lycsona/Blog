<?php

namespace App\BlogBundle\Tests\Controller;

use App\BlogBundle\DTO\ArticleDTO;
use App\BlogBundle\Tests\DoctrineTestCase;
use Symfony\Component\HttpFoundation\Request;

class ArticleControllerTest extends DoctrineTestCase
{
    public function setUp()
    {
        $this->loadFixturesFromDirectory('src/App/BlogBundle/DataFixtures/ORM/ArticleFixtures');
    }

    public function testGetAllArticle()
    {
        $client = self::createClient();
        $client->request(
            'GET',
            'api/articles',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json')
        );

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }

    //TODO:: Fix create, edit tests
//    public function testCreateArticle()
//    {
//        $content = json_encode(['name' => 'Test Name', 'content' => 'Test Content']);
//
//        $client = self::createClient();
//        $client->request(
//            'POST',
//            'api/articles',
//            array(),
//            array(),
//            array('CONTENT_TYPE' => 'application/json'),
//            $content
//        );
//        $response = $client->getResponse();
//
//        $this->assertEquals(201, $response->getStatusCode());
//    }

//    public function testEditArticle()
//    {
//        $content = json_encode(['name' => 'Test edit name', 'content' => 'Test edit content']);
//        $id = 1;
//
//        $client = self::createClient();
//        $client->request(
//            'PUT',
//            'api/articles' . $id,
//            array(),
//            array(),
//            array('CONTENT_TYPE' => 'application/json'),
//            $content
//        );
//
//        $response = $client->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//    }

    public function testGetArticleById()
    {
        $id = 1;

        $client = self::createClient();
        $client->request(
            'GET',
            'api/articles/' . $id,
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json')
        );

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteArticle()
    {
        $id = 1;

        $client = self::createClient();
        $client->request(
            'DELETE',
            'api/articles/' . $id,
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json')
        );

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }
}
