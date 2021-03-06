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

use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources as Resources;
/**
 * File service options.
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\File\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2017 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class FileServiceOptions extends \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions
{
    public function setLocationMode($locationMode)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($locationMode, 'locationMode');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isTrue($locationMode == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::FILE_LOCATION_IS_PRIMARY_ONLY);
        $this->locationMode = $locationMode;
    }
}
