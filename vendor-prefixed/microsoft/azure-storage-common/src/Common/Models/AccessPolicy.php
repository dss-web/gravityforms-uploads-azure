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
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
namespace Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models;

use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources;
/**
 * Holds access policy elements
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Common\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
abstract class AccessPolicy
{
    private $start;
    private $expiry;
    private $permission;
    private $resourceType;
    /**
     * Get the valid permissions for the given resource.
     *
     * @return array
     */
    protected static abstract function getResourceValidPermissions();
    /**
     * Constructor
     *
     * @param string $resourceType the resource type of this access policy.
     */
    public function __construct($resourceType)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($resourceType, 'resourceType');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isTrue($resourceType == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::RESOURCE_TYPE_BLOB || $resourceType == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::RESOURCE_TYPE_CONTAINER || $resourceType == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::RESOURCE_TYPE_QUEUE || $resourceType == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::RESOURCE_TYPE_TABLE || $resourceType == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::RESOURCE_TYPE_FILE || $resourceType == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::RESOURCE_TYPE_SHARE, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::ERROR_RESOURCE_TYPE_NOT_SUPPORTED);
        $this->resourceType = $resourceType;
    }
    /**
     * Gets start.
     *
     * @return \DateTime.
     */
    public function getStart()
    {
        return $this->start;
    }
    /**
     * Sets start.
     *
     * @param \DateTime $start value.
     *
     * @return void
     */
    public function setStart(\DateTime $start = null)
    {
        if ($start != null) {
            \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isDate($start);
        }
        $this->start = $start;
    }
    /**
     * Gets expiry.
     *
     * @return \DateTime.
     */
    public function getExpiry()
    {
        return $this->expiry;
    }
    /**
     * Sets expiry.
     *
     * @param \DateTime $expiry value.
     *
     * @return void
     */
    public function setExpiry($expiry)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isDate($expiry);
        $this->expiry = $expiry;
    }
    /**
     * Gets permission.
     *
     * @return string.
     */
    public function getPermission()
    {
        return $this->permission;
    }
    /**
     * Sets permission.
     *
     * @param string $permission value.
     *
     * @throws \InvalidArgumentException
     *
     * @return void
     */
    public function setPermission($permission)
    {
        $this->permission = $this->validatePermission($permission);
    }
    /**
     * Gets resource type.
     *
     * @return string.
     */
    public function getResourceType()
    {
        return $this->resourceType;
    }
    /**
     * Validate the permission against its corresponding allowed permissions
     *
     * @param  string $permission The permission to be validated.
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    private function validatePermission($permission)
    {
        $validPermissions = static::getResourceValidPermissions();
        $result = '';
        foreach ($validPermissions as $validPermission) {
            if (\strpos($permission, $validPermission) !== \false) {
                //append the valid permission to result.
                $result .= $validPermission;
                //remove all the character that represents the permission.
                $permission = \str_replace($validPermission, '', $permission);
            }
        }
        //After filtering all the permissions, if there is still characters
        //left in the given permission, throw exception.
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isTrue($permission == '', \sprintf(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::INVALID_PERMISSION_PROVIDED, $this->getResourceType(), \implode(', ', $validPermissions)));
        return $result;
    }
    /**
     * Converts this current object to XML representation.
     *
     * @internal
     *
     * @return array
     */
    public function toArray()
    {
        $array = array();
        if ($this->getStart() != null) {
            $array[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::XTAG_SIGNED_START] = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::convertToEdmDateTime($this->getStart());
        }
        $array[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::XTAG_SIGNED_EXPIRY] = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::convertToEdmDateTime($this->getExpiry());
        $array[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Resources::XTAG_SIGNED_PERMISSION] = $this->getPermission();
        return $array;
    }
}
