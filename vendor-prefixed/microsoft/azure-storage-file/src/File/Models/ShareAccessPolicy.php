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

use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\AccessPolicy;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources;
/**
 * Holds access policy elements
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\File\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2017 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class ShareAccessPolicy extends \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\AccessPolicy
{
    /**
     * Get the valid permissions for the given resource.
     *
     * @return array
     */
    public static function getResourceValidPermissions()
    {
        return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::ACCESS_PERMISSIONS[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::RESOURCE_TYPE_SHARE];
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::RESOURCE_TYPE_SHARE);
    }
}
