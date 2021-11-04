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
 * The result of calling copyBlob API.
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Blob\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class CopyBlobResult
{
    private $_etag;
    private $_lastModified;
    private $_copyId;
    private $_copyStatus;
    /**
     * Creates CopyBlobResult object from the response of the copy blob request.
     *
     * @param array $headers The HTTP response headers in array representation.
     *
     * @internal
     *
     * @return CopyBlobResult
     */
    public static function create(array $headers)
    {
        $result = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CopyBlobResult();
        $result->setETag(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValueInsensitive(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::ETAG, $headers));
        $result->setCopyId(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValueInsensitive(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_COPY_ID, $headers));
        $result->setCopyStatus(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValueInsensitive(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_COPY_STATUS, $headers));
        if (\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::arrayKeyExistsInsensitive(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::LAST_MODIFIED, $headers)) {
            $lastModified = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValueInsensitive(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::LAST_MODIFIED, $headers);
            $result->setLastModified(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::rfc1123ToDateTime($lastModified));
        }
        return $result;
    }
    /**
     * Gets copy Id
     *
     * @return string
     */
    public function getCopyId()
    {
        return $this->_copyId;
    }
    /**
     * Sets copy Id
     *
     * @param string $copyId the blob copy id.
     *
     * @internal
     *
     * @return void
     */
    protected function setCopyId($copyId)
    {
        $this->_copyId = $copyId;
    }
    /**
     * Gets copy status
     *
     * @return string
     */
    public function getCopyStatus()
    {
        return $this->_copyStatus;
    }
    /**
     * Sets copy status
     *
     * @param string $status the copy status.
     *
     * @internal
     *
     * @return void
     */
    protected function setCopyStatus($copystatus)
    {
        $this->_copyStatus = $copystatus;
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
    protected function setLastModified(\DateTime $lastModified)
    {
        $this->_lastModified = $lastModified;
    }
}
