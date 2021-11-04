<?php

namespace Dekode\GravityForms\Vendor\Psr\Http\Client;

use Dekode\GravityForms\Vendor\Psr\Http\Message\RequestInterface;
use Dekode\GravityForms\Vendor\Psr\Http\Message\ResponseInterface;
interface ClientInterface
{
    /**
     * Sends a PSR-7 request and returns a PSR-7 response.
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface If an error happens while processing the request.
     */
    public function sendRequest(\Dekode\GravityForms\Vendor\Psr\Http\Message\RequestInterface $request) : \Dekode\GravityForms\Vendor\Psr\Http\Message\ResponseInterface;
}
