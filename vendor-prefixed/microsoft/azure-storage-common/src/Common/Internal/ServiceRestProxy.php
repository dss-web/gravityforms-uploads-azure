<?php

/**
 * LICENSE: The MIT License (the "License")
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * https://github.com/azure/azure-storage-php/LICENSE
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * PHP version 5
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Common\Internal
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
namespace Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal;

use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\RetryMiddlewareFactory;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Serialization\XmlSerializer;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpCallContext;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Middlewares\MiddlewareBase;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Middlewares\MiddlewareStack;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode;
use Dekode\GravityForms\Vendor\GuzzleHttp\Promise\EachPromise;
use Dekode\GravityForms\Vendor\GuzzleHttp\Exception\RequestException;
use Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Request;
use Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Uri;
use Dekode\GravityForms\Vendor\GuzzleHttp\Client;
use Dekode\GravityForms\Vendor\GuzzleHttp\Psr7;
use Dekode\GravityForms\Vendor\Psr\Http\Message\ResponseInterface;
/**
 * Base class for all services rest proxies.
 *
 * @ignore
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Common\Internal
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class ServiceRestProxy extends \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\RestProxy
{
    private $accountName;
    private $psrPrimaryUri;
    private $psrSecondaryUri;
    private $options;
    private $client;
    /**
     * Initializes new ServiceRestProxy object.
     *
     * @param string                    $primaryUri     The storage account
     *                                                  primary uri.
     * @param string                    $secondaryUri   The storage account
     *                                                  secondary uri.
     * @param string                    $accountName    The name of the account.
     * @param array                     $options        Array of options for
     *                                                  the service
     */
    public function __construct($primaryUri, $secondaryUri, $accountName, array $options = [])
    {
        $primaryUri = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::appendDelimiter($primaryUri, '/');
        $secondaryUri = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::appendDelimiter($secondaryUri, '/');
        $dataSerializer = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Serialization\XmlSerializer();
        parent::__construct($dataSerializer);
        $this->accountName = $accountName;
        $this->psrPrimaryUri = new \Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Uri($primaryUri);
        $this->psrSecondaryUri = new \Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Uri($secondaryUri);
        $this->options = \array_merge(array('http' => array()), $options);
        $this->client = self::createClient($this->options['http']);
    }
    /**
     * Create a Guzzle client for future usage.
     *
     * @param  array $options Optional parameters for the client.
     *
     * @return Client
     */
    private static function createClient(array $options)
    {
        $verify = \true;
        //Disable SSL if proxy has been set, and set the proxy in the client.
        $proxy = \getenv('HTTP_PROXY');
        // For testing with Fiddler
        // $proxy = 'localhost:8888';
        // $verify = false;
        if (!empty($proxy)) {
            $options['proxy'] = $proxy;
        }
        if (isset($options['verify'])) {
            $verify = $options['verify'];
        }
        return new \Dekode\GravityForms\Vendor\GuzzleHttp\Client(\array_merge($options, array("defaults" => array("allow_redirects" => \true, "exceptions" => \true, "decode_content" => \true, "config" => ["curl" => [\CURLOPT_SSLVERSION => \CURL_SSLVERSION_TLSv1_2]]), 'cookies' => \true, 'verify' => $verify)));
    }
    /**
     * Gets the account name.
     *
     * @return string
     */
    public function getAccountName()
    {
        return $this->accountName;
    }
    /**
     * Create a middleware stack with given middleware.
     *
     * @param  ServiceOptions  $serviceOptions The options user passed in.
     *
     * @return MiddlewareStack
     */
    protected function createMiddlewareStack(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions $serviceOptions)
    {
        //If handler stack is not defined by the user, create a default
        //middleware stack.
        $stack = null;
        if (\array_key_exists('stack', $this->options['http'])) {
            $stack = $this->options['http']['stack'];
        } elseif ($serviceOptions->getMiddlewareStack() != null) {
            $stack = $serviceOptions->getMiddlewareStack();
        } else {
            $stack = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Middlewares\MiddlewareStack();
        }
        //Push all the middlewares specified in the $serviceOptions to the
        //handlerstack.
        if ($serviceOptions->getMiddlewares() != array()) {
            foreach ($serviceOptions->getMiddlewares() as $middleware) {
                $stack->push($middleware);
            }
        }
        //Push all the middlewares specified in the $options to the
        //handlerstack.
        if (\array_key_exists('middlewares', $this->options)) {
            foreach ($this->options['middlewares'] as $middleware) {
                $stack->push($middleware);
            }
        }
        //Push all the middlewares specified in $this->middlewares to the
        //handlerstack.
        foreach ($this->getMiddlewares() as $middleware) {
            $stack->push($middleware);
        }
        return $stack;
    }
    /**
     * Send the requests concurrently. Number of concurrency can be modified
     * by inserting a new key/value pair with the key 'number_of_concurrency'
     * into the $requestOptions of $serviceOptions. Return only the promise.
     *
     * @param  callable       $generator   the generator function to generate
     *                                     request upon fulfillment
     * @param  int            $statusCode  The expected status code for each of the
     *                                     request generated by generator.
     * @param  ServiceOptions $options     The service options for the concurrent
     *                                     requests.
     *
     * @return \GuzzleHttp\Promise\Promise|\GuzzleHttp\Promise\PromiseInterface
     */
    protected function sendConcurrentAsync(callable $generator, $statusCode, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions $options)
    {
        $client = $this->client;
        $middlewareStack = $this->createMiddlewareStack($options);
        $sendAsync = function ($request, $options) use($client) {
            if ($request->getMethod() == 'HEAD') {
                $options['decode_content'] = \false;
            }
            return $client->sendAsync($request, $options);
        };
        $handler = $middlewareStack->apply($sendAsync);
        $requestOptions = $this->generateRequestOptions($options, $handler);
        $promises = \call_user_func(function () use($generator, $handler, $requestOptions) {
            while (\is_callable($generator) && ($request = $generator())) {
                (yield \call_user_func($handler, $request, $requestOptions));
            }
        });
        $eachPromise = new \Dekode\GravityForms\Vendor\GuzzleHttp\Promise\EachPromise($promises, ['concurrency' => $options->getNumberOfConcurrency(), 'fulfilled' => function ($response, $index) use($statusCode) {
            //the promise is fulfilled, evaluate the response
            self::throwIfError($response, $statusCode);
        }, 'rejected' => function ($reason, $index) {
            //Still rejected even if the retry logic has been applied.
            //Throwing exception.
            throw $reason;
        }]);
        return $eachPromise->promise();
    }
    /**
     * Create the request to be sent.
     *
     * @param  string $method         The method of the HTTP request
     * @param  array  $headers        The header field of the request
     * @param  array  $queryParams    The query parameter of the request
     * @param  array  $postParameters The HTTP POST parameters
     * @param  string $path           URL path
     * @param  string $body           Request body
     *
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function createRequest($method, array $headers, array $queryParams, array $postParameters, $path, $locationMode, $body = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::EMPTY_STRING)
    {
        if ($locationMode == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::SECONDARY_ONLY || $locationMode == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::SECONDARY_THEN_PRIMARY) {
            $uri = $this->psrSecondaryUri;
        } else {
            $uri = $this->psrPrimaryUri;
        }
        //Append the path, not replacing it.
        if ($path != null) {
            $exPath = $uri->getPath();
            if ($exPath != '') {
                //Remove the duplicated slash in the path.
                if ($path != '' && $path[0] == '/') {
                    $path = $exPath . \substr($path, 1);
                } else {
                    $path = $exPath . $path;
                }
            }
            $uri = $uri->withPath($path);
        }
        // add query parameters into headers
        if ($queryParams != null) {
            $queryString = \Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Query::build($queryParams);
            $uri = $uri->withQuery($queryString);
        }
        // add post parameters into bodies
        $actualBody = null;
        if (empty($body)) {
            if (empty($headers[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::CONTENT_TYPE])) {
                $headers[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::CONTENT_TYPE] = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::URL_ENCODED_CONTENT_TYPE;
                $actualBody = \Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Query::build($postParameters);
            }
        } else {
            $actualBody = $body;
        }
        $request = new \Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Request($method, $uri, $headers, $actualBody);
        //add content-length to header
        $bodySize = $request->getBody()->getSize();
        if ($bodySize > 0) {
            $request = $request->withHeader('content-length', $bodySize);
        }
        return $request;
    }
    /**
     * Create promise of sending HTTP request with the specified parameters.
     *
     * @param  string         $method         HTTP method used in the request
     * @param  array          $headers        HTTP headers.
     * @param  array          $queryParams    URL query parameters.
     * @param  array          $postParameters The HTTP POST parameters.
     * @param  string         $path           URL path
     * @param  array|int      $expected       Expected Status Codes.
     * @param  string         $body           Request body
     * @param  ServiceOptions $serviceOptions Service options
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    protected function sendAsync($method, array $headers, array $queryParams, array $postParameters, $path, $expected = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::STATUS_OK, $body = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::EMPTY_STRING, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions $serviceOptions = null)
    {
        if ($serviceOptions == null) {
            $serviceOptions = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::QP_TIMEOUT, $serviceOptions->getTimeout());
        $request = $this->createRequest($method, $headers, $queryParams, $postParameters, $path, $serviceOptions->getLocationMode(), $body);
        $client = $this->client;
        $middlewareStack = $this->createMiddlewareStack($serviceOptions);
        $sendAsync = function ($request, $options) use($client) {
            return $client->sendAsync($request, $options);
        };
        $handler = $middlewareStack->apply($sendAsync);
        $requestOptions = $this->generateRequestOptions($serviceOptions, $handler);
        if ($request->getMethod() == 'HEAD') {
            $requestOptions[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::ROS_DECODE_CONTENT] = \false;
        }
        $promise = \call_user_func($handler, $request, $requestOptions);
        return $promise->then(function ($response) use($expected, $requestOptions) {
            self::throwIfError($response, $expected);
            return self::addLocationHeaderToResponse($response, $requestOptions[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::ROS_LOCATION_MODE]);
        }, function ($reason) use($expected) {
            return $this->onRejected($reason, $expected);
        });
    }
    /**
     * @param  string|\Exception $reason   Rejection reason.
     * @param  array|int         $expected Expected Status Codes.
     *
     * @return ResponseInterface
     */
    protected function onRejected($reason, $expected)
    {
        if (!$reason instanceof \Exception) {
            throw new \RuntimeException($reason);
        }
        if (!$reason instanceof \Dekode\GravityForms\Vendor\GuzzleHttp\Exception\RequestException) {
            throw $reason;
        }
        $response = $reason->getResponse();
        if ($response != null) {
            self::throwIfError($response, $expected);
        } else {
            //if could not get response but promise rejected, throw reason.
            throw $reason;
        }
        return $response;
    }
    /**
     * Generate the request options using the given service options and stored
     * information.
     *
     * @param  ServiceOptions $serviceOptions The service options used to
     *                                        generate request options.
     * @param  callable       $handler        The handler used to send the
     *                                        request.
     * @return array
     */
    protected function generateRequestOptions(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions $serviceOptions, callable $handler)
    {
        $result = array();
        $result[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::ROS_LOCATION_MODE] = $serviceOptions->getLocationMode();
        $result[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::ROS_STREAM] = $serviceOptions->getIsStreaming();
        $result[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::ROS_DECODE_CONTENT] = $serviceOptions->getDecodeContent();
        $result[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::ROS_HANDLER] = $handler;
        $result[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::ROS_SECONDARY_URI] = $this->getPsrSecondaryUri();
        $result[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::ROS_PRIMARY_URI] = $this->getPsrPrimaryUri();
        return $result;
    }
    /**
     * Sends the context.
     *
     * @param  HttpCallContext $context The context of the request.
     * @return \GuzzleHttp\Psr7\Response
     */
    protected function sendContext(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpCallContext $context)
    {
        return $this->sendContextAsync($context)->wait();
    }
    /**
     * Creates the promise to send the context.
     *
     * @param  HttpCallContext $context The context of the request.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    protected function sendContextAsync(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpCallContext $context)
    {
        return $this->sendAsync($context->getMethod(), $context->getHeaders(), $context->getQueryParameters(), $context->getPostParameters(), $context->getPath(), $context->getStatusCodes(), $context->getBody(), $context->getServiceOptions());
    }
    /**
     * Throws ServiceException if the received status code is not expected.
     *
     * @param ResponseInterface $response The response received
     * @param array|int         $expected The expected status codes.
     *
     * @return void
     *
     * @throws ServiceException
     */
    public static function throwIfError(\Dekode\GravityForms\Vendor\Psr\Http\Message\ResponseInterface $response, $expected)
    {
        $expectedStatusCodes = \is_array($expected) ? $expected : array($expected);
        if (!\in_array($response->getStatusCode(), $expectedStatusCodes)) {
            throw new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Exceptions\ServiceException($response);
        }
    }
    /**
     * Adds HTTP POST parameter to the specified
     *
     * @param array  $postParameters An array of HTTP POST parameters.
     * @param string $key            The key of a HTTP POST parameter.
     * @param string $value          the value of a HTTP POST parameter.
     *
     * @return array
     */
    public function addPostParameter(array $postParameters, $key, $value)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isArray($postParameters, 'postParameters');
        $postParameters[$key] = $value;
        return $postParameters;
    }
    /**
     * Groups set of values into one value separated with Resources::SEPARATOR
     *
     * @param array $values array of values to be grouped.
     *
     * @return string
     */
    public static function groupQueryValues(array $values)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isArray($values, 'values');
        $joined = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::EMPTY_STRING;
        \sort($values);
        foreach ($values as $value) {
            if (!\is_null($value) && !empty($value)) {
                $joined .= $value . \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::SEPARATOR;
            }
        }
        return \trim($joined, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::SEPARATOR);
    }
    /**
     * Adds metadata elements to headers array
     *
     * @param array $headers  HTTP request headers
     * @param array $metadata user specified metadata
     *
     * @return array
     */
    protected function addMetadataHeaders(array $headers, array $metadata = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::validateMetadata($metadata);
        $metadata = $this->generateMetadataHeaders($metadata);
        $headers = \array_merge($headers, $metadata);
        return $headers;
    }
    /**
     * Generates metadata headers by prefixing each element with 'x-ms-meta'.
     *
     * @param array $metadata user defined metadata.
     *
     * @return array
     */
    public function generateMetadataHeaders(array $metadata = null)
    {
        $metadataHeaders = array();
        if (\is_array($metadata) && !\is_null($metadata)) {
            foreach ($metadata as $key => $value) {
                $headerName = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::X_MS_META_HEADER_PREFIX;
                if (\strpos($value, "\r") !== \false || \strpos($value, "\n") !== \false) {
                    throw new \InvalidArgumentException(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::INVALID_META_MSG);
                }
                // Metadata name is case-presrved and case insensitive
                $headerName .= $key;
                $metadataHeaders[$headerName] = $value;
            }
        }
        return $metadataHeaders;
    }
    /**
     * Get the primary URI in PSR form.
     *
     * @return Uri
     */
    public function getPsrPrimaryUri()
    {
        return $this->psrPrimaryUri;
    }
    /**
     * Get the secondary URI in PSR form.
     *
     * @return Uri
     */
    public function getPsrSecondaryUri()
    {
        return $this->psrSecondaryUri;
    }
    /**
     * Adds the header that indicates the location mode to the response header.
     *
     * @return  ResponseInterface
     */
    private static function addLocationHeaderToResponse(\Dekode\GravityForms\Vendor\Psr\Http\Message\ResponseInterface $response, $locationMode)
    {
        //If the response already has this header, return itself.
        if ($response->hasHeader(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::X_MS_CONTINUATION_LOCATION_MODE)) {
            return $response;
        }
        //Otherwise, add the header that indicates the endpoint to be used if
        //continuation token is used for subsequent request. Notice that if the
        //response does not have location header set at the moment, it means
        //that the user have not set a retry middleware.
        if ($locationMode == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_THEN_SECONDARY) {
            $response = $response->withHeader(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::X_MS_CONTINUATION_LOCATION_MODE, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        } elseif ($locationMode == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::SECONDARY_THEN_PRIMARY) {
            $response = $response->withHeader(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::X_MS_CONTINUATION_LOCATION_MODE, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::SECONDARY_ONLY);
        } elseif ($locationMode == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::SECONDARY_ONLY || $locationMode == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY) {
            $response = $response->withHeader(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::X_MS_CONTINUATION_LOCATION_MODE, $locationMode);
        }
        return $response;
    }
}
