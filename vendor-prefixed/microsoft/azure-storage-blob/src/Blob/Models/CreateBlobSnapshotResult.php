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
/**
 * The result of creating Blob snapshot.
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Blob\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class CreateBlobSnapshotResult
{
    private $_snapshot;
    private $_etag;
    private $_lastModified;
    /**
     * Creates CreateBlobSnapshotResult object from the response of the
     * create Blob snapshot request.
     *
     * @param array $headers The HTTP response headers in array representation.
     *
     * @internal
     *
     * @return CreateBlobSnapshotResult
     */
    public static function create(array $headers)
    {
        $result = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobSnapshotResult();
        $headerWithLowerCaseKey = \array_change_key_case($headers);
        $result->setETag($headerWithLowerCaseKey[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::ETAG]);
        $result->setLastModified(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::rfc1123ToDateTime($headerWithLowerCaseKey[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::LAST_MODIFIED]));
        $result->setSnapshot($headerWithLowerCaseKey[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_SNAPSHOT]);
        return $result;
    }
    /**
     * Gets snapshot.
     *
     * @return string
     */
    public function getSnapshot()
    {
        return $this->_snapshot;
    }
    /**
     * Sets snapshot.
     *
     * @param string $snapshot value.
     *
     * @return void
     */
    protected function setSnapshot($snapshot)
    {
        $this->_snapshot = $snapshot;
    }
    /**
     * Gets ETag.
     *
     * @return string
     */
    public function getETag()
    {
        return $this->_etag;
    }
    /**
     * Sets ETag.
     *
     * @param string $etag value.
     *
     * @return void
     */
    protected function setETag($etag)
    {
        $this->_etag = $etag;
    }
    /**
     * Gets blob lastModified.
     *
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->_lastModified;
    }
    /**
     * Sets blob lastModified.
     *
     * @param \DateTime $lastModified value.
     *
     * @return void
     */
    protected function setLastModified($lastModified)
    {
        $this->_lastModified = $lastModified;
    }
}
