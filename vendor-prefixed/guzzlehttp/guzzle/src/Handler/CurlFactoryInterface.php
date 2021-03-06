<?php

namespace Dekode\GravityForms\Vendor\GuzzleHttp\Handler;

use Dekode\GravityForms\Vendor\Psr\Http\Message\RequestInterface;
interface CurlFactoryInterface
{
    /**
     * Creates a cURL handle resource.
     *
     * @param RequestInterface $request Request
     * @param array            $options Transfer options
     *
     * @throws \RuntimeException when an option cannot be applied
     */
    public function create(\Dekode\GravityForms\Vendor\Psr\Http\Message\RequestInterface $request, array $options) : \Dekode\GravityForms\Vendor\GuzzleHttp\Handler\EasyHandle;
    /**
     * Release an easy handle, allowing it to be reused or closed.
     *
     * This function must call unset on the easy handle's "handle" property.
     */
    public function release(\Dekode\GravityForms\Vendor\GuzzleHttp\Handler\EasyHandle $easy) : void;
}
