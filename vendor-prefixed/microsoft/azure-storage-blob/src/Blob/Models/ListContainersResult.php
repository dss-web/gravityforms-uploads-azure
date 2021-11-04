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
 * @package   MicrosoftAzure\Storage\Blob\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
namespace Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models;

use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources as Resources;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\MarkerContinuationToken;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\MarkerContinuationTokenTrait;
/**
 * Container to hold list container response object.
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Blob\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class ListContainersResult
{
    use MarkerContinuationTokenTrait;
    private $containers;
    private $prefix;
    private $marker;
    private $maxResults;
    private $accountName;
    /**
     * Creates ListBlobResult object from parsed XML response.
     *
     * @param array  $parsedResponse XML response parsed into array.
     * @param string $location       Contains the location for the previous
     *                               request.
     *
     * @internal
     *
     * @return ListContainersResult
     */
    public static function create(array $parsedResponse, $location = '')
    {
        $result = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListContainersResult();
        $serviceEndpoint = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetKeysChainValue($parsedResponse, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::XTAG_ATTRIBUTES, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::XTAG_SERVICE_ENDPOINT);
        $result->setAccountName(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryParseAccountNameFromUrl($serviceEndpoint));
        $result->setPrefix(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($parsedResponse, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_PREFIX));
        $result->setMarker(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($parsedResponse, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_MARKER));
        $nextMarker = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($parsedResponse, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_NEXT_MARKER);
        if ($nextMarker != null) {
            $result->setContinuationToken(new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\MarkerContinuationToken($nextMarker, $location));
        }
        $result->setMaxResults(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($parsedResponse, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_MAX_RESULTS));
        $containers = array();
        $rawContainer = array();
        if (!empty($parsedResponse['Containers'])) {
            $containersArray = $parsedResponse['Containers']['Container'];
            $rawContainer = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::getArray($containersArray);
        }
        foreach ($rawContainer as $value) {
            $container = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\Container();
            $container->setName($value['Name']);
            $container->setUrl($serviceEndpoint . $value['Name']);
            $container->setMetadata(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($value, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_METADATA, array()));
            $properties = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ContainerProperties();
            $date = $value['Properties']['Last-Modified'];
            $date = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::rfc1123ToDateTime($date);
            $properties->setLastModified($date);
            $properties->setETag(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValueInsensitive(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::ETAG, $value['Properties']));
            if (\array_key_exists('LeaseStatus', $value['Properties'])) {
                $properties->setLeaseStatus($value['Properties']['LeaseStatus']);
            }
            if (\array_key_exists('LeaseState', $value['Properties'])) {
                $properties->setLeaseStatus($value['Properties']['LeaseState']);
            }
            if (\array_key_exists('LeaseDuration', $value['Properties'])) {
                $properties->setLeaseStatus($value['Properties']['LeaseDuration']);
            }
            if (\array_key_exists('PublicAccess', $value['Properties'])) {
                $properties->setPublicAccess($value['Properties']['PublicAccess']);
            }
            $container->setProperties($properties);
            $containers[] = $container;
        }
        $result->setContainers($containers);
        return $result;
    }
    /**
     * Sets containers.
     *
     * @param array $containers list of containers.
     *
     * @return void
     */
    protected function setContainers(array $containers)
    {
        $this->containers = array();
        foreach ($containers as $container) {
            $this->containers[] = clone $container;
        }
    }
    /**
     * Gets containers.
     *
     * @return Container[]
     */
    public function getContainers()
    {
        return $this->containers;
    }
    /**
     * Gets prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }
    /**
     * Sets prefix.
     *
     * @param string $prefix value.
     *
     * @return void
     */
    protected function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }
    /**
     * Gets marker.
     *
     * @return string
     */
    public function getMarker()
    {
        return $this->marker;
    }
    /**
     * Sets marker.
     *
     * @param string $marker value.
     *
     * @return void
     */
    protected function setMarker($marker)
    {
        $this->marker = $marker;
    }
    /**
     * Gets max results.
     *
     * @return string
     */
    public function getMaxResults()
    {
        return $this->maxResults;
    }
    /**
     * Sets max results.
     *
     * @param string $maxResults value.
     *
     * @return void
     */
    protected function setMaxResults($maxResults)
    {
        $this->maxResults = $maxResults;
    }
    /**
     * Gets account name.
     *
     * @return string
     */
    public function getAccountName()
    {
        return $this->accountName;
    }
    /**
     * Sets account name.
     *
     * @param string $accountName value.
     *
     * @return void
     */
    protected function setAccountName($accountName)
    {
        $this->accountName = $accountName;
    }
}
