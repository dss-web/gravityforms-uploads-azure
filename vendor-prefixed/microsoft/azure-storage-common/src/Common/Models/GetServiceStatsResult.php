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
 * @package   MicrosoftAzure\Storage\Common\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2017 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
namespace Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models;

use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities;
/**
 * Result from calling get service stats REST wrapper.
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Common\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2017 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class GetServiceStatsResult
{
    private $status;
    private $lastSyncTime;
    /**
     * Creates object from $parsedResponse.
     *
     * @internal
     * @param array $parsedResponse XML response parsed into array.
     *
     * @return \MicrosoftAzure\Storage\Common\Models\GetServiceStatsResult
     */
    public static function create(array $parsedResponse)
    {
        $result = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\GetServiceStatsResult();
        if (\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::arrayKeyExistsInsensitive(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::XTAG_GEO_REPLICATION, $parsedResponse)) {
            $geoReplication = $parsedResponse[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::XTAG_GEO_REPLICATION];
            if (\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::arrayKeyExistsInsensitive(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::XTAG_STATUS, $geoReplication)) {
                $result->setStatus($geoReplication[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::XTAG_STATUS]);
            }
            if (\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::arrayKeyExistsInsensitive(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::XTAG_LAST_SYNC_TIME, $geoReplication)) {
                $lastSyncTime = $geoReplication[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::XTAG_LAST_SYNC_TIME];
                $result->setLastSyncTime(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::convertToDateTime($lastSyncTime));
            }
        }
        return $result;
    }
    /**
     * Gets status of the result.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * Gets the last sync time.
     * @return \DateTime
     */
    public function getLastSyncTime()
    {
        return $this->lastSyncTime;
    }
    /**
     * Sets status of the result.
     *
     * @return void
     */
    protected function setStatus($status)
    {
        $this->status = $status;
    }
    /**
     * Sets the last sync time.
     *
     * @return void
     */
    protected function setLastSyncTime(\DateTime $lastSyncTime)
    {
        $this->lastSyncTime = $lastSyncTime;
    }
}
