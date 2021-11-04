<?php

namespace Dekode\GravityForms\Vendor\GuzzleHttp\Exception;

use Dekode\GravityForms\Vendor\GuzzleHttp\BodySummarizer;
use Dekode\GravityForms\Vendor\GuzzleHttp\BodySummarizerInterface;
use Dekode\GravityForms\Vendor\Psr\Http\Client\RequestExceptionInterface;
use Dekode\GravityForms\Vendor\Psr\Http\Message\RequestInterface;
use Dekode\GravityForms\Vendor\Psr\Http\Message\ResponseInterface;
use Dekode\GravityForms\Vendor\Psr\Http\Message\UriInterface;
/**
 * HTTP Request exception
 */
class RequestException extends \Dekode\GravityForms\Vendor\GuzzleHttp\Exception\TransferException implements \Dekode\GravityForms\Vendor\Psr\Http\Client\RequestExceptionInterface
{
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var ResponseInterface|null
     */
    private $response;
    /**
     * @var array
     */
    private $handlerContext;
    public function __construct(string $message, \Dekode\GravityForms\Vendor\Psr\Http\Message\RequestInterface $request, \Dekode\GravityForms\Vendor\Psr\Http\Message\ResponseInterface $response = null, \Throwable $previous = null, array $handlerContext = [])
    {
        // Set the code of the exception if the response is set and not future.
        $code = $response ? $response->getStatusCode() : 0;
        parent::__construct($message, $code, $previous);
        $this->request = $request;
        $this->response = $response;
        $this->handlerContext = $handlerContext;
    }
    /**
     * Wrap non-RequestExceptions with a RequestException
     */
    public static function wrapException(\Dekode\GravityForms\Vendor\Psr\Http\Message\RequestInterface $request, \Throwable $e) : \Dekode\GravityForms\Vendor\GuzzleHttp\Exception\RequestException
    {
        return $e instanceof \Dekode\GravityForms\Vendor\GuzzleHttp\Exception\RequestException ? $e : new \Dekode\GravityForms\Vendor\GuzzleHttp\Exception\RequestException($e->getMessage(), $request, null, $e);
    }
    /**
     * Factory method to create a new exception with a normalized error message
     *
     * @param RequestInterface             $request        Request sent
     * @param ResponseInterface            $response       Response received
     * @param \Throwable|null              $previous       Previous exception
     * @param array                        $handlerContext Optional handler context
     * @param BodySummarizerInterface|null $bodySummarizer Optional body summarizer
     */
    public static function create(\Dekode\GravityForms\Vendor\Psr\Http\Message\RequestInterface $request, \Dekode\GravityForms\Vendor\Psr\Http\Message\ResponseInterface $response = null, \Throwable $previous = null, array $handlerContext = [], \Dekode\GravityForms\Vendor\GuzzleHttp\BodySummarizerInterface $bodySummarizer = null) : self
    {
        if (!$response) {
            return new self('Error completing request', $request, null, $previous, $handlerContext);
        }
        $level = (int) \floor($response->getStatusCode() / 100);
        if ($level === 4) {
            $label = 'Client error';
            $className = \Dekode\GravityForms\Vendor\GuzzleHttp\Exception\ClientException::class;
        } elseif ($level === 5) {
            $label = 'Server error';
            $className = \Dekode\GravityForms\Vendor\GuzzleHttp\Exception\ServerException::class;
        } else {
            $label = 'Unsuccessful request';
            $className = __CLASS__;
        }
        $uri = $request->getUri();
        $uri = static::obfuscateUri($uri);
        // Client Error: `GET /` resulted in a `404 Not Found` response:
        // <html> ... (truncated)
        $message = \sprintf('%s: `%s %s` resulted in a `%s %s` response', $label, $request->getMethod(), $uri, $response->getStatusCode(), $response->getReasonPhrase());
        $summary = ($bodySummarizer ?? new \Dekode\GravityForms\Vendor\GuzzleHttp\BodySummarizer())->summarize($response);
        if ($summary !== null) {
            $message .= ":\n{$summary}\n";
        }
        return new $className($message, $request, $response, $previous, $handlerContext);
    }
    /**
     * Obfuscates URI if there is a username and a password present
     */
    private static function obfuscateUri(\Dekode\GravityForms\Vendor\Psr\Http\Message\UriInterface $uri) : \Dekode\GravityForms\Vendor\Psr\Http\Message\UriInterface
    {
        $userInfo = $uri->getUserInfo();
        if (\false !== ($pos = \strpos($userInfo, ':'))) {
            return $uri->withUserInfo(\substr($userInfo, 0, $pos), '***');
        }
        return $uri;
    }
    /**
     * Get the request that caused the exception
     */
    public function getRequest() : \Dekode\GravityForms\Vendor\Psr\Http\Message\RequestInterface
    {
        return $this->request;
    }
    /**
     * Get the associated response
     */
    public function getResponse() : ?\Dekode\GravityForms\Vendor\Psr\Http\Message\ResponseInterface
    {
        return $this->response;
    }
    /**
     * Check if a response was received
     */
    public function hasResponse() : bool
    {
        return $this->response !== null;
    }
    /**
     * Get contextual information about the error from the underlying handler.
     *
     * The contents of this array will vary depending on which handler you are
     * using. It may also be just an empty array. Relying on this data will
     * couple you to a specific handler, but can give more debug information
     * when needed.
     */
    public function getHandlerContext() : array
    {
        return $this->handlerContext;
    }
}
