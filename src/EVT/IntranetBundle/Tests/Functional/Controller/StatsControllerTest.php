<?php

namespace EVT\IntranetBundle\Tests\Functional\Controller;

use EVT\CoreClientBundle\Client\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

 /**
 * StatsControllerTest
 *
  * @author    Marco Ferrari <marco.ferrari@bodaclick.com>
 * @copyright 2014 Bodaclick S.A.
 */
class StatsControllerTest extends WebTestCase
{

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    protected $client;

    use \EVT\IntranetBundle\Tests\Functional\LoginTrait;

    /**
     * Create a client to test request and mock services
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * @vcr apiStats.yml
     */
    public function testShowrooms()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/manager/stats/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('h3.page-title')->count());
        $this->assertEquals('Stats', $crawler->filter('h3.page-title')->html());
        $this->assertEquals(1, $crawler->filter('#chart_5')->count());
    }
}
