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

use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources as Resources;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range;
/**
 * Holds result of calling listPageBlobRanges wrapper
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Blob\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class ListPageBlobRangesResult
{
    private $_lastModified;
    private $_etag;
    private $_contentLength;
    private $_pageRanges;
    /**
     * Creates BlobProperties object from $parsed response in array representation
     *
     * @param array $headers HTTP response headers
     * @param array $parsed  parsed response in array format.
     *
     * @internal
     *
     * @return ListPageBlobRangesResult
     */
    public static function create(array $headers, array $parsed = null)
    {
        $result = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesResult();
        $headers = \array_change_key_case($headers);
        $date = $headers[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::LAST_MODIFIED];
        $date = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::rfc1123ToDateTime($date);
        $blobLength = \intval($headers[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONTENT_LENGTH]);
        $rawRanges = array();
        if (!empty($parsed[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::XTAG_PAGE_RANGE])) {
            $parsed = \array_change_key_case($parsed);
            $rawRanges = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::getArray($parsed[\strtolower(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::XTAG_PAGE_RANGE)]);
        }
        $pageRanges = array();
        foreach ($rawRanges as $value) {
            $pageRanges[] = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range(\intval($value[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::XTAG_RANGE_START]), \intval($value[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::XTAG_RANGE_END]));
        }
        $result->setRanges($pageRanges);
        $result->setContentLength($blobLength);
        $result->setETag($headers[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::ETAG]);
        $result->setLastModified($date);
        return $result;
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
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isDate($lastModified);
        $this->_lastModified = $lastModified;
    }
    /**
     * Gets blob etag.
     *
     * @return string
     */
    public function getETag()
    {
        return $this->_etag;
    }
    /**
     * Sets blob etag.
     *
     * @param string $etag value.
     *
     * @return void
     */
    protected function setETag($etag)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($etag, 'etag');
        $this->_etag = $etag;
    }
    /**
     * Gets blob contentLength.
     *
     * @return integer
     */
    public function getContentLength()
    {
        return $this->_contentLength;
    }
    /**
     * Sets blob contentLength.
     *
     * @param integer $contentLength value.
     *
     * @return void
     */
    protected function setContentLength($contentLength)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isInteger($contentLength, 'contentLength');
        $this->_contentLength = $contentLength;
    }
    /**
     * Gets page ranges
     *
     * @return array
     */
    public function getRanges()
    {
        return $this->_pageRanges;
    }
    /**
     * Sets page ranges
     *
     * @param array $pageRanges page ranges to set
     *
     * @return void
     */
    protected function setRanges(array $pageRanges)
    {
        $this->_pageRanges = array();
        foreach ($pageRanges as $pageRange) {
            $this->_pageRanges[] = clone $pageRange;
        }
    }
}
