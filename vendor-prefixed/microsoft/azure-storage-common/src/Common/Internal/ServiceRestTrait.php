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
 * @ignore
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Common\Internal
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2017 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
namespace Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal;

use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceProperties;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\GetServicePropertiesResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\GetServiceStatsResult;
/**
 * Trait implementing common REST API for all the services, including the
 * following:
 * Get/Set Service Properties
 * Get service stats
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Common\Internal
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2017 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
trait ServiceRestTrait
{
    /**
     * Gets the properties of the service.
     *
     * @param ServiceOptions $options The optional parameters.
     *
     * @return \MicrosoftAzure\Storage\Common\Models\GetServicePropertiesResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/hh452239.aspx
     */
    public function getServiceProperties(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions $options = null)
    {
        return $this->getServicePropertiesAsync($options)->wait();
    }
    /**
     * Creates promise to get the properties of the service.
     *
     * @param ServiceOptions $options The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/hh452239.aspx
     */
    public function getServicePropertiesAsync(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions $options = null)
    {
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::HTTP_GET;
        $headers = array();
        $queryParams = array();
        $postParams = array();
        $path = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::EMPTY_STRING;
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::QP_REST_TYPE, 'service');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::QP_COMP, 'properties');
        $dataSerializer = $this->dataSerializer;
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::EMPTY_STRING, $options)->then(function ($response) use($dataSerializer) {
            $parsed = $dataSerializer->unserialize($response->getBody());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\GetServicePropertiesResult::create($parsed);
        }, null);
    }
    /**
     * Sets the properties of the service.
     *
     * It's recommended to use getServiceProperties, alter the returned object and
     * then use setServiceProperties with this altered object.
     *
     * @param ServiceProperties $serviceProperties The service properties.
     * @param ServiceOptions    $options           The optional parameters.
     *
     * @return void
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/hh452235.aspx
     */
    public function setServiceProperties(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceProperties $serviceProperties, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions $options = null)
    {
        $this->setServicePropertiesAsync($serviceProperties, $options)->wait();
    }
    /**
     * Creates the promise to set the properties of the service.
     *
     * It's recommended to use getServiceProperties, alter the returned object and
     * then use setServiceProperties with this altered object.
     *
     * @param ServiceProperties $serviceProperties The service properties.
     * @param ServiceOptions    $options           The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/hh452235.aspx
     */
    public function setServicePropertiesAsync(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceProperties $serviceProperties, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isTrue($serviceProperties instanceof \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceProperties, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::INVALID_SVC_PROP_MSG);
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::HTTP_PUT;
        $headers = array();
        $queryParams = array();
        $postParams = array();
        $path = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::EMPTY_STRING;
        $body = $serviceProperties->toXml($this->dataSerializer);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::QP_REST_TYPE, 'service');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::QP_COMP, 'properties');
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::CONTENT_TYPE, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::URL_ENCODED_CONTENT_TYPE);
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::STATUS_ACCEPTED, $body, $options);
    }
    /**
     * Retrieves statistics related to replication for the service. The operation
     * will only be sent to secondary location endpoint.
     *
     * @param  ServiceOptions|null $options The options this operation sends with.
     *
     * @return GetServiceStatsResult
     */
    public function getServiceStats(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions $options = null)
    {
        return $this->getServiceStatsAsync($options)->wait();
    }
    /**
     * Creates promise that retrieves statistics related to replication for the
     * service. The operation will only be sent to secondary location endpoint.
     *
     * @param  ServiceOptions|null $options The options this operation sends with.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getServiceStatsAsync(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions $options = null)
    {
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::HTTP_GET;
        $headers = array();
        $queryParams = array();
        $postParams = array();
        $path = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::EMPTY_STRING;
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::QP_REST_TYPE, 'service');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::QP_COMP, 'stats');
        $dataSerializer = $this->dataSerializer;
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::SECONDARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::EMPTY_STRING, $options)->then(function ($response) use($dataSerializer) {
            $parsed = $dataSerializer->unserialize($response->getBody());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\GetServiceStatsResult::create($parsed);
        }, null);
    }
}
