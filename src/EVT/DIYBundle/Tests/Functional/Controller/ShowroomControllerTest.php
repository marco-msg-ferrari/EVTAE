<?php

namespace EVT\DIYBundle\Tests\Functional\Controller;

use EVT\DIYBundle\Model\Showroom;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ShowroomControllerTest
 *
 * @author    Marco Ferrari <marco.ferrari@bodaclick.com>
 * @copyright 2014 Bodaclick
 */
class ShowroomControllerTest extends WebTestCase
{
    protected $client;
    protected $header;

    use \EVT\IntranetBundle\Tests\Functional\LoginTrait;

    /**
     * Create a client to test request and mock services
     */
    public function setUp()
    {
        $this->client = static::createClient();
        $this->header = ['HTTP_Accept' => 'application/json'];
    }

    public function testShowrooms()
    {
        $this->logInEmployee();

        $this->client->request(
            'GET',
            '/api/showrooms/1',
            [],
            [],
            $this->header
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $showroom = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $showroom);
        $this->assertArrayHasKey('name', $showroom);
        $this->assertArrayHasKey('state', $showroom);

        $this->assertEquals('1', $showroom['id']);
        $this->assertEquals(Showroom::RETRIVED, $showroom['state']);
    }
}