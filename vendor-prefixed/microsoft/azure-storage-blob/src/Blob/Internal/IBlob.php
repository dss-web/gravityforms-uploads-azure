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
 * @package   MicrosoftAzure\Storage\Blob\Internal
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
namespace Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal;

use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models as BlobModels;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceProperties;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range;
use Dekode\GravityForms\Vendor\Psr\Http\Message\StreamInterface;
/**
 * This interface has all REST APIs provided by Windows Azure for Blob service.
 *
 * @ignore
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Blob\Internal
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 * @see       http://msdn.microsoft.com/en-us/library/windowsazure/dd135733.aspx
 */
interface IBlob
{
    /**
     * Gets the properties of the service.
     *
     * @param ServiceOptions $options optional service options.
     *
     * @return GetServicePropertiesResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/hh452239.aspx
     */
    public function getServiceProperties(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions $options = null);
    /**
     * Creates promise to get the properties of the service.
     *
     * @param ServiceOptions $options The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/hh452239.aspx
     */
    public function getServicePropertiesAsync(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions $options = null);
    /**
     * Sets the properties of the service.
     *
     * @param ServiceProperties           $serviceProperties new service properties
     * @param ServiceOptions $options           optional parameters
     *
     * @return void
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/hh452235.aspx
     */
    public function setServiceProperties(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceProperties $serviceProperties, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions $options = null);
    /**
     * Retieves statistics related to replication for the service. The operation
     * will only be sent to secondary location endpoint.
     *
     * @param  ServiceOptions|null $options The options this operation sends with.
     *
     * @return GetServiceStatsResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-blob-service-stats
     */
    public function getServiceStats(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions $options = null);
    /**
     * Creates promise that retrieves statistics related to replication for the
     * service. The operation will only be sent to secondary location endpoint.
     *
     * @param  ServiceOptions|null $options The options this operation sends with.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see  https://docs.microsoft.com/en-us/rest/api/storageservices/get-blob-service-stats
     */
    public function getServiceStatsAsync(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions $options = null);
    /**
     * Creates the promise to set the properties of the service.
     *
     * It's recommended to use getServiceProperties, alter the returned object and
     * then use setServiceProperties with this altered object.
     *
     * @param ServiceProperties           $serviceProperties new service properties.
     * @param ServiceOptions $options           optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/hh452235.aspx
     */
    public function setServicePropertiesAsync(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceProperties $serviceProperties, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\ServiceOptions $options = null);
    /**
     * Lists all of the containers in the given storage account.
     *
     * @param BlobModels\ListContainersOptions $options optional parameters
     *
     * @return BlobModels\ListContainersResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179352.aspx
     */
    public function listContainers(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListContainersOptions $options = null);
    /**
     * Create a promise for lists all of the containers in the given
     * storage account.
     *
     * @param  BlobModels\ListContainersOptions $options The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function listContainersAsync(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListContainersOptions $options = null);
    /**
     * Creates a new container in the given storage account.
     *
     * @param string                            $container name
     * @param BlobModels\CreateContainerOptions $options   optional parameters
     *
     * @return void
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179468.aspx
     */
    public function createContainer($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions $options = null);
    /**
     * Creates a new container in the given storage account.
     *
     * @param string                            $container The container name.
     * @param BlobModels\CreateContainerOptions $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179468.aspx
     */
    public function createContainerAsync($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions $options = null);
    /**
     * Creates a new container in the given storage account.
     *
     * @param string                            $container name
     * @param BlobModels\BlobServiceOptions     $options   optional parameters
     *
     * @return void
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179408.aspx
     */
    public function deleteContainer($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Create a promise for deleting a container.
     *
     * @param  string                             $container name of the container
     * @param  BlobModels\BlobServiceOptions      $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function deleteContainerAsync($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Returns all properties and metadata on the container.
     *
     * @param string                        $container name
     * @param BlobModels\BlobServiceOptions $options   optional parameters
     *
     * @return BlobModels\GetContainerPropertiesResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179370.aspx
     */
    public function getContainerProperties($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Create promise to return all properties and metadata on the container.
     *
     * @param string                        $container name
     * @param BlobModels\BlobServiceOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179370.aspx
     */
    public function getContainerPropertiesAsync($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Returns only user-defined metadata for the specified container.
     *
     * @param string                        $container name
     * @param BlobModels\BlobServiceOptions $options   optional parameters
     *
     * @return BlobModels\GetContainerPropertiesResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691976.aspx
     */
    public function getContainerMetadata($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Create promise to return only user-defined metadata for the specified
     * container.
     *
     * @param string                        $container name
     * @param BlobModels\BlobServiceOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691976.aspx
     */
    public function getContainerMetadataAsync($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Gets the access control list (ACL) and any container-level access policies
     * for the container.
     *
     * @param string                        $container name
     * @param BlobModels\BlobServiceOptions $options   optional parameters
     *
     * @return BlobModels\GetContainerACLResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179469.aspx
     */
    public function getContainerAcl($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Creates the promise to get the access control list (ACL) and any
     * container-level access policies for the container.
     *
     * @param string                        $container The container name.
     * @param BlobModels\BlobServiceOptions $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179469.aspx
     */
    public function getContainerAclAsync($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Sets the ACL and any container-level access policies for the container.
     *
     * @param string                        $container name
     * @param BlobModels\ContainerACL       $acl       access control list for container
     * @param BlobModels\BlobServiceOptions $options   optional parameters
     *
     * @return void
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179391.aspx
     */
    public function setContainerAcl($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ContainerACL $acl, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Creates promise to set the ACL and any container-level access policies
     * for the container.
     *
     * @param string                        $container name
     * @param BlobModels\ContainerACL       $acl       access control list for container
     * @param BlobModels\BlobServiceOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179391.aspx
     */
    public function setContainerAclAsync($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ContainerACL $acl, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Sets metadata headers on the container.
     *
     * @param string                        $container name
     * @param array                         $metadata  metadata key/value pair.
     * @param BlobModels\BlobServiceOptions $options   optional parameters
     *
     * @return void
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179362.aspx
     */
    public function setContainerMetadata($container, array $metadata, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Sets metadata headers on the container.
     *
     * @param string                        $container name
     * @param array                         $metadata  metadata key/value pair.
     * @param BlobModels\BlobServiceOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179362.aspx
     */
    public function setContainerMetadataAsync($container, array $metadata, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Lists all of the blobs in the given container.
     *
     * @param string                      $container name
     * @param BlobModels\ListBlobsOptions $options   optional parameters
     *
     * @return BlobModels\ListBlobsResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd135734.aspx
     */
    public function listBlobs($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions $options = null);
    /**
     * Creates promise to list all of the blobs in the given container.
     *
     * @param string                      $container The container name.
     * @param BlobModels\ListBlobsOptions $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd135734.aspx
     */
    public function listBlobsAsync($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions $options = null);
    /**
     * Creates a new page blob. Note that calling createPageBlob to create a page
     * blob only initializes the blob.
     * To add content to a page blob, call createBlobPages method.
     *
     * @param string                       $container name of the container
     * @param string                       $blob      name of the blob
     * @param int                          $length    specifies the maximum size
     * for the page blob, up to 1 TB. The page blob size must be aligned to
     * a 512-byte boundary.
     * @param BlobModels\CreatePageBlobOptions $options   optional parameters
     *
     * @return BlobModels\PutBlobResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179451.aspx
     */
    public function createPageBlob($container, $blob, $length, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreatePageBlobOptions $options = null);
    /**
     * Creates promise to create a new page blob. Note that calling
     * createPageBlob to create a page blob only initializes the blob.
     * To add content to a page blob, call createBlobPages method.
     *
     * @param string                       $container The container name.
     * @param string                       $blob      The blob name.
     * @param integer                      $length    Specifies the maximum size
     *                                                for the page blob, up to
     *                                                1 TB. The page blob size
     *                                                must be aligned to a
     *                                                512-byte boundary.
     * @param BlobModels\CreatePageBlobOptions $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179451.aspx
     */
    public function createPageBlobAsync($container, $blob, $length, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreatePageBlobOptions $options = null);
    /**
     * Create a new append blob.
     * If the blob already exists on the service, it will be overwritten.
     *
     * @param string                   $container The container name.
     * @param string                   $blob      The blob name.
     * @param BlobModels\CreateBlobOptions $options   The optional parameters.
     *
     * @return BlobModels\PutBlobResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179451.aspx
     */
    public function createAppendBlob($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobOptions $options = null);
    /**
     * Creates promise to create a new append blob.
     * If the blob already exists on the service, it will be overwritten.
     *
     * @param string                   $container The container name.
     * @param string                   $blob      The blob name.
     * @param BlobModels\CreateBlobOptions $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179451.aspx
     */
    public function createAppendBlobAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobOptions $options = null);
    /**
     * Creates a new block blob or updates the content of an existing block blob.
     * Updating an existing block blob overwrites any existing metadata on the blob.
     * Partial updates are not supported with createBlockBlob; the content of the
     * existing blob is overwritten with the content of the new blob. To perform a
     * partial update of the content of a block blob, use the createBlockList method.
     *
     * @param string                            $container name of the container
     * @param string                            $blob      name of the blob
     * @param string|resource|StreamInterface   $content   content of the blob
     * @param BlobModels\CreateBlockBlobOptions $options   optional parameters
     *
     * @return BlobModels\PutBlobResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179451.aspx
     */
    public function createBlockBlob($container, $blob, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions $options = null);
    /**
     * Creates a promise to create a new block blob or updates the content of
     * an existing block blob.
     *
     * Updating an existing block blob overwrites any existing metadata on the blob.
     * Partial updates are not supported with createBlockBlob the content of the
     * existing blob is overwritten with the content of the new blob. To perform a
     * partial update of the content of a block blob, use the createBlockList
     * method.
     *
     * @param string                             $container The name of the container.
     * @param string                             $blob      The name of the blob.
     * @param string|resource|StreamInterface    $content   The content of the blob.
     * @param BlobModels\CreateBlockBlobOptions  $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179451.aspx
     */
    public function createBlockBlobAsync($container, $blob, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions $options = null);
    /**
     * Create a new page blob and upload the content to the page blob.
     *
     * @param string                          $container The name of the container.
     * @param string                          $blob      The name of the blob.
     * @param int                             $length    The length of the blob.
     * @param string|resource|StreamInterface $content   The content of the blob.
     * @param BlobModels\CreatePageBlobFromContentOptions
     *                                        $options   The optional parameters.
     *
     * @return BlobModels\GetBlobPropertiesResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/get-blob-properties
     */
    public function createPageBlobFromContent($container, $blob, $length, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreatePageBlobFromContentOptions $options = null);
    /**
     * Creates a promise to create a new page blob and upload the content
     * to the page blob.
     *
     * @param string                          $container The name of the container.
     * @param string                          $blob      The name of the blob.
     * @param int                             $length    The length of the blob.
     * @param string|resource|StreamInterface $content   The content of the blob.
     * @param BlobModels\CreatePageBlobFromContentOptions
     *                                        $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/get-blob-properties
     */
    public function createPageBlobFromContentAsync($container, $blob, $length, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreatePageBlobFromContentOptions $options = null);
    /**
     * Clears a range of pages from the blob.
     *
     * @param string                            $container name of the container
     * @param string                            $blob      name of the blob
     * @param Range                             $range     Can be up to the value
     * of the blob's full size.
     * @param BlobModels\CreateBlobPagesOptions $options   optional parameters
     *
     * @return BlobModels\CreateBlobPagesResult.
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691975.aspx
     */
    public function clearBlobPages($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range $range, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobPagesOptions $options = null);
    /**
     * Creates promise to clear a range of pages from the blob.
     *
     * @param string                            $container name of the container
     * @param string                            $blob      name of the blob
     * @param Range                             $range     Can be up to the value
     *                                                     of the blob's full size.
     *                                                     Note that ranges must be
     *                                                     aligned to 512 (0-511,
     *                                                     512-1023)
     * @param BlobModels\CreateBlobPagesOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691975.aspx
     */
    public function clearBlobPagesAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range $range, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobPagesOptions $options = null);
    /**
     * Creates a range of pages to a page blob.
     *
     * @param string                            $container name of the container
     * @param string                            $blob      name of the blob
     * @param Range                             $range     Can be up to 4 MB in size
     * @param string                            $content   the blob contents
     * @param BlobModels\CreateBlobPagesOptions $options   optional parameters
     *
     * @return BlobModels\CreateBlobPagesResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691975.aspx
     */
    public function createBlobPages($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range $range, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobPagesOptions $options = null);
    /**
     * Creates promise to create a range of pages to a page blob.
     *
     * @param string                            $container name of the container
     * @param string                            $blob      name of the blob
     * @param Range                             $range     Can be up to 4 MB in
     *                                                     size. Note that ranges
     *                                                     must be aligned to 512
     *                                                     (0-511, 512-1023)
     * @param string|resource|StreamInterface   $content   the blob contents.
     * @param BlobModels\CreateBlobPagesOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691975.aspx
     */
    public function createBlobPagesAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range $range, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobPagesOptions $options = null);
    /**
     * Creates a new block to be committed as part of a block blob.
     *
     * @param string                            $container name of the container
     * @param string                            $blob      name of the blob
     * @param string                            $blockId   must be less than or equal to
     * 64 bytes in size. For a given blob, the length of the value specified for the
     * blockid parameter must be the same size for each block.
     * @param string                            $content   the blob block contents
     * @param BlobModels\CreateBlobBlockOptions $options   optional parameters
     *
     * @return void
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd135726.aspx
     */
    public function createBlobBlock($container, $blob, $blockId, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobBlockOptions $options = null);
    /**
     * Creates a new block to be committed as part of a block blob.
     *
     * @param string                              $container name of the container
     * @param string                              $blob      name of the blob
     * @param string                              $blockId   must be less than or
     *                                                       equal to 64 bytes in
     *                                                       size. For a given
     *                                                       blob, the length of
     *                                                       the value specified
     *                                                       for the blockid
     *                                                       parameter must
     *                                                       be the same size for
     *                                                       each block.
     * @param resource|string|StreamInterface     $content   the blob block contents
     * @param BlobModels\CreateBlobBlockOptions   $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd135726.aspx
     */
    public function createBlobBlockAsync($container, $blob, $blockId, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobBlockOptions $options = null);
    /**
     * Commits a new block of data to the end of an existing append blob.
     *
     * @param string                          $container name of the container
     * @param string                          $blob      name of the blob
     * @param resource|string|StreamInterface $content   the blob block contents
     * @param BlobModels\AppendBlockOptions   $options   optional parameters
     *
     * @return BlobModels\AppendBlockResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/append-block
     */
    public function appendBlock($container, $blob, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\AppendBlockOptions $options = null);
    /**
     * Creates promise to commit a new block of data to the end of an existing append blob.
     *
     * @param string                          $container name of the container
     * @param string                          $blob      name of the blob
     * @param resource|string|StreamInterface $content   the blob block contents
     * @param BlobModels\AppendBlockOptions   $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/append-block
     */
    public function appendBlockAsync($container, $blob, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\AppendBlockOptions $options = null);
    /**
     * This method writes a blob by specifying the list of block IDs that make up the
     * blob. In order to be written as part of a blob, a block must have been
     * successfully written to the server in a prior createBlobBlock method.
     *
     * You can call Put Block List to update a blob by uploading only those blocks
     * that have changed, then committing the new and existing blocks together.
     * You can do this by specifying whether to commit a block from the committed
     * block list or from the uncommitted block list, or to commit the most recently
     * uploaded version of the block, whichever list it may belong to.
     *
     * @param string                                  $container name of the container
     * @param string                                  $blob      name of the blob
     * @param BlobModels\BlockList|BlobModels\Block[] $blockList the block list entries
     * @param BlobModels\CommitBlobBlocksOptions      $options   optional parameters
     *
     * @return BlobModels\PutBlobResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179467.aspx
     */
    public function commitBlobBlocks($container, $blob, $blockList, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CommitBlobBlocksOptions $options = null);
    /**
     * This method writes a blob by specifying the list of block IDs that make up the
     * blob. In order to be written as part of a blob, a block must have been
     * successfully written to the server in a prior createBlobBlock method.
     *
     * You can call Put Block List to update a blob by uploading only those blocks
     * that have changed, then committing the new and existing blocks together.
     * You can do this by specifying whether to commit a block from the committed
     * block list or from the uncommitted block list, or to commit the most recently
     * uploaded version of the block, whichever list it may belong to.
     *
     * @param string                                  $container name of the container
     * @param string                                  $blob      name of the blob
     * @param BlobModels\BlockList|BlobModels\Block[] $blockList the block list
     *                                                           entries
     * @param BlobModels\CommitBlobBlocksOptions      $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179467.aspx
     */
    public function commitBlobBlocksAsync($container, $blob, $blockList, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CommitBlobBlocksOptions $options = null);
    /**
     * Retrieves the list of blocks that have been uploaded as part of a block blob.
     *
     * There are two block lists maintained for a blob:
     * 1) Committed Block List: The list of blocks that have been successfully
     *    committed to a given blob with commitBlobBlocks.
     * 2) Uncommitted Block List: The list of blocks that have been uploaded for a
     *    blob using Put Block (REST API), but that have not yet been committed.
     *    These blocks are stored in Windows Azure in association with a blob, but do
     *    not yet form part of the blob.
     *
     * @param string                           $container name of the container
     * @param string                           $blob      name of the blob
     * @param BlobModels\ListBlobBlocksOptions $options   optional parameters
     *
     * @return BlobModels\ListBlobBlocksResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179400.aspx
     */
    public function listBlobBlocks($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksOptions $options = null);
    /**
     * Creates promise to retrieve the list of blocks that have been uploaded as
     * part of a block blob.
     *
     * There are two block lists maintained for a blob:
     * 1) Committed Block List: The list of blocks that have been successfully
     *    committed to a given blob with commitBlobBlocks.
     * 2) Uncommitted Block List: The list of blocks that have been uploaded for a
     *    blob using Put Block (REST API), but that have not yet been committed.
     *    These blocks are stored in Windows Azure in association with a blob, but do
     *    not yet form part of the blob.
     *
     * @param string                           $container name of the container
     * @param string                           $blob      name of the blob
     * @param BlobModels\ListBlobBlocksOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179400.aspx
     */
    public function listBlobBlocksAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksOptions $options = null);
    /**
     * Returns all properties and metadata on the blob.
     *
     * @param string                              $container name of the container
     * @param string                              $blob      name of the blob
     * @param BlobModels\GetBlobPropertiesOptions $options   optional parameters
     *
     * @return BlobModels\GetBlobPropertiesResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179394.aspx
     */
    public function getBlobProperties($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobPropertiesOptions $options = null);
    /**
     * Creates promise to return all properties and metadata on the blob.
     *
     * @param string                              $container name of the container
     * @param string                              $blob      name of the blob
     * @param BlobModels\GetBlobPropertiesOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179394.aspx
     */
    public function getBlobPropertiesAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobPropertiesOptions $options = null);
    /**
     * Returns all properties and metadata on the blob.
     *
     * @param string                            $container name of the container
     * @param string                            $blob      name of the blob
     * @param BlobModels\GetBlobMetadataOptions $options   optional parameters
     *
     * @return BlobModels\GetBlobMetadataResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179350.aspx
     */
    public function getBlobMetadata($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobMetadataOptions $options = null);
    /**
     * Creates promise to return all properties and metadata on the blob.
     *
     * @param string                            $container name of the container
     * @param string                            $blob      name of the blob
     * @param BlobModels\GetBlobMetadataOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179350.aspx
     */
    public function getBlobMetadataAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobMetadataOptions $options = null);
    /**
     * Returns a list of active page ranges for a page blob. Active page ranges are
     * those that have been populated with data.
     *
     * @param string                               $container name of the container
     * @param string                               $blob      name of the blob
     * @param BlobModels\ListPageBlobRangesOptions $options   optional parameters
     *
     * @return BlobModels\ListPageBlobRangesResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691973.aspx
     */
    public function listPageBlobRanges($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesOptions $options = null);
    /**
     * Creates promise to return a list of active page ranges for a page blob.
     * Active page ranges are those that have been populated with data.
     *
     * @param string                               $container name of the
     *                                                        container
     * @param string                               $blob      name of the blob
     * @param BlobModels\ListPageBlobRangesOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691973.aspx
     */
    public function listPageBlobRangesAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesOptions $options = null);
    /**
     * Returns a list of page ranges that have been updated or cleared.
     *
     * Returns a list of page ranges that have been updated or cleared since
     * the snapshot specified by `previousSnapshotTime`. Gets all of the page
     * ranges by default, or only the page ranges over a specific range of
     * bytes if `rangeStart` and `rangeEnd` in the `options` are specified.
     *
     * @param string                               $container             name of the container
     * @param string                               $blob                  name of the blob
     * @param string                               $previousSnapshotTime  previous snapshot time
     *                                                                    for comparison which
     *                                                                    should be prior to the
     *                                                                    snapshot time defined
     *                                                                    in `options`
     * @param BlobModels\ListPageBlobRangesOptions $options               optional parameters
     *
     * @return BlobModels\ListPageBlobRangesDiffResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/version-2015-07-08
     */
    public function listPageBlobRangesDiff($container, $blob, $previousSnapshotTime, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesOptions $options = null);
    /**
     * Creates promise to return a list of page ranges that have been updated
     * or cleared.
     *
     * Creates promise to return a list of page ranges that have been updated
     * or cleared since the snapshot specified by `previousSnapshotTime`. Gets
     * all of the page ranges by default, or only the page ranges over a specific
     * range of bytes if `rangeStart` and `rangeEnd` in the `options` are specified.
     *
     * @param string                               $container               name of the container
     * @param string                               $blob                    name of the blob
     * @param string                               $previousSnapshotTime    previous snapshot time
     *                                                                      for comparison which
     *                                                                      should be prior to the
     *                                                                      snapshot time defined
     *                                                                      in `options`
     * @param BlobModels\ListPageBlobRangesOptions $options                 optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691973.aspx
     */
    public function listPageBlobRangesDiffAsync($container, $blob, $previousSnapshotTime, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesOptions $options = null);
    /**
     * Sets blob tier on the blob.
     *
     * @param string                        $container name
     * @param string                        $blob      name of the blob
     * @param BlobModels\SetBlobTierOptions $options   optional parameters
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/set-blob-tier
     */
    public function setBlobTier($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\SetBlobTierOptions $options = null);
    /**
     * Sets blob tier on the blob.
     *
     * @param string                        $container name
     * @param string                        $blob      name of the blob
     * @param BlobModels\SetBlobTierOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/set-blob-tier
     */
    public function setBlobTierAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\SetBlobTierOptions $options = null);
    /**
     * Sets system properties defined for a blob.
     *
     * @param string                              $container name of the container
     * @param string                              $blob      name of the blob
     * @param BlobModels\SetBlobPropertiesOptions $options   optional parameters
     *
     * @return BlobModels\SetBlobPropertiesResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691966.aspx
     */
    public function setBlobProperties($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\SetBlobPropertiesOptions $options = null);
    /**
     * Creates promise to set system properties defined for a blob.
     *
     * @param string                              $container name of the container
     * @param string                              $blob      name of the blob
     * @param BlobModels\SetBlobPropertiesOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691966.aspx
     */
    public function setBlobPropertiesAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\SetBlobPropertiesOptions $options = null);
    /**
     * Sets metadata headers on the blob.
     *
     * @param string                         $container name of the container
     * @param string                         $blob      name of the blob
     * @param array                          $metadata  key/value pair representation
     * @param BlobModels\BlobServiceOptions  $options   optional parameters
     *
     * @return BlobModels\SetBlobMetadataResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179414.aspx
     */
    public function setBlobMetadata($container, $blob, array $metadata, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Creates promise to set metadata headers on the blob.
     *
     * @param string                            $container name of the container
     * @param string                            $blob      name of the blob
     * @param array                             $metadata  key/value pair representation
     * @param BlobModels\BlobServiceOptions     $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179414.aspx
     */
    public function setBlobMetadataAsync($container, $blob, array $metadata, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Downloads a blob to a file, the result contains its metadata and
     * properties. The result will not contain a stream pointing to the
     * content of the file.
     *
     * @param string                    $path      The path and name of the file
     * @param string                    $container name of the container
     * @param string                    $blob      name of the blob
     * @param BlobModels\GetBlobOptions $options   optional parameters
     *
     * @return BlobModels\GetBlobResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179440.aspx
     */
    public function saveBlobToFile($path, $container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobOptions $options = null);
    /**
     * Creates promise to download a blob to a file, the result contains its
     * metadata and properties. The result will not contain a stream pointing
     * to the content of the file.
     *
     * @param string                    $path      The path and name of the file
     * @param string                    $container name of the container
     * @param string                    $blob      name of the blob
     * @param BlobModels\GetBlobOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     * @throws \Exception
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179440.aspx
     */
    public function saveBlobToFileAsync($path, $container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobOptions $options = null);
    /**
     * Undeletes a blob.
     *
     * @param string                          $container name of the container
     * @param string                          $blob      name of the blob
     * @param BlobModels\UndeleteBlobOptions  $options   optional parameters
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/undelete-blob
     */
    public function undeleteBlob($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\UndeleteBlobOptions $options = null);
    /**
     * Undeletes a blob.
     *
     * @param string                          $container name of the container
     * @param string                          $blob      name of the blob
     * @param BlobModels\UndeleteBlobOptions  $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/undelete-blob
     */
    public function undeleteBlobAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\UndeleteBlobOptions $options = null);
    /**
     * Reads or downloads a blob from the system, including its metadata and
     * properties.
     *
     * @param string                    $container name of the container
     * @param string                    $blob      name of the blob
     * @param BlobModels\GetBlobOptions $options   optional parameters
     *
     * @return BlobModels\GetBlobResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179440.aspx
     */
    public function getBlob($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobOptions $options = null);
    /**
     * Creates promise to read or download a blob from the system, including its
     * metadata and properties.
     *
     * @param string                    $container name of the container
     * @param string                    $blob      name of the blob
     * @param BlobModels\GetBlobOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179440.aspx
     */
    public function getBlobAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobOptions $options = null);
    /**
     * Deletes a blob or blob snapshot.
     *
     * Note that if the snapshot entry is specified in the $options then only this
     * blob snapshot is deleted. To delete all blob snapshots, do not set Snapshot
     * and just set getDeleteSnaphotsOnly to true.
     *
     * @param string                       $container name of the container
     * @param string                       $blob      name of the blob
     * @param BlobModels\DeleteBlobOptions $options   optional parameters
     *
     * @return void
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179413.aspx
     */
    public function deleteBlob($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\DeleteBlobOptions $options = null);
    /**
     * Creates promise to delete a blob or blob snapshot.
     *
     * Note that if the snapshot entry is specified in the $options then only this
     * blob snapshot is deleted. To delete all blob snapshots, do not set Snapshot
     * and just set getDeleteSnaphotsOnly to true.
     *
     * @param string                       $container name of the container
     * @param string                       $blob      name of the blob
     * @param BlobModels\DeleteBlobOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179413.aspx
     */
    public function deleteBlobAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\DeleteBlobOptions $options = null);
    /**
     * Creates a snapshot of a blob.
     *
     * @param string                               $container name of the container
     * @param string                               $blob      name of the blob
     * @param BlobModels\CreateBlobSnapshotOptions $options   optional parameters
     *
     * @return BlobModels\CreateBlobSnapshotResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691971.aspx
     */
    public function createBlobSnapshot($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobSnapshotOptions $options = null);
    /**
     * Creates promise to create a snapshot of a blob.
     *
     * @param string                               $container The name of the
     *                                                        container.
     * @param string                               $blob      The name of the
     *                                                        blob.
     * @param BlobModels\CreateBlobSnapshotOptions $options   The optional
     *                                                        parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691971.aspx
     */
    public function createBlobSnapshotAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobSnapshotOptions $options = null);
    /**
     * Copies a source blob to a destination blob within the same storage account.
     *
     * @param string                     $destinationContainer name of container
     * @param string                     $destinationBlob      name of blob
     * @param string                     $sourceContainer      name of container
     * @param string                     $sourceBlob           name of blob
     * @param BlobModels\CopyBlobOptions $options              optional parameters
     *
     * @return BlobModels\CopyBlobResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd894037.aspx
     */
    public function copyBlob($destinationContainer, $destinationBlob, $sourceContainer, $sourceBlob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CopyBlobOptions $options = null);
    /**
     * Creates promise to copy a source blob to a destination blob within the
     * same storage account.
     *
     * @param string                     $destinationContainer name of the
     *                                                         destination
     *                                                         container
     * @param string                     $destinationBlob      name of the
     *                                                         destination blob
     * @param string                     $sourceContainer      name of the source
     *                                                         container
     * @param string                     $sourceBlob           name of the source
     *                                                         blob
     * @param BlobModels\CopyBlobOptions $options              optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd894037.aspx
     */
    public function copyBlobAsync($destinationContainer, $destinationBlob, $sourceContainer, $sourceBlob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CopyBlobOptions $options = null);
    /**
     * Copies from a source URL to a destination blob.
     *
     * @param string                            $destinationContainer name of the
     *                                                                destination
     *                                                                container
     * @param string                            $destinationBlob      name of the
     *                                                                destination
     *                                                                blob
     * @param string                            $sourceURL            URL of the
     *                                                                source
     *                                                                resource
     * @param BlobModels\CopyBlobFromURLOptions $options              optional
     *                                                                parameters
     *
     * @return BlobModels\CopyBlobResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd894037.aspx
     */
    public function copyBlobFromURL($destinationContainer, $destinationBlob, $sourceURL, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CopyBlobFromURLOptions $options = null);
    /**
     * Creates promise to copy from source URL to a destination blob.
     *
     * @param string                            $destinationContainer name of the
     *                                                                destination
     *                                                                container
     * @param string                            $destinationBlob      name of the
     *                                                                destination
     *                                                                blob
     * @param string                            $sourceURL            URL of the
     *                                                                source
     *                                                                resource
     * @param BlobModels\CopyBlobFromURLOptions $options              optional
     *                                                                parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd894037.aspx
     */
    public function copyBlobFromURLAsync($destinationContainer, $destinationBlob, $sourceURL, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CopyBlobFromURLOptions $options = null);
    /**
     * Abort a blob copy operation
     *
     * @param string                        $container            name of the container
     * @param string                        $blob                 name of the blob
     * @param string                        $copyId               copy operation identifier.
     * @param BlobModels\BlobServiceOptions $options              optional parameters
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/abort-copy-blob
     */
    public function abortCopy($container, $blob, $copyId, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Creates promise to abort a blob copy operation
     *
     * @param string                        $container            name of the container
     * @param string                        $blob                 name of the blob
     * @param string                        $copyId               copy operation identifier.
     * @param BlobModels\BlobServiceOptions $options              optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/abort-copy-blob
     */
    public function abortCopyAsync($container, $blob, $copyId, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Establishes an exclusive write lock on a blob. To write to a locked
     * blob, a client must provide a lease ID.
     *
     * @param string                     $container         name of the container
     * @param string                     $blob              name of the blob
     * @param string                     $proposedLeaseId   lease id when acquiring
     * @param int                        $leaseDuration     the lease duration. A non-infinite
     *                                                      lease can be between 15 and 60 seconds.
     *                                                      Default is never to expire.
     * @param BlobModels\BlobServiceOptions  $options       optional parameters
     *
     * @return BlobModels\LeaseResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691972.aspx
     */
    public function acquireLease($container, $blob, $proposedLeaseId = null, $leaseDuration = null, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Creates promise to establish an exclusive one-minute write lock on a blob.
     * To write to a locked blob, a client must provide a lease ID.
     *
     * @param string                     $container         name of the container
     * @param string                     $blob              name of the blob
     * @param string                     $proposedLeaseId   lease id when acquiring
     * @param int                        $leaseDuration     the lease duration. A non-infinite
     *                                                      lease can be between 15 and 60 seconds.
     *                                                      Default is never to expire.
     * @param BlobModels\BlobServiceOptions  $options       optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691972.aspx
     */
    public function acquireLeaseAsync($container, $blob, $proposedLeaseId = null, $leaseDuration = null, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * change an existing lease
     *
     * @param string                        $container         name of the container
     * @param string                        $blob              name of the blob
     * @param string                        $leaseId           lease id when acquiring
     * @param string                        $proposedLeaseId   lease id when acquiring
     * @param BlobModels\BlobServiceOptions $options           optional parameters
     *
     * @return BlobModels\LeaseResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/lease-blob
     */
    public function changeLease($container, $blob, $leaseId, $proposedLeaseId, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Creates promise to change an existing lease
     *
     * @param string                        $container         name of the container
     * @param string                        $blob              name of the blob
     * @param string                        $leaseId           lease id when acquiring
     * @param string                        $proposedLeaseId   the proposed lease id
     * @param BlobModels\BlobServiceOptions $options           optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/lease-blob
     */
    public function changeLeaseAsync($container, $blob, $leaseId, $proposedLeaseId, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Renews an existing lease
     *
     * @param string                        $container name of the container
     * @param string                        $blob      name of the blob
     * @param string                        $leaseId   lease id when acquiring
     * @param BlobModels\BlobServiceOptions $options   optional parameters
     *
     * @return BlobModels\AcquireLeaseResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691972.aspx
     */
    public function renewLease($container, $blob, $leaseId, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Creates promise to renew an existing lease
     *
     * @param string                        $container name of the container
     * @param string                        $blob      name of the blob
     * @param string                        $leaseId   lease id when acquiring
     * @param BlobModels\BlobServiceOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691972.aspx
     */
    public function renewLeaseAsync($container, $blob, $leaseId, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Frees the lease if it is no longer needed so that another client may
     * immediately acquire a lease against the blob.
     *
     * @param string                        $container name of the container
     * @param string                        $blob      name of the blob
     * @param string                        $leaseId   lease id when acquiring
     * @param BlobModels\BlobServiceOptions $options   optional parameters
     *
     * @return void
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691972.aspx
     */
    public function releaseLease($container, $blob, $leaseId, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Creates promise to free the lease if it is no longer needed so that
     * another client may immediately acquire a lease against the blob.
     *
     * @param string                        $container name of the container
     * @param string                        $blob      name of the blob
     * @param string                        $leaseId   lease id when acquiring
     * @param BlobModels\BlobServiceOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691972.aspx
     */
    public function releaseLeaseAsync($container, $blob, $leaseId, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Ends the lease but ensure that another client cannot acquire a new lease until
     * the current lease period has expired.
     *
     * @param string                        $container name of the container
     * @param string                        $blob      name of the blob
     * @param BlobModels\BlobServiceOptions $options   optional parameters
     *
     * @return void
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691972.aspx
     */
    public function breakLease($container, $blob, $breakPeriod = null, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
    /**
     * Creates promise to end the lease but ensure that another client cannot
     * acquire a new lease until the current lease period has expired.
     *
     * @param string                        $container name of the container
     * @param string                        $blob      name of the blob
     * @param BlobModels\BlobServiceOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691972.aspx
     */
    public function breakLeaseAsync($container, $blob, $breakPeriod = null, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null);
}
