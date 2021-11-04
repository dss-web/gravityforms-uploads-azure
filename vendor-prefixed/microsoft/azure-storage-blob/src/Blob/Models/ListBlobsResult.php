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
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\MarkerContinuationTokenTrait;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\MarkerContinuationToken;
/**
 * Hold result of calliing listBlobs wrapper.
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Blob\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class ListBlobsResult
{
    use MarkerContinuationTokenTrait;
    private $blobPrefixes;
    private $blobs;
    private $delimiter;
    private $prefix;
    private $marker;
    private $maxResults;
    private $containerName;
    /**
     * Creates ListBlobsResult object from parsed XML response.
     *
     * @param array  $parsed      XML response parsed into array.
     * @param string $location       Contains the location for the previous
     *                               request.
     *
     * @internal
     *
     * @return ListBlobsResult
     */
    public static function create(array $parsed, $location = '')
    {
        $result = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListBlobsResult();
        $serviceEndpoint = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetKeysChainValue($parsed, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::XTAG_ATTRIBUTES, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::XTAG_SERVICE_ENDPOINT);
        $containerName = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetKeysChainValue($parsed, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::XTAG_ATTRIBUTES, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::XTAG_CONTAINER_NAME);
        $result->setContainerName($containerName);
        $result->setPrefix(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($parsed, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_PREFIX));
        $result->setMarker(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($parsed, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_MARKER));
        $nextMarker = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($parsed, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_NEXT_MARKER);
        if ($nextMarker != null) {
            $result->setContinuationToken(new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\MarkerContinuationToken($nextMarker, $location));
        }
        $result->setMaxResults(\intval(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($parsed, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_MAX_RESULTS, 0)));
        $result->setDelimiter(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($parsed, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_DELIMITER));
        $blobs = array();
        $blobPrefixes = array();
        $rawBlobs = array();
        $rawBlobPrefixes = array();
        if (\is_array($parsed['Blobs']) && \array_key_exists('Blob', $parsed['Blobs'])) {
            $rawBlobs = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::getArray($parsed['Blobs']['Blob']);
        }
        foreach ($rawBlobs as $value) {
            $blob = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\Blob();
            $blob->setName($value['Name']);
            $blob->setUrl($serviceEndpoint . $containerName . '/' . $value['Name']);
            $blob->setSnapshot(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($value, 'Snapshot'));
            $blob->setProperties(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobProperties::createFromXml(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($value, 'Properties')));
            $blob->setMetadata(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($value, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_METADATA, array()));
            $blobs[] = $blob;
        }
        if (\is_array($parsed['Blobs']) && \array_key_exists('BlobPrefix', $parsed['Blobs'])) {
            $rawBlobPrefixes = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::getArray($parsed['Blobs']['BlobPrefix']);
        }
        foreach ($rawBlobPrefixes as $value) {
            $blobPrefix = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobPrefix();
            $blobPrefix->setName($value['Name']);
            $blobPrefixes[] = $blobPrefix;
        }
        $result->setBlobs($blobs);
        $result->setBlobPrefixes($blobPrefixes);
        return $result;
    }
    /**
     * Gets blobs.
     *
     * @return Blob[]
     */
    public function getBlobs()
    {
        return $this->blobs;
    }
    /**
     * Sets blobs.
     *
     * @param Blob[] $blobs list of blobs
     *
     * @return void
     */
    protected function setBlobs(array $blobs)
    {
        $this->blobs = array();
        foreach ($blobs as $blob) {
            $this->blobs[] = clone $blob;
        }
    }
    /**
     * Gets blobPrefixes.
     *
     * @return array
     */
    public function getBlobPrefixes()
    {
        return $this->blobPrefixes;
    }
    /**
     * Sets blobPrefixes.
     *
     * @param array $blobPrefixes list of blobPrefixes
     *
     * @return void
     */
    protected function setBlobPrefixes(array $blobPrefixes)
    {
        $this->blobPrefixes = array();
        foreach ($blobPrefixes as $blob) {
            $this->blobPrefixes[] = clone $blob;
        }
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
     * Gets prefix.
     *
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }
    /**
     * Sets prefix.
     *
     * @param string $delimiter value.
     *
     * @return void
     */
    protected function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
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
     * @return integer
     */
    public function getMaxResults()
    {
        return $this->maxResults;
    }
    /**
     * Sets max results.
     *
     * @param integer $maxResults value.
     *
     * @return void
     */
    protected function setMaxResults($maxResults)
    {
        $this->maxResults = $maxResults;
    }
    /**
     * Gets container name.
     *
     * @return string
     */
    public function getContainerName()
    {
        return $this->containerName;
    }
    /**
     * Sets container name.
     *
     * @param string $containerName value.
     *
     * @return void
     */
    protected function setContainerName($containerName)
    {
        $this->containerName = $containerName;
    }
}
