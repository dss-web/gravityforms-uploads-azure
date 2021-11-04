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
 * @package   MicrosoftAzure\Storage\Common\Middlewares
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2017 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
namespace Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Middlewares;

use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities;
use Dekode\GravityForms\Vendor\Psr\Http\Message\RequestInterface;
use Dekode\GravityForms\Vendor\Psr\Http\Message\ResponseInterface;
use Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Uri;
use Dekode\GravityForms\Vendor\GuzzleHttp\Promise\RejectedPromise;
/**
 * This class provides the functionality of a middleware that handles all the
 * retry logic for the request.
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Common\Middlewares
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2017 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class RetryMiddleware extends \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Middlewares\MiddlewareBase
{
    private $intervalCalculator;
    private $decider;
    public function __construct(callable $intervalCalculator, callable $decider)
    {
        $this->intervalCalculator = $intervalCalculator;
        $this->decider = $decider;
    }
    /**
     * This function will be invoked after the request is sent, if
     * the promise is fulfilled.
     *
     * @param  RequestInterface $request the request sent.
     * @param  array            $options the options that the request sent with.
     *
     * @return callable
     */
    protected function onFulfilled(\Dekode\GravityForms\Vendor\Psr\Http\Message\RequestInterface $request, array $options)
    {
        return function (\Dekode\GravityForms\Vendor\Psr\Http\Message\ResponseInterface $response) use($request, $options) {
            $isSecondary = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::requestSentToSecondary($request, $options);
            if (!isset($options['retries'])) {
                $options['retries'] = 0;
            }
            if (\call_user_func($this->decider, $options['retries'], $request, $response, null, $isSecondary)) {
                return $this->retry($request, $options, $response);
            }
            //Add the header that indicates the endpoint to be used if
            //continuation token is used for subsequent request.
            if ($isSecondary) {
                $response = $response->withHeader(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::X_MS_CONTINUATION_LOCATION_MODE, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::SECONDARY_ONLY);
            } else {
                $response = $response->withHeader(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::X_MS_CONTINUATION_LOCATION_MODE, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
            }
            return $response;
        };
    }
    /**
     * This function will be executed after the request is sent, if
     * the promise is rejected.
     *
     * @param  RequestInterface $request the request sent.
     * @param  array            $options the options that the request sent with.
     *
     * @return callable
     */
    protected function onRejected(\Dekode\GravityForms\Vendor\Psr\Http\Message\RequestInterface $request, array $options)
    {
        return function ($reason) use($request, $options) {
            $isSecondary = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::requestSentToSecondary($request, $options);
            if (!isset($options['retries'])) {
                $options['retries'] = 0;
            }
            if (\call_user_func($this->decider, $options['retries'], $request, null, $reason, $isSecondary)) {
                return $this->retry($request, $options);
            }
            return new \Dekode\GravityForms\Vendor\GuzzleHttp\Promise\RejectedPromise($reason);
        };
    }
    /**
     * This function does the real retry job.
     *
     * @param  RequestInterface  $request  the request sent.
     * @param  array             $options  the options that the request sent with.
     * @param  ResponseInterface $response the response of the request
     *
     * @return callable
     */
    private function retry(\Dekode\GravityForms\Vendor\Psr\Http\Message\RequestInterface $request, array $options, \Dekode\GravityForms\Vendor\Psr\Http\Message\ResponseInterface $response = null)
    {
        $options['delay'] = \call_user_func($this->intervalCalculator, ++$options['retries']);
        //Change the request URI according to the location mode.
        if (\array_key_exists(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::ROS_LOCATION_MODE, $options)) {
            $locationMode = $options[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::ROS_LOCATION_MODE];
            //If have RA-GRS enabled for the request, switch between
            //primary and secondary.
            if ($locationMode == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_THEN_SECONDARY || $locationMode == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::SECONDARY_THEN_PRIMARY) {
                $primaryUri = $options[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::ROS_PRIMARY_URI];
                $secondaryUri = $options[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::ROS_SECONDARY_URI];
                $target = $request->getRequestTarget();
                if (\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::startsWith($target, '/')) {
                    $target = \substr($target, 1);
                    $primaryUri = new \Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Uri($primaryUri . $target);
                    $secondaryUri = new \Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Uri($secondaryUri . $target);
                }
                //substitute the uri.
                if ((string) $request->getUri() == (string) $primaryUri) {
                    $request = $request->withUri($secondaryUri);
                } elseif ((string) $request->getUri() == (string) $secondaryUri) {
                    $request = $request->withUri($primaryUri);
                }
            }
        }
        $handler = $options[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::ROS_HANDLER];
        return \call_user_func($handler, $request, $options);
    }
}
