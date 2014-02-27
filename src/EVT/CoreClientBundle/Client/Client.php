<?php

namespace EVT\CoreClientBundle\Client;

use Guzzle\Http\ClientInterface;

/**
 * Client
 *
 * @author    Quique Torras <etorras@bodaclick.com>
 * @author    Marco Ferrari <marco.ferrari@bodaclick.com>
 * @copyright 2014 Bodaclick S.A.
 */
class Client
{
    private $guzzleClient;
    private $apikey;
    private $domain;
    private $securityClient;

    public function __construct(ClientInterface $guzzleClient, $apikey, $domain, $securityClient)
    {
        $this->guzzleClient = $guzzleClient;
        $this->apikey = $apikey;
        $this->domain = $domain;
        $this->securityClient = $securityClient;
    }

    public function sendRequest($url)
    {
        $securedUrl = $this->securityClient->securizeUrl($url);

        if (false !== strpos($securedUrl, '?')) {
            $securedUrl .= '&';
        } else {
            $securedUrl .= '?';
        }

        $request = $this->guzzleClient->get($this->domain . $securedUrl . 'apikey=' . $this->apikey);
        try {
            $response = $request->send();
        } catch (\Exception $e) {
            return new Response(404, []);
        }
        return $this->securityClient->securizeResponse($response);
    }
}
