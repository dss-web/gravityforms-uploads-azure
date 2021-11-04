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

use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\ACLBase;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources as Resources;
/**
 * Holds share ACL members.
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\File\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2017 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class ShareACL extends \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\ACLBase
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        //setting the resource type to a default value.
        $this->setResourceType(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::RESOURCE_TYPE_SHARE);
    }
    /**
     * Parses the given array into signed identifiers and create an instance of
     * ShareACL
     *
     * @param array  $parsed       The parsed response into array representation.
     *
     * @internal
     *
     * @return ShareACL
     */
    public static function create(array $parsed = null)
    {
        $result = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ShareACL();
        $result->fromXmlArray($parsed);
        return $result;
    }
    /**
     * Validate if the resource type is for the class.
     *
     * @param  string $resourceType the resource type to be validated.
     *
     * @throws \InvalidArgumentException
     *
     * @internal
     *
     * @return void
     */
    protected static function validateResourceType($resourceType)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isTrue($resourceType == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::RESOURCE_TYPE_SHARE || $resourceType == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::RESOURCE_TYPE_FILE, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::INVALID_RESOURCE_TYPE);
    }
    /**
     * Create a ShareAccessPolicy object.
     *
     * @return ShareAccessPolicy
     */
    protected static function createAccessPolicy()
    {
        return new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ShareAccessPolicy();
    }
}
