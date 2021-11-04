<?php

namespace Dekode\GravityForms\Vendor\GuzzleHttp;

use Dekode\GravityForms\Vendor\Psr\Http\Message\MessageInterface;
final class BodySummarizer implements \Dekode\GravityForms\Vendor\GuzzleHttp\BodySummarizerInterface
{
    /**
     * @var int|null
     */
    private $truncateAt;
    public function __construct(int $truncateAt = null)
    {
        $this->truncateAt = $truncateAt;
    }
    /**
     * Returns a summarized message body.
     */
    public function summarize(\Dekode\GravityForms\Vendor\Psr\Http\Message\MessageInterface $message) : ?string
    {
        return $this->truncateAt === null ? \Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Message::bodySummary($message) : \Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Message::bodySummary($message, $this->truncateAt);
    }
}
