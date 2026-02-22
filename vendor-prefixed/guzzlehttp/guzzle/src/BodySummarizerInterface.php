<?php

namespace Dekode\GravityForms\Vendor\GuzzleHttp;

use Dekode\GravityForms\Vendor\Psr\Http\Message\MessageInterface;
interface BodySummarizerInterface
{
    /**
     * Returns a summarized message body.
     */
    public function summarize(MessageInterface $message) : ?string;
}
