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

use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\ACLBase;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources as Resources;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate;
/**
 * Holds container ACL members.
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Blob\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class ContainerACL extends \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\ACLBase
{
    private $publicAccess;
    /**
     * Constructor.
     */
    public function __construct()
    {
        //setting the resource type to a default value.
        $this->setResourceType(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::RESOURCE_TYPE_CONTAINER);
    }
    /**
     * Parses the given array into signed identifiers and create an instance of
     * ContainerACL
     *
     * @param string $publicAccess The container public access.
     * @param array  $parsed       The parsed response into array representation.
     *
     * @internal
     *
     * @return ContainerACL
     */
    public static function create($publicAccess, array $parsed = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isTrue(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\PublicAccessType::isValid($publicAccess), \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::INVALID_BLOB_PAT_MSG);
        $result = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ContainerACL();
        $result->fromXmlArray($parsed);
        $result->setPublicAccess($publicAccess);
        return $result;
    }
    /**
     * Gets container publicAccess.
     *
     * @return string
     */
    public function getPublicAccess()
    {
        return $this->publicAccess;
    }
    /**
     * Sets container publicAccess.
     *
     * @param string $publicAccess value.
     *
     * @return void
     */
    public function setPublicAccess($publicAccess)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isTrue(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\PublicAccessType::isValid($publicAccess), \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::INVALID_BLOB_PAT_MSG);
        $this->publicAccess = $publicAccess;
        $this->setResourceType(self::getResourceTypeByPublicAccess($publicAccess));
    }
    /**
     * Gets the resource type according to the given public access. Default
     * value is Resources::RESOURCE_TYPE_CONTAINER.
     *
     * @param  string $publicAccess The public access that determines the
     *                              resource type.
     *
     * @return string
     */
    private static function getResourceTypeByPublicAccess($publicAccess)
    {
        $result = '';
        switch ($publicAccess) {
            case \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\PublicAccessType::BLOBS_ONLY:
                $result = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::RESOURCE_TYPE_BLOB;
                break;
            case \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\PublicAccessType::CONTAINER_AND_BLOBS:
                $result = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::RESOURCE_TYPE_CONTAINER;
                break;
            default:
                $result = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::RESOURCE_TYPE_CONTAINER;
                break;
        }
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
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isTrue($resourceType == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::RESOURCE_TYPE_BLOB || $resourceType == \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::RESOURCE_TYPE_CONTAINER, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::INVALID_RESOURCE_TYPE);
    }
    /**
     * Create a ContainerAccessPolicy object.
     *
     * @return ContainerAccessPolicy
     */
    protected static function createAccessPolicy()
    {
        return new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ContainerAccessPolicy();
    }
}
