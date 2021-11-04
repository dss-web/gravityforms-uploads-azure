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
 * @package   MicrosoftAzure\Storage\File\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2017 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
namespace Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models;

use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\MarkerContinuationToken;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\MarkerContinuationTokenTrait;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources as Resources;
/**
 * Share to hold list Share response object.
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\File\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2017 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class ListSharesResult
{
    use MarkerContinuationTokenTrait;
    private $shares;
    private $prefix;
    private $marker;
    private $maxResults;
    private $accountName;
    /**
     * Creates ListSharesResult object from parsed XML response.
     *
     * @param array  $parsedResponse XML response parsed into array.
     * @param string $location       Contains the location for the previous
     *                               request.
     *
     * @internal
     *
     * @return ListSharesResult
     */
    public static function create(array $parsedResponse, $location = '')
    {
        $result = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ListSharesResult();
        $serviceEndpoint = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetKeysChainValue($parsedResponse, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::XTAG_ATTRIBUTES, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::XTAG_SERVICE_ENDPOINT);
        $result->setAccountName(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryParseAccountNameFromUrl($serviceEndpoint));
        $result->setPrefix(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($parsedResponse, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_PREFIX));
        $result->setMarker(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($parsedResponse, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_MARKER));
        $nextMarker = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($parsedResponse, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_NEXT_MARKER);
        if ($nextMarker != null) {
            $result->setContinuationToken(new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\MarkerContinuationToken($nextMarker, $location));
        }
        $result->setMaxResults(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($parsedResponse, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_MAX_RESULTS));
        $shares = array();
        $shareArrays = array();
        if (!empty($parsedResponse[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_SHARES])) {
            $array = $parsedResponse[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_SHARES][\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_SHARE];
            $shareArrays = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::getArray($array);
        }
        foreach ($shareArrays as $shareArray) {
            $shares[] = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\Share::create($shareArray);
        }
        $result->setShares($shares);
        return $result;
    }
    /**
     * Sets shares.
     *
     * @param array $shares list of shares.
     *
     * @return void
     */
    protected function setShares(array $shares)
    {
        $this->shares = array();
        foreach ($shares as $share) {
            $this->shares[] = clone $share;
        }
    }
    /**
     * Gets shares.
     *
     * @return Share[]
     */
    public function getShares()
    {
        return $this->shares;
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
