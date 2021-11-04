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
 * @package   MicrosoftAzure\Storage\Blob
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
namespace Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob;

use Dekode\GravityForms\Vendor\GuzzleHttp\Psr7;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\IBlob;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources as Resources;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\AppendBlockOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\AppendBlockResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobType;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\Block;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlockList;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BreakLeaseResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CommitBlobBlocksOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CopyBlobFromURLOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CopyBlobOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CopyBlobResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobBlockOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobPagesOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobPagesResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobSnapshotOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobSnapshotResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreatePageBlobOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\UndeleteBlobOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\DeleteBlobOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobMetadataOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobMetadataResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobPropertiesOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobPropertiesResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetContainerACLResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetContainerPropertiesResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseMode;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListBlobsResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListContainersOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListContainersResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesDiffResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\PageWriteOption;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\PutBlobResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\PutBlockResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\SetBlobMetadataResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\SetBlobPropertiesOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\SetBlobPropertiesResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\SetBlobTierOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Authentication\SharedAccessSignatureAuthScheme;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Authentication\SharedKeyAuthScheme;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Authentication\TokenAuthScheme;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Middlewares\CommonRequestMiddleware;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Serialization\XmlSerializer;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\ServiceRestProxy;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\ServiceRestTrait;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\StorageServiceSettings;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\SharedAccessSignatureHelper;
use Dekode\GravityForms\Vendor\Psr\Http\Message\StreamInterface;
use Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Utils;
/**
 * This class constructs HTTP requests and receive HTTP responses for blob
 * service layer.
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Blob
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class BlobRestProxy extends \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\ServiceRestProxy implements \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\IBlob
{
    use ServiceRestTrait;
    private $singleBlobUploadThresholdInBytes = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::MB_IN_BYTES_32;
    private $blockSize = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::MB_IN_BYTES_4;
    /**
     * Builds a blob service object, it accepts the following
     * options:
     *
     * - http: (array) the underlying guzzle options. refer to
     *   http://docs.guzzlephp.org/en/latest/request-options.html for detailed available options
     * - middlewares: (mixed) the middleware should be either an instance of a sub-class that
     *   implements {@see MicrosoftAzure\Storage\Common\Middlewares\IMiddleware}, or a
     *   `callable` that follows the Guzzle middleware implementation convention
     *
     * Please refer to
     *   https://azure.microsoft.com/en-us/documentation/articles/storage-configure-connection-string
     * for how to construct a connection string with storage account name/key, or with a shared
     * access signature (SAS Token).
     *
     * @param string $connectionString The configuration connection string.
     * @param array  $options          Array of options to pass to the service
     * @return BlobRestProxy
     */
    public static function createBlobService($connectionString, array $options = [])
    {
        $settings = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\StorageServiceSettings::createFromConnectionString($connectionString);
        $primaryUri = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryAddUrlScheme($settings->getBlobEndpointUri());
        $secondaryUri = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryAddUrlScheme($settings->getBlobSecondaryEndpointUri());
        $blobWrapper = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\BlobRestProxy($primaryUri, $secondaryUri, $settings->getName(), $options);
        // Getting authentication scheme
        if ($settings->hasSasToken()) {
            $authScheme = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Authentication\SharedAccessSignatureAuthScheme($settings->getSasToken());
        } else {
            $authScheme = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Authentication\SharedKeyAuthScheme($settings->getName(), $settings->getKey());
        }
        // Adding common request middleware
        $commonRequestMiddleware = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Middlewares\CommonRequestMiddleware($authScheme, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STORAGE_API_LATEST_VERSION, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::BLOB_SDK_VERSION);
        $blobWrapper->pushMiddleware($commonRequestMiddleware);
        return $blobWrapper;
    }
    /**
     * Builds a blob service object, it accepts the following
     * options:
     *
     * - http: (array) the underlying guzzle options. refer to
     *   http://docs.guzzlephp.org/en/latest/request-options.html for detailed available options
     * - middlewares: (mixed) the middleware should be either an instance of a sub-class that
     *   implements {@see MicrosoftAzure\Storage\Common\Middlewares\IMiddleware}, or a
     *   `callable` that follows the Guzzle middleware implementation convention
     *
     * Please refer to
     * https://docs.microsoft.com/en-us/azure/storage/common/storage-auth-aad
     * for authenticate access to Azure blobs and queues using Azure Active Directory.
     *
     * @param string $token            The bearer token passed as reference.
     * @param string $connectionString The configuration connection string.
     * @param array  $options          Array of options to pass to the service
     *
     * @return BlobRestProxy
     */
    public static function createBlobServiceWithTokenCredential(&$token, $connectionString, array $options = [])
    {
        $settings = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\StorageServiceSettings::createFromConnectionStringForTokenCredential($connectionString);
        $primaryUri = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryAddUrlScheme($settings->getBlobEndpointUri());
        $secondaryUri = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryAddUrlScheme($settings->getBlobSecondaryEndpointUri());
        $blobWrapper = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\BlobRestProxy($primaryUri, $secondaryUri, $settings->getName(), $options);
        // Getting authentication scheme
        $authScheme = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Authentication\TokenAuthScheme($token);
        // Adding common request middleware
        $commonRequestMiddleware = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Middlewares\CommonRequestMiddleware($authScheme, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STORAGE_API_LATEST_VERSION, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::BLOB_SDK_VERSION);
        $blobWrapper->pushMiddleware($commonRequestMiddleware);
        return $blobWrapper;
    }
    /**
     * Builds an anonymous access object with given primary service
     * endpoint. The service endpoint should contain a scheme and a
     * host, e.g.:
     *     http://mystorageaccount.blob.core.windows.net
     *
     * @param  string $primaryServiceEndpoint   Primary service endpoint.
     * @param  array  $options                  Optional request options.
     *
     * @return BlobRestProxy
     */
    public static function createContainerAnonymousAccess($primaryServiceEndpoint, array $options = [])
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($primaryServiceEndpoint, '$primaryServiceEndpoint');
        $secondaryServiceEndpoint = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetSecondaryEndpointFromPrimaryEndpoint($primaryServiceEndpoint);
        $blobWrapper = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\BlobRestProxy($primaryServiceEndpoint, $secondaryServiceEndpoint, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryParseAccountNameFromUrl($primaryServiceEndpoint), $options);
        $blobWrapper->pushMiddleware(new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Middlewares\CommonRequestMiddleware(null, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STORAGE_API_LATEST_VERSION, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::BLOB_SDK_VERSION));
        return $blobWrapper;
    }
    /**
     * Get the value for SingleBlobUploadThresholdInBytes
     *
     * @return int
     */
    public function getSingleBlobUploadThresholdInBytes()
    {
        return $this->singleBlobUploadThresholdInBytes;
    }
    /**
     * Get the value for blockSize
     *
     * @return int
     */
    public function getBlockSize()
    {
        return $this->blockSize;
    }
    /**
     * Set the value for SingleBlobUploadThresholdInBytes, Max 256MB
     *
     * @param int $val The max size to send as a single blob block
     *
     * @return void
     */
    public function setSingleBlobUploadThresholdInBytes($val)
    {
        if ($val > \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::MB_IN_BYTES_256) {
            // What should the proper action here be?
            $val = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::MB_IN_BYTES_256;
        } elseif ($val < 1) {
            // another spot that could use looking at
            $val = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::MB_IN_BYTES_32;
        }
        $this->singleBlobUploadThresholdInBytes = $val;
        //If block size is larger than singleBlobUploadThresholdInBytes, honor
        //threshold.
        $this->blockSize = $val > $this->blockSize ? $this->blockSize : $val;
    }
    /**
     * Set the value for block size, Max 100MB
     *
     * @param int $val The max size for each block to be sent.
     *
     * @return void
     */
    public function setBlockSize($val)
    {
        if ($val > \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::MB_IN_BYTES_100) {
            // What should the proper action here be?
            $val = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::MB_IN_BYTES_100;
        } elseif ($val < 1) {
            // another spot that could use looking at
            $val = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::MB_IN_BYTES_4;
        }
        //If block size is larger than singleBlobUploadThresholdInBytes, honor
        //threshold.
        $val = $val > $this->singleBlobUploadThresholdInBytes ? $this->singleBlobUploadThresholdInBytes : $val;
        $this->blockSize = $val;
    }
    /**
     * Get the block size of multiple upload block size using the provided
     * content
     *
     * @param  StreamInterface $content The content of the blocks.
     *
     * @return int
     */
    private function getMultipleUploadBlockSizeUsingContent($content)
    {
        //Default value is 100 MB.
        $result = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::MB_IN_BYTES_100;
        //PHP must be ran in 64bit environment so content->getSize() could
        //return a guaranteed accurate size.
        if (\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::is64BitPHP()) {
            //Content must be seekable to determine the size.
            if ($content->isSeekable()) {
                $size = $content->getSize();
                //When threshold is lower than 100MB, assume maximum number of
                //block is used for the block blob, if the blockSize is still
                //smaller than the assumed size, it means assumed size should
                //be hornored, otherwise the blocks count will exceed maximum
                //value allowed.
                if ($this->blockSize < $result) {
                    $assumedSize = \ceil((float) $size / (float) \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::MAX_BLOB_BLOCKS);
                    if ($this->blockSize <= $assumedSize) {
                        $result = $assumedSize;
                    } else {
                        $result = $this->blockSize;
                    }
                }
            }
        } else {
            // If not, we could only honor user's setting to determine
            // chunk size.
            $result = $this->blockSize;
        }
        return $result;
    }
    /**
     * Gets the copy blob source name with specified parameters.
     *
     * @param string                 $containerName The name of the container.
     * @param string                 $blobName      The name of the blob.
     * @param Models\CopyBlobOptions $options       The optional parameters.
     *
     * @return string
     */
    private function getCopyBlobSourceName($containerName, $blobName, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CopyBlobOptions $options)
    {
        $sourceName = $this->getBlobUrl($containerName, $blobName);
        if (!\is_null($options->getSourceSnapshot())) {
            $sourceName .= '?snapshot=' . $options->getSourceSnapshot();
        }
        return $sourceName;
    }
    /**
     * Creates URI path for blob or container.
     *
     * @param string $container The container name.
     * @param string $blob      The blob name.
     *
     * @return string
     */
    private function createPath($container, $blob = '')
    {
        if (empty($blob) && $blob != '0') {
            return empty($container) ? '/' : $container;
        }
        $encodedBlob = \urlencode($blob);
        // Unencode the forward slashes to match what the server expects.
        $encodedBlob = \str_replace('%2F', '/', $encodedBlob);
        // Unencode the backward slashes to match what the server expects.
        $encodedBlob = \str_replace('%5C', '/', $encodedBlob);
        // Re-encode the spaces (encoded as space) to the % encoding.
        $encodedBlob = \str_replace('+', '%20', $encodedBlob);
        // Empty container means accessing default container
        if (empty($container)) {
            return $encodedBlob;
        }
        return '/' . $container . '/' . $encodedBlob;
    }
    /**
     * Creates full URI to the given blob.
     *
     * @param string $container The container name.
     * @param string $blob      The blob name.
     *
     * @return string
     */
    public function getBlobUrl($container, $blob)
    {
        $encodedBlob = $this->createPath($container, $blob);
        $uri = $this->getPsrPrimaryUri();
        $exPath = $uri->getPath();
        if ($exPath != '') {
            //Remove the duplicated slash in the path.
            $encodedBlob = \str_replace('//', '/', $exPath . $encodedBlob);
        }
        return (string) $uri->withPath($encodedBlob);
    }
    /**
     * Helper method to create promise for getContainerProperties API call.
     *
     * @param string                    $container The container name.
     * @param Models\BlobServiceOptions $options   The optional parameters.
     * @param string                    $operation The operation string. Should be
     * 'metadata' to get metadata.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    private function getContainerPropertiesAsyncImpl($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null, $operation = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_GET;
        $headers = array();
        $queryParams = array();
        $postParams = array();
        $path = $this->createPath($container);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_REST_TYPE, 'container');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, $operation);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options)->then(function ($response) {
            $responseHeaders = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetContainerPropertiesResult::create($responseHeaders);
        }, null);
    }
    /**
     * Adds optional create blob headers.
     *
     * @param CreateBlobOptions $options The optional parameters.
     * @param array             $headers The HTTP request headers.
     *
     * @return array
     */
    private function addCreateBlobOptionalHeaders(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobOptions $options, array $headers)
    {
        $headers = $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $headers = $this->addMetadataHeaders($headers, $options->getMetadata());
        $contentType = $options->getContentType();
        if (\is_null($contentType)) {
            $contentType = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::BINARY_FILE_TYPE;
        }
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONTENT_TYPE, $contentType);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONTENT_ENCODING, $options->getContentEncoding());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONTENT_LANGUAGE, $options->getContentLanguage());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONTENT_MD5, $options->getContentMD5());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CACHE_CONTROL, $options->getCacheControl());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONTENT_DISPOSITION, $options->getContentDisposition());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::CONTENT_TYPE, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::URL_ENCODED_CONTENT_TYPE);
        return $headers;
    }
    /**
     * Adds Range header to the headers array.
     *
     * @param array   $headers The HTTP request headers.
     * @param integer $start   The start byte.
     * @param integer $end     The end byte.
     *
     * @return array
     */
    private function addOptionalRangeHeader(array $headers, $start, $end)
    {
        if (!\is_null($start) || !\is_null($end)) {
            $range = $start . '-' . $end;
            $rangeValue = 'bytes=' . $range;
            $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::RANGE, $rangeValue);
        }
        return $headers;
    }
    /**
     * Get the expected status code of a given lease action.
     *
     * @param  string $leaseAction The given lease action
     * @return string
     * @throws \Exception
     */
    private static function getStatusCodeOfLeaseAction($leaseAction)
    {
        switch ($leaseAction) {
            case \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseMode::ACQUIRE_ACTION:
                $statusCode = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_CREATED;
                break;
            case \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseMode::RENEW_ACTION:
                $statusCode = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_OK;
                break;
            case \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseMode::RELEASE_ACTION:
                $statusCode = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_OK;
                break;
            case \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseMode::BREAK_ACTION:
                $statusCode = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_ACCEPTED;
                break;
            default:
                throw new \Exception(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::NOT_IMPLEMENTED_MSG);
        }
        return $statusCode;
    }
    /**
     * Creates promise that does the actual work for leasing a blob.
     *
     * @param string                    $leaseAction        Lease action string.
     * @param string                    $container          Container name.
     * @param string                    $blob               Blob to lease name.
     * @param string                    $proposedLeaseId    Proposed lease id.
     * @param int                       $leaseDuration      Lease duration, in seconds.
     * @param string                    $leaseId            Existing lease id.
     * @param int                       $breakPeriod        Break period, in seconds.
     * @param string                    $expectedStatusCode Expected status code.
     * @param Models\BlobServiceOptions $options            Optional parameters.
     * @param Models\AccessCondition    $accessCondition    Access conditions.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    private function putLeaseAsyncImpl($leaseAction, $container, $blob, $proposedLeaseId, $leaseDuration, $leaseId, $breakPeriod, $expectedStatusCode, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\AccessCondition $accessCondition = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($container, 'container');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $headers = array();
        $queryParams = array();
        $postParams = array();
        if (empty($blob)) {
            $path = $this->createPath($container);
            $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_REST_TYPE, 'container');
        } else {
            $path = $this->createPath($container, $blob);
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'lease');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_TIMEOUT, $options->getTimeout());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $leaseId);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ACTION, $leaseAction);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_BREAK_PERIOD, $breakPeriod);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_DURATION, $leaseDuration);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_PROPOSED_LEASE_ID, $proposedLeaseId);
        $this->addOptionalAccessConditionHeader($headers, $accessCondition);
        if (!\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions();
        }
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, $expectedStatusCode, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options);
    }
    /**
     * Creates promise that does actual work for create and clear blob pages.
     *
     * @param string                 $action    Either clear or create.
     * @param string                 $container The container name.
     * @param string                 $blob      The blob name.
     * @param Range                  $range     The page ranges.
     * @param string                 $content   The content string.
     * @param CreateBlobPagesOptions $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    private function updatePageBlobPagesAsyncImpl($action, $container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range $range, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobPagesOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($content, 'content');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isTrue($range instanceof \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range, \sprintf(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::INVALID_PARAM_MSG, 'range', \get_class(new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range(0))));
        $body = \Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Utils::streamFor($content);
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $headers = array();
        $queryParams = array();
        $postParams = array();
        $path = $this->createPath($container, $blob);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobPagesOptions();
        }
        $headers = $this->addOptionalRangeHeader($headers, $range->getStart(), $range->getEnd());
        $headers = $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::CONTENT_MD5, $options->getContentMD5());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_PAGE_WRITE, $action);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::CONTENT_TYPE, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::URL_ENCODED_CONTENT_TYPE);
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'page');
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_CREATED, $body, $options)->then(function ($response) {
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobPagesResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()));
        }, null);
    }
    /**
     * Lists all of the containers in the given storage account.
     *
     * @param ListContainersOptions $options The optional parameters.
     *
     * @return ListContainersResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179352.aspx
     */
    public function listContainers(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListContainersOptions $options = null)
    {
        return $this->listContainersAsync($options)->wait();
    }
    /**
     * Create a promise for lists all of the containers in the given
     * storage account.
     *
     * @param  ListContainersOptions $options The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function listContainersAsync(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListContainersOptions $options = null)
    {
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_GET;
        $headers = array();
        $queryParams = array();
        $postParams = array();
        $path = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING;
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListContainersOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'list');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_PREFIX_LOWERCASE, $options->getPrefix());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_MARKER_LOWERCASE, $options->getNextMarker());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_MAX_RESULTS_LOWERCASE, $options->getMaxResults());
        $isInclude = $options->getIncludeMetadata();
        $isInclude = $isInclude ? 'metadata' : null;
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_INCLUDE, $isInclude);
        $dataSerializer = $this->dataSerializer;
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options)->then(function ($response) use($dataSerializer) {
            $parsed = $this->dataSerializer->unserialize($response->getBody());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListContainersResult::create($parsed, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::getLocationFromHeaders($response->getHeaders()));
        });
    }
    /**
     * Creates a new container in the given storage account.
     *
     * @param string                        $container The container name.
     * @param Models\CreateContainerOptions $options   The optional parameters.
     *
     * @return void
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179468.aspx
     */
    public function createContainer($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions $options = null)
    {
        $this->createContainerAsync($container, $options)->wait();
    }
    /**
     * Creates a new container in the given storage account.
     *
     * @param string                        $container The container name.
     * @param Models\CreateContainerOptions $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179468.aspx
     */
    public function createContainerAsync($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($container, 'container');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $postParams = array();
        $queryParams = array(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_REST_TYPE => 'container');
        $path = $this->createPath($container);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions();
        }
        $metadata = $options->getMetadata();
        $headers = $this->generateMetadataHeaders($metadata);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_PUBLIC_ACCESS, $options->getPublicAccess());
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_CREATED, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options);
    }
    /**
     * Deletes a container in the given storage account.
     *
     * @param string                        $container The container name.
     * @param Models\BlobServiceOptions     $options   The optional parameters.
     *
     * @return void
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179408.aspx
     */
    public function deleteContainer($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        $this->deleteContainerAsync($container, $options)->wait();
    }
    /**
     * Create a promise for deleting a container.
     *
     * @param  string                             $container name of the container
     * @param  Models\BlobServiceOptions|null     $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function deleteContainerAsync($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($container, 'container');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_DELETE;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions();
        }
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $headers = $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_REST_TYPE, 'container');
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_ACCEPTED, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options);
    }
    /**
     * Returns all properties and metadata on the container.
     *
     * @param string                    $container name
     * @param Models\BlobServiceOptions $options   optional parameters
     *
     * @return Models\GetContainerPropertiesResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179370.aspx
     */
    public function getContainerProperties($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        return $this->getContainerPropertiesAsync($container, $options)->wait();
    }
    /**
     * Create promise to return all properties and metadata on the container.
     *
     * @param string                    $container name
     * @param Models\BlobServiceOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179370.aspx
     */
    public function getContainerPropertiesAsync($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        return $this->getContainerPropertiesAsyncImpl($container, $options);
    }
    /**
     * Returns only user-defined metadata for the specified container.
     *
     * @param string                    $container name
     * @param Models\BlobServiceOptions $options   optional parameters
     *
     * @return Models\GetContainerPropertiesResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691976.aspx
     */
    public function getContainerMetadata($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        return $this->getContainerMetadataAsync($container, $options)->wait();
    }
    /**
     * Create promise to return only user-defined metadata for the specified
     * container.
     *
     * @param string                    $container name
     * @param Models\BlobServiceOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691976.aspx
     */
    public function getContainerMetadataAsync($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        return $this->getContainerPropertiesAsyncImpl($container, $options, 'metadata');
    }
    /**
     * Gets the access control list (ACL) and any container-level access policies
     * for the container.
     *
     * @param string                    $container The container name.
     * @param Models\BlobServiceOptions $options   The optional parameters.
     *
     * @return Models\GetContainerACLResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179469.aspx
     */
    public function getContainerAcl($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        return $this->getContainerAclAsync($container, $options)->wait();
    }
    /**
     * Creates the promise to get the access control list (ACL) and any
     * container-level access policies for the container.
     *
     * @param string                    $container The container name.
     * @param Models\BlobServiceOptions $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179469.aspx
     */
    public function getContainerAclAsync($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_GET;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_REST_TYPE, 'container');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'acl');
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        $dataSerializer = $this->dataSerializer;
        $promise = $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options);
        return $promise->then(function ($response) use($dataSerializer) {
            $responseHeaders = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders());
            $access = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($responseHeaders, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_PUBLIC_ACCESS);
            $etag = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($responseHeaders, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::ETAG);
            $modified = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($responseHeaders, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::LAST_MODIFIED);
            $modifiedDate = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::convertToDateTime($modified);
            $parsed = $dataSerializer->unserialize($response->getBody());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetContainerACLResult::create($access, $etag, $modifiedDate, $parsed);
        }, null);
    }
    /**
     * Sets the ACL and any container-level access policies for the container.
     *
     * @param string                    $container name
     * @param Models\ContainerACL       $acl       access control list for container
     * @param Models\BlobServiceOptions $options   optional parameters
     *
     * @return void
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179391.aspx
     */
    public function setContainerAcl($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ContainerACL $acl, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        $this->setContainerAclAsync($container, $acl, $options)->wait();
    }
    /**
     * Creates promise to set the ACL and any container-level access policies
     * for the container.
     *
     * @param string                    $container name
     * @param Models\ContainerACL       $acl       access control list for container
     * @param Models\BlobServiceOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179391.aspx
     */
    public function setContainerAclAsync($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ContainerACL $acl, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($acl, 'acl');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container);
        $body = $acl->toXml($this->dataSerializer);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_REST_TYPE, 'container');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'acl');
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_PUBLIC_ACCESS, $acl->getPublicAccess());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::CONTENT_TYPE, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::URL_ENCODED_CONTENT_TYPE);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_OK, $body, $options);
    }
    /**
     * Sets metadata headers on the container.
     *
     * @param string                    $container name
     * @param array                     $metadata  metadata key/value pair.
     * @param Models\BlobServiceOptions $options   optional parameters
     *
     * @return void
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179362.aspx
     */
    public function setContainerMetadata($container, array $metadata, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        $this->setContainerMetadataAsync($container, $metadata, $options)->wait();
    }
    /**
     * Sets metadata headers on the container.
     *
     * @param string                   $container name
     * @param array                    $metadata  metadata key/value pair.
     * @param Models\BlobServiceOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179362.aspx
     */
    public function setContainerMetadataAsync($container, array $metadata, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::validateMetadata($metadata);
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $headers = $this->generateMetadataHeaders($metadata);
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_REST_TYPE, 'container');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'metadata');
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $headers = $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options);
    }
    /**
     * Sets blob tier on the blob.
     *
     * @param string                    $container name
     * @param string                    $blob      name of the blob
     * @param Models\SetBlobTierOptions $options   optional parameters
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/set-blob-tier
     */
    public function setBlobTier($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\SetBlobTierOptions $options = null)
    {
        $this->setBlobTierAsync($container, $blob, $options)->wait();
    }
    /**
     * Sets blob tier on the blob.
     *
     * @param string                    $container name
     * @param string                    $blob      name of the blob
     * @param Models\SetBlobTierOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/set-blob-tier
     */
    public function setBlobTierAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\SetBlobTierOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container, $blob);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\SetBlobTierOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'tier');
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_ACCESS_TIER, $options->getAccessTier());
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, array(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_ACCEPTED), \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options);
    }
    /**
     * Lists all of the blobs in the given container.
     *
     * @param string                  $container The container name.
     * @param Models\ListBlobsOptions $options   The optional parameters.
     *
     * @return Models\ListBlobsResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd135734.aspx
     */
    public function listBlobs($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions $options = null)
    {
        return $this->listBlobsAsync($container, $options)->wait();
    }
    /**
     * Creates promise to list all of the blobs in the given container.
     *
     * @param string                  $container The container name.
     * @param Models\ListBlobsOptions $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd135734.aspx
     */
    public function listBlobsAsync($container, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNull($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_GET;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_REST_TYPE, 'container');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'list');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_PREFIX_LOWERCASE, \str_replace('\\', '/', $options->getPrefix()));
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_MARKER_LOWERCASE, $options->getNextMarker());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_DELIMITER, $options->getDelimiter());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_MAX_RESULTS_LOWERCASE, $options->getMaxResults());
        $includeMetadata = $options->getIncludeMetadata();
        $includeSnapshots = $options->getIncludeSnapshots();
        $includeUncommittedBlobs = $options->getIncludeUncommittedBlobs();
        $includecopy = $options->getIncludeCopy();
        $includeDeleted = $options->getIncludeDeleted();
        $includeValue = static::groupQueryValues(array($includeMetadata ? 'metadata' : null, $includeSnapshots ? 'snapshots' : null, $includeUncommittedBlobs ? 'uncommittedblobs' : null, $includecopy ? 'copy' : null, $includeDeleted ? 'deleted' : null));
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_INCLUDE, $includeValue);
        $dataSerializer = $this->dataSerializer;
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options)->then(function ($response) use($dataSerializer) {
            $parsed = $dataSerializer->unserialize($response->getBody());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListBlobsResult::create($parsed, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::getLocationFromHeaders($response->getHeaders()));
        }, null);
    }
    /**
     * Creates a new page blob. Note that calling createPageBlob to create a page
     * blob only initializes the blob.
     * To add content to a page blob, call createBlobPages method.
     *
     * @param string                   $container The container name.
     * @param string                   $blob      The blob name.
     * @param integer                  $length    Specifies the maximum size
     *                                            for the page blob, up to 1 TB.
     *                                            The page blob size must be
     *                                            aligned to a 512-byte
     *                                            boundary.
     * @param Models\CreatePageBlobOptions $options   The optional parameters.
     *
     * @return Models\PutBlobResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179451.aspx
     */
    public function createPageBlob($container, $blob, $length, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreatePageBlobOptions $options = null)
    {
        return $this->createPageBlobAsync($container, $blob, $length, $options)->wait();
    }
    /**
     * Creates promise to create a new page blob. Note that calling
     * createPageBlob to create a page blob only initializes the blob.
     * To add content to a page blob, call createBlobPages method.
     *
     * @param string                   $container The container name.
     * @param string                   $blob      The blob name.
     * @param integer                  $length    Specifies the maximum size
     *                                            for the page blob, up to 1 TB.
     *                                            The page blob size must be
     *                                            aligned to a 512-byte
     *                                            boundary.
     * @param Models\CreatePageBlobOptions $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179451.aspx
     */
    public function createPageBlobAsync($container, $blob, $length, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreatePageBlobOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isInteger($length, 'length');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNull($length, 'length');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container, $blob);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreatePageBlobOptions();
        }
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_TYPE, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobType::PAGE_BLOB);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONTENT_LENGTH, $length);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_SEQUENCE_NUMBER, $options->getSequenceNumber());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_ACCESS_TIER, $options->getAccessTier());
        $headers = $this->addCreateBlobOptionalHeaders($options, $headers);
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_CREATED, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options)->then(function ($response) {
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\PutBlobResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()));
        }, null);
    }
    /**
     * Create a new append blob.
     * If the blob already exists on the service, it will be overwritten.
     *
     * @param string                   $container The container name.
     * @param string                   $blob      The blob name.
     * @param Models\CreateBlobOptions $options   The optional parameters.
     *
     * @return Models\PutBlobResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179451.aspx
     */
    public function createAppendBlob($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobOptions $options = null)
    {
        return $this->createAppendBlobAsync($container, $blob, $options)->wait();
    }
    /**
     * Creates promise to create a new append blob.
     * If the blob already exists on the service, it will be overwritten.
     *
     * @param string                   $container The container name.
     * @param string                   $blob      The blob name.
     * @param Models\CreateBlobOptions $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179451.aspx
     */
    public function createAppendBlobAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container, $blob);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobOptions();
        }
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_TYPE, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobType::APPEND_BLOB);
        $headers = $this->addCreateBlobOptionalHeaders($options, $headers);
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_CREATED, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options)->then(function ($response) {
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\PutBlobResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()));
        }, null);
    }
    /**
     * Creates a new block blob or updates the content of an existing block blob.
     *
     * Updating an existing block blob overwrites any existing metadata on the blob.
     * Partial updates are not supported with createBlockBlob the content of the
     * existing blob is overwritten with the content of the new blob. To perform a
     * partial update of the content of a block blob, use the createBlockList
     * method.
     * Note that the default content type is application/octet-stream.
     *
     * @param string                          $container The name of the container.
     * @param string                          $blob      The name of the blob.
     * @param string|resource|StreamInterface $content   The content of the blob.
     * @param Models\CreateBlockBlobOptions   $options   The optional parameters.
     *
     * @return Models\PutBlobResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179451.aspx
     */
    public function createBlockBlob($container, $blob, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions $options = null)
    {
        return $this->createBlockBlobAsync($container, $blob, $content, $options)->wait();
    }
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
     * @param string                          $container The name of the container.
     * @param string                          $blob      The name of the blob.
     * @param string|resource|StreamInterface $content   The content of the blob.
     * @param Models\CreateBlockBlobOptions   $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179451.aspx
     */
    public function createBlockBlobAsync($container, $blob, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions $options = null)
    {
        $body = \Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Utils::streamFor($content);
        //If the size of the stream is not seekable or larger than the single
        //upload threshold then call concurrent upload. Otherwise call putBlob.
        $promise = null;
        if (!\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::isStreamLargerThanSizeOrNotSeekable($body, $this->singleBlobUploadThresholdInBytes)) {
            $promise = $this->createBlockBlobBySingleUploadAsync($container, $blob, $body, $options);
        } else {
            // This is for large or failsafe upload
            $promise = $this->createBlockBlobByMultipleUploadAsync($container, $blob, $body, $options);
        }
        //return the parsed result, instead of the raw response.
        return $promise;
    }
    /**
     * Create a new page blob and upload the content to the page blob.
     *
     * @param string                          $container The name of the container.
     * @param string                          $blob      The name of the blob.
     * @param int                             $length    The length of the blob.
     * @param string|resource|StreamInterface $content   The content of the blob.
     * @param Models\CreatePageBlobFromContentOptions
     *                                        $options   The optional parameters.
     *
     * @return Models\GetBlobPropertiesResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/get-blob-properties
     */
    public function createPageBlobFromContent($container, $blob, $length, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreatePageBlobFromContentOptions $options = null)
    {
        return $this->createPageBlobFromContentAsync($container, $blob, $length, $content, $options)->wait();
    }
    /**
     * Creates a promise to create a new page blob and upload the content
     * to the page blob.
     *
     * @param string                          $container The name of the container.
     * @param string                          $blob      The name of the blob.
     * @param int                             $length    The length of the blob.
     * @param string|resource|StreamInterface $content   The content of the blob.
     * @param Models\CreatePageBlobFromContentOptions
     *                                        $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/get-blob-properties
     */
    public function createPageBlobFromContentAsync($container, $blob, $length, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreatePageBlobFromContentOptions $options = null)
    {
        $body = \Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Utils::streamFor($content);
        $self = $this;
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreatePageBlobFromContentOptions();
        }
        $createBlobPromise = $this->createPageBlobAsync($container, $blob, $length, $options);
        $uploadBlobPromise = $createBlobPromise->then(function ($value) use($self, $container, $blob, $body, $options) {
            $result = $value;
            return $self->uploadPageBlobAsync($container, $blob, $body, $options);
        }, null);
        return $uploadBlobPromise->then(function ($value) use($self, $container, $blob, $options) {
            $getBlobPropertiesOptions = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobPropertiesOptions();
            $getBlobPropertiesOptions->setLeaseId($options->getLeaseId());
            return $self->getBlobPropertiesAsync($container, $blob, $getBlobPropertiesOptions);
        }, null);
    }
    /**
     * Creates promise to create a new block blob or updates the content of an
     * existing block blob. This only supports contents smaller than single
     * upload threashold.
     *
     * Updating an existing block blob overwrites any existing metadata on
     * the blob.
     *
     * @param string                   $container The name of the container.
     * @param string                   $blob      The name of the blob.
     * @param StreamInterface          $content   The content of the blob.
     * @param Models\CreateBlobOptions $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179451.aspx
     */
    protected function createBlockBlobBySingleUploadAsync($container, $blob, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isTrue($options == null || $options instanceof \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobOptions, \sprintf(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::INVALID_PARAM_MSG, 'options', \get_class(new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobOptions())));
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container, $blob);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobOptions();
        }
        $headers = $this->addCreateBlobOptionalHeaders($options, $headers);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_TYPE, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobType::BLOCK_BLOB);
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_CREATED, $content, $options)->then(function ($response) {
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\PutBlobResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()));
        }, null);
    }
    /**
     * This method creates the blob blocks. This method will send the request
     * concurrently for better performance.
     *
     * @param  string                        $container  Name of the container
     * @param  string                        $blob       Name of the blob
     * @param  StreamInterface               $content    Content's stream
     * @param  Models\CreateBlockBlobOptions $options    Array that contains
     *                                                   all the option
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    protected function createBlockBlobByMultipleUploadAsync($container, $blob, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        if ($content->isSeekable() && \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::is64BitPHP()) {
            \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isTrue($content->getSize() <= \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::MAX_BLOCK_BLOB_SIZE, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::CONTENT_SIZE_TOO_LARGE);
        }
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions();
        }
        $createBlobBlockOptions = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobBlockOptions::create($options);
        $selfInstance = $this;
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $headers = $this->createBlobBlockHeader($createBlobBlockOptions);
        $postParams = array();
        $path = $this->createPath($container, $blob);
        $useTransactionalMD5 = $options->getUseTransactionalMD5();
        $blockIds = array();
        //Determine the block size according to the content and threshold.
        $blockSize = $this->getMultipleUploadBlockSizeUsingContent($content);
        $counter = 0;
        //create the generator for requests.
        //this generator also constructs the blockId array on the fly.
        $generator = function () use($content, &$blockIds, $blockSize, $createBlobBlockOptions, $method, $headers, $postParams, $path, $useTransactionalMD5, &$counter, $selfInstance) {
            //read the content.
            $blockContent = $content->read($blockSize);
            //construct the blockId
            $blockId = \base64_encode(\str_pad($counter++, 6, '0', \STR_PAD_LEFT));
            $size = \strlen($blockContent);
            if ($size == 0) {
                return null;
            }
            if ($useTransactionalMD5) {
                $contentMD5 = \base64_encode(\md5($blockContent, \true));
                $selfInstance->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::CONTENT_MD5, $contentMD5);
            }
            //add the id to array.
            \array_push($blockIds, new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\Block($blockId, 'Uncommitted'));
            $queryParams = $selfInstance->createBlobBlockQueryParams($createBlobBlockOptions, $blockId, \true);
            //return the array of requests.
            return $selfInstance->createRequest($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY, $blockContent);
        };
        //Send the request concurrently.
        //Does not need to evaluate the results. If operation not successful,
        //exception will be thrown.
        $putBlobPromise = $this->sendConcurrentAsync($generator, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_CREATED, $options);
        $commitBlobPromise = $putBlobPromise->then(function ($value) use($selfInstance, $container, $blob, &$blockIds, $putBlobPromise, $options) {
            return $selfInstance->commitBlobBlocksAsync($container, $blob, $blockIds, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CommitBlobBlocksOptions::create($options));
        }, null);
        return $commitBlobPromise;
    }
    /**
     * This method upload the page blob pages. This method will send the request
     * concurrently for better performance.
     *
     * @param  string                   $container  Name of the container
     * @param  string                   $blob       Name of the blob
     * @param  StreamInterface          $content    Content's stream
     * @param  Models\CreatePageBlobFromContentOptions
     *                                  $options    Array that contains
     *                                              all the option
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    private function uploadPageBlobAsync($container, $blob, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreatePageBlobFromContentOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreatePageBlobFromContentOptions();
        }
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container, $blob);
        $useTransactionalMD5 = $options->getUseTransactionalMD5();
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'page');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_TIMEOUT, $options->getTimeout());
        $pageSize = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::MB_IN_BYTES_4;
        $start = 0;
        $end = -1;
        //create the generator for requests.
        $generator = function () use($content, $pageSize, $method, $postParams, $queryParams, $path, $useTransactionalMD5, &$start, &$end, $options) {
            //read the content.
            do {
                $pageContent = $content->read($pageSize);
                $size = \strlen($pageContent);
                if ($size == 0) {
                    return null;
                }
                $end += $size;
                $start = $end - $size + 1;
                // If all Zero, skip this range
            } while (\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::allZero($pageContent));
            $headers = array();
            $headers = $this->addOptionalRangeHeader($headers, $start, $end);
            $headers = $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
            $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
            $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_PAGE_WRITE, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\PageWriteOption::UPDATE_OPTION);
            if ($useTransactionalMD5) {
                $contentMD5 = \base64_encode(\md5($pageContent, \true));
                $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::CONTENT_MD5, $contentMD5);
            }
            //return the array of requests.
            return $this->createRequest($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY, $pageContent);
        };
        //Send the request concurrently.
        //Does not need to evaluate the results. If operation is not successful,
        //exception will be thrown.
        return $this->sendConcurrentAsync($generator, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_CREATED, $options);
    }
    /**
     * Clears a range of pages from the blob.
     *
     * @param string                        $container name of the container
     * @param string                        $blob      name of the blob
     * @param Range                         $range     Can be up to the value of
     *                                                 the blob's full size.
     *                                                 Note that ranges must be
     *                                                 aligned to 512 (0-511,
     *                                                 512-1023)
     * @param Models\CreateBlobPagesOptions $options   optional parameters
     *
     * @return Models\CreateBlobPagesResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691975.aspx
     */
    public function clearBlobPages($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range $range, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobPagesOptions $options = null)
    {
        return $this->clearBlobPagesAsync($container, $blob, $range, $options)->wait();
    }
    /**
     * Creates promise to clear a range of pages from the blob.
     *
     * @param string                        $container name of the container
     * @param string                        $blob      name of the blob
     * @param Range                         $range     Can be up to the value of
     *                                                 the blob's full size.
     *                                                 Note that ranges must be
     *                                                 aligned to 512 (0-511,
     *                                                 512-1023)
     * @param Models\CreateBlobPagesOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691975.aspx
     */
    public function clearBlobPagesAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range $range, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobPagesOptions $options = null)
    {
        return $this->updatePageBlobPagesAsyncImpl(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\PageWriteOption::CLEAR_OPTION, $container, $blob, $range, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options);
    }
    /**
     * Creates a range of pages to a page blob.
     *
     * @param string                          $container name of the container
     * @param string                          $blob      name of the blob
     * @param Range                           $range     Can be up to 4 MB in
     *                                                   size. Note that ranges
     *                                                   must be aligned to 512
     *                                                   (0-511, 512-1023)
     * @param string|resource|StreamInterface $content   the blob contents.
     * @param Models\CreateBlobPagesOptions   $options   optional parameters
     *
     * @return Models\CreateBlobPagesResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691975.aspx
     */
    public function createBlobPages($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range $range, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobPagesOptions $options = null)
    {
        return $this->createBlobPagesAsync($container, $blob, $range, $content, $options)->wait();
    }
    /**
     * Creates promise to create a range of pages to a page blob.
     *
     * @param string                          $container name of the container
     * @param string                          $blob      name of the blob
     * @param Range                           $range     Can be up to 4 MB in
     *                                                   size. Note that ranges
     *                                                   must be aligned to 512
     *                                                   (0-511, 512-1023)
     * @param string|resource|StreamInterface $content   the blob contents.
     * @param Models\CreateBlobPagesOptions   $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691975.aspx
     */
    public function createBlobPagesAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range $range, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobPagesOptions $options = null)
    {
        $contentStream = \Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Utils::streamFor($content);
        //because the content is at most 4MB long, can retrieve all the data
        //here at once.
        $body = $contentStream->getContents();
        //if the range is not align to 512, throw exception.
        $chunks = (int) ($range->getLength() / 512);
        if ($chunks * 512 != $range->getLength()) {
            throw new \RuntimeException(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::ERROR_RANGE_NOT_ALIGN_TO_512);
        }
        return $this->updatePageBlobPagesAsyncImpl(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\PageWriteOption::UPDATE_OPTION, $container, $blob, $range, $body, $options);
    }
    /**
     * Creates a new block to be committed as part of a block blob.
     *
     * @param string                          $container name of the container
     * @param string                          $blob      name of the blob
     * @param string                          $blockId   must be less than or
     *                                                   equal to 64 bytes in
     *                                                   size. For a given blob,
     *                                                   the length of the value
     *                                                   specified for the
     *                                                   blockid parameter must
     *                                                   be the same size for
     *                                                   each block.
     * @param resource|string|StreamInterface $content   the blob block contents
     * @param Models\CreateBlobBlockOptions   $options   optional parameters
     *
     * @return Models\PutBlockResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd135726.aspx
     */
    public function createBlobBlock($container, $blob, $blockId, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobBlockOptions $options = null)
    {
        return $this->createBlobBlockAsync($container, $blob, $blockId, $content, $options)->wait();
    }
    /**
     * Creates a new block to be committed as part of a block blob.
     *
     * @param string                          $container name of the container
     * @param string                          $blob      name of the blob
     * @param string                          $blockId   must be less than or
     *                                                   equal to 64 bytes in
     *                                                   size. For a given blob,
     *                                                   the length of the value
     *                                                   specified for the
     *                                                   blockid parameter must
     *                                                   be the same size for
     *                                                   each block.
     * @param resource|string|StreamInterface $content   the blob block contents
     * @param Models\CreateBlobBlockOptions   $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd135726.aspx
     */
    public function createBlobBlockAsync($container, $blob, $blockId, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobBlockOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blockId, 'blockId');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blockId, 'blockId');
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobBlockOptions();
        }
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $headers = $this->createBlobBlockHeader($options);
        $postParams = array();
        $queryParams = $this->createBlobBlockQueryParams($options, $blockId);
        $path = $this->createPath($container, $blob);
        $contentStream = \Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Utils::streamFor($content);
        $body = $contentStream->getContents();
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_CREATED, $body, $options)->then(function ($response) {
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\PutBlockResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()));
        });
    }
    /**
     * Commits a new block of data to the end of an existing append blob.
     *
     * @param string                          $container name of the container
     * @param string                          $blob      name of the blob
     * @param resource|string|StreamInterface $content   the blob block contents
     * @param Models\AppendBlockOptions       $options   optional parameters
     *
     * @return Models\AppendBlockResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/append-block
     */
    public function appendBlock($container, $blob, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\AppendBlockOptions $options = null)
    {
        return $this->appendBlockAsync($container, $blob, $content, $options)->wait();
    }
    /**
     * Creates promise to commit a new block of data to the end of an existing append blob.
     *
     * @param string                          $container name of the container
     * @param string                          $blob      name of the blob
     * @param resource|string|StreamInterface $content   the blob block contents
     * @param Models\AppendBlockOptions       $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/append-block
     */
    public function appendBlockAsync($container, $blob, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\AppendBlockOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\AppendBlockOptions();
        }
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container, $blob);
        $contentStream = \Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Utils::streamFor($content);
        $length = $contentStream->getSize();
        $body = $contentStream->getContents();
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'appendblock');
        $headers = $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::CONTENT_LENGTH, $length);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::CONTENT_MD5, $options->getContentMD5());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONDITION_MAXSIZE, $options->getMaxBlobSize());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONDITION_APPENDPOS, $options->getAppendPosition());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_CREATED, $body, $options)->then(function ($response) {
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\AppendBlockResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()));
        });
    }
    /**
     * create the header for createBlobBlock(s)
     * @param  Models\CreateBlobBlockOptions $options the option of the request
     *
     * @return array
     */
    protected function createBlobBlockHeader(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobBlockOptions $options = null)
    {
        $headers = array();
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::CONTENT_MD5, $options->getContentMD5());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::CONTENT_TYPE, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::URL_ENCODED_CONTENT_TYPE);
        return $headers;
    }
    /**
     * create the query params for createBlobBlock(s)
     * @param  Models\CreateBlobBlockOptions $options      the option of the
     *                                                     request
     * @param  string                        $blockId      the block id of the
     *                                                     block.
     * @param  bool                          $isConcurrent if the query
     *                                                     parameter is for
     *                                                     concurrent upload.
     *
     * @return array  the constructed query parameters.
     */
    protected function createBlobBlockQueryParams(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobBlockOptions $options, $blockId, $isConcurrent = \false)
    {
        $queryParams = array();
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'block');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_BLOCKID, $blockId);
        if ($isConcurrent) {
            $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_TIMEOUT, $options->getTimeout());
        }
        return $queryParams;
    }
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
     * @param string                         $container The container name.
     * @param string                         $blob      The blob name.
     * @param Models\BlockList|Block[]       $blockList The block entries.
     * @param Models\CommitBlobBlocksOptions $options   The optional parameters.
     *
     * @return Models\PutBlobResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179467.aspx
     */
    public function commitBlobBlocks($container, $blob, $blockList, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CommitBlobBlocksOptions $options = null)
    {
        return $this->commitBlobBlocksAsync($container, $blob, $blockList, $options)->wait();
    }
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
     * @param string                         $container The container name.
     * @param string                         $blob      The blob name.
     * @param Models\BlockList|Block[]       $blockList The block entries.
     * @param Models\CommitBlobBlocksOptions $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179467.aspx
     */
    public function commitBlobBlocksAsync($container, $blob, $blockList, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CommitBlobBlocksOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isTrue($blockList instanceof \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlockList || \is_array($blockList), \sprintf(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::INVALID_PARAM_MSG, 'blockList', \get_class(new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlockList())));
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container, $blob);
        $isArray = \is_array($blockList);
        $blockList = $isArray ? \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlockList::create($blockList) : $blockList;
        $body = $blockList->toXml($this->dataSerializer);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CommitBlobBlocksOptions();
        }
        $blobContentType = $options->getContentType();
        $blobContentEncoding = $options->getContentEncoding();
        $blobContentLanguage = $options->getContentLanguage();
        $blobContentMD5 = $options->getContentMD5();
        $blobCacheControl = $options->getCacheControl();
        $blobCcontentDisposition = $options->getContentDisposition();
        $leaseId = $options->getLeaseId();
        $contentType = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::URL_ENCODED_CONTENT_TYPE;
        $metadata = $options->getMetadata();
        $headers = $this->generateMetadataHeaders($metadata);
        $headers = $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $leaseId);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CACHE_CONTROL, $blobCacheControl);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONTENT_DISPOSITION, $blobCcontentDisposition);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONTENT_TYPE, $blobContentType);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONTENT_ENCODING, $blobContentEncoding);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONTENT_LANGUAGE, $blobContentLanguage);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONTENT_MD5, $blobContentMD5);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::CONTENT_TYPE, $contentType);
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'blocklist');
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_CREATED, $body, $options)->then(function ($response) {
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\PutBlobResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()));
        }, null);
    }
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
     * @param string                       $container name of the container
     * @param string                       $blob      name of the blob
     * @param Models\ListBlobBlocksOptions $options   optional parameters
     *
     * @return Models\ListBlobBlocksResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179400.aspx
     */
    public function listBlobBlocks($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksOptions $options = null)
    {
        return $this->listBlobBlocksAsync($container, $blob, $options)->wait();
    }
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
     * @param string                       $container name of the container
     * @param string                       $blob      name of the blob
     * @param Models\ListBlobBlocksOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179400.aspx
     */
    public function listBlobBlocksAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_GET;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container, $blob);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksOptions();
        }
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_BLOCK_LIST_TYPE, $options->getBlockListType());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_SNAPSHOT, $options->getSnapshot());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'blocklist');
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options)->then(function ($response) {
            $parsed = $this->dataSerializer->unserialize($response->getBody());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()), $parsed);
        }, null);
    }
    /**
     * Returns all properties and metadata on the blob.
     *
     * @param string                          $container name of the container
     * @param string                          $blob      name of the blob
     * @param Models\GetBlobPropertiesOptions $options   optional parameters
     *
     * @return Models\GetBlobPropertiesResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179394.aspx
     */
    public function getBlobProperties($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobPropertiesOptions $options = null)
    {
        return $this->getBlobPropertiesAsync($container, $blob, $options)->wait();
    }
    /**
     * Creates promise to return all properties and metadata on the blob.
     *
     * @param string                          $container name of the container
     * @param string                          $blob      name of the blob
     * @param Models\GetBlobPropertiesOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179394.aspx
     */
    public function getBlobPropertiesAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobPropertiesOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_HEAD;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container, $blob);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobPropertiesOptions();
        }
        $headers = $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_SNAPSHOT, $options->getSnapshot());
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options)->then(function ($response) {
            $formattedHeaders = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobPropertiesResult::create($formattedHeaders);
        }, null);
    }
    /**
     * Returns all properties and metadata on the blob.
     *
     * @param string                        $container name of the container
     * @param string                        $blob      name of the blob
     * @param Models\GetBlobMetadataOptions $options   optional parameters
     *
     * @return Models\GetBlobMetadataResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179350.aspx
     */
    public function getBlobMetadata($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobMetadataOptions $options = null)
    {
        return $this->getBlobMetadataAsync($container, $blob, $options)->wait();
    }
    /**
     * Creates promise to return all properties and metadata on the blob.
     *
     * @param string                        $container name of the container
     * @param string                        $blob      name of the blob
     * @param Models\GetBlobMetadataOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179350.aspx
     */
    public function getBlobMetadataAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobMetadataOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_HEAD;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container, $blob);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobMetadataOptions();
        }
        $headers = $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_SNAPSHOT, $options->getSnapshot());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'metadata');
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options)->then(function ($response) {
            $responseHeaders = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobMetadataResult::create($responseHeaders);
        });
    }
    /**
     * Returns a list of active page ranges for a page blob. Active page ranges are
     * those that have been populated with data.
     *
     * @param string                           $container name of the container
     * @param string                           $blob      name of the blob
     * @param Models\ListPageBlobRangesOptions $options   optional parameters
     *
     * @return Models\ListPageBlobRangesResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691973.aspx
     */
    public function listPageBlobRanges($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesOptions $options = null)
    {
        return $this->listPageBlobRangesAsync($container, $blob, $options)->wait();
    }
    /**
     * Creates promise to return a list of active page ranges for a page blob.
     * Active page ranges are those that have been populated with data.
     *
     * @param string                           $container name of the container
     * @param string                           $blob      name of the blob
     * @param Models\ListPageBlobRangesOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691973.aspx
     */
    public function listPageBlobRangesAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesOptions $options = null)
    {
        return $this->listPageBlobRangesAsyncImpl($container, $blob, null, $options);
    }
    /**
     * Returns a list of page ranges that have been updated or cleared.
     *
     * Returns a list of page ranges that have been updated or cleared since
     * the snapshot specified by `previousSnapshotTime`. Gets all of the page
     * ranges by default, or only the page ranges over a specific range of
     * bytes if `rangeStart` and `rangeEnd` in the `options` are specified.
     *
     * @param string                           $container             name of the container
     * @param string                           $blob                  name of the blob
     * @param string                           $previousSnapshotTime  previous snapshot time
     *                                                                for comparison which
     *                                                                should be prior to the
     *                                                                snapshot time defined
     *                                                                in `options`
     * @param Models\ListPageBlobRangesOptions $options               optional parameters
     *
     * @return Models\ListPageBlobRangesDiffResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/version-2015-07-08
     */
    public function listPageBlobRangesDiff($container, $blob, $previousSnapshotTime, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesOptions $options = null)
    {
        return $this->listPageBlobRangesDiffAsync($container, $blob, $previousSnapshotTime, $options)->wait();
    }
    /**
     * Creates promise to return a list of page ranges that have been updated
     * or cleared.
     *
     * Creates promise to return a list of page ranges that have been updated
     * or cleared since the snapshot specified by `previousSnapshotTime`. Gets
     * all of the page ranges by default, or only the page ranges over a specific
     * range of bytes if `rangeStart` and `rangeEnd` in the `options` are specified.
     *
     * @param string                           $container             name of the container
     * @param string                           $blob                  name of the blob
     * @param string                           $previousSnapshotTime  previous snapshot time
     *                                                                for comparison which
     *                                                                should be prior to the
     *                                                                snapshot time defined
     *                                                                in `options`
     * @param Models\ListPageBlobRangesOptions $options               optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691973.aspx
     */
    public function listPageBlobRangesDiffAsync($container, $blob, $previousSnapshotTime, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesOptions $options = null)
    {
        return $this->listPageBlobRangesAsyncImpl($container, $blob, $previousSnapshotTime, $options);
    }
    /**
     * Creates promise to return a list of page ranges.
     * If `previousSnapshotTime` is specified, the response will include
     * only the pages that differ between the target snapshot or blob and
     * the previous snapshot.
     *
     * @param string                           $container             name of the container
     * @param string                           $blob                  name of the blob
     * @param string                           $previousSnapshotTime  previous snapshot time
     *                                                                for comparison which
     *                                                                should be prior to the
     *                                                                snapshot time defined
     *                                                                in `options`
     * @param Models\ListPageBlobRangesOptions $options               optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691973.aspx
     */
    private function listPageBlobRangesAsyncImpl($container, $blob, $previousSnapshotTime = null, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_GET;
        $headers = array();
        $queryParams = array();
        $postParams = array();
        $path = $this->createPath($container, $blob);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesOptions();
        }
        $headers = $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        $range = $options->getRange();
        if ($range) {
            $headers = $this->addOptionalRangeHeader($headers, $range->getStart(), $range->getEnd());
        }
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_SNAPSHOT, $options->getSnapshot());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'pagelist');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_PRE_SNAPSHOT, $previousSnapshotTime);
        $dataSerializer = $this->dataSerializer;
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options)->then(function ($response) use($dataSerializer, $previousSnapshotTime) {
            $parsed = $dataSerializer->unserialize($response->getBody());
            if (\is_null($previousSnapshotTime)) {
                return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()), $parsed);
            } else {
                return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesDiffResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()), $parsed);
            }
        }, null);
    }
    /**
     * Sets system properties defined for a blob.
     *
     * @param string                          $container name of the container
     * @param string                          $blob      name of the blob
     * @param Models\SetBlobPropertiesOptions $options   optional parameters
     *
     * @return Models\SetBlobPropertiesResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691966.aspx
     */
    public function setBlobProperties($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\SetBlobPropertiesOptions $options = null)
    {
        return $this->setBlobPropertiesAsync($container, $blob, $options)->wait();
    }
    /**
     * Creates promise to set system properties defined for a blob.
     *
     * @param string                          $container name of the container
     * @param string                          $blob      name of the blob
     * @param Models\SetBlobPropertiesOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691966.aspx
     */
    public function setBlobPropertiesAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\SetBlobPropertiesOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container, $blob);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\SetBlobPropertiesOptions();
        }
        $blobContentType = $options->getContentType();
        $blobContentEncoding = $options->getContentEncoding();
        $blobContentLanguage = $options->getContentLanguage();
        $blobContentLength = $options->getContentLength();
        $blobContentMD5 = $options->getContentMD5();
        $blobCacheControl = $options->getCacheControl();
        $blobContentDisposition = $options->getContentDisposition();
        $leaseId = $options->getLeaseId();
        $sNumberAction = $options->getSequenceNumberAction();
        $sNumber = $options->getSequenceNumber();
        $headers = $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $leaseId);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CACHE_CONTROL, $blobCacheControl);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONTENT_DISPOSITION, $blobContentDisposition);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONTENT_TYPE, $blobContentType);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONTENT_ENCODING, $blobContentEncoding);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONTENT_LANGUAGE, $blobContentLanguage);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONTENT_LENGTH, $blobContentLength);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_CONTENT_MD5, $blobContentMD5);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_SEQUENCE_NUMBER_ACTION, $sNumberAction);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_BLOB_SEQUENCE_NUMBER, $sNumber);
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'properties');
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options)->then(function ($response) {
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\SetBlobPropertiesResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()));
        }, null);
    }
    /**
     * Sets metadata headers on the blob.
     *
     * @param string                        $container name of the container
     * @param string                        $blob      name of the blob
     * @param array                         $metadata  key/value pair representation
     * @param Models\BlobServiceOptions     $options   optional parameters
     *
     * @return Models\SetBlobMetadataResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179414.aspx
     */
    public function setBlobMetadata($container, $blob, array $metadata, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        return $this->setBlobMetadataAsync($container, $blob, $metadata, $options)->wait();
    }
    /**
     * Creates promise to set metadata headers on the blob.
     *
     * @param string                        $container name of the container
     * @param string                        $blob      name of the blob
     * @param array                         $metadata  key/value pair representation
     * @param Models\BlobServiceOptions     $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179414.aspx
     */
    public function setBlobMetadataAsync($container, $blob, array $metadata, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::validateMetadata($metadata);
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container, $blob);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions();
        }
        $headers = $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        $headers = $this->addMetadataHeaders($headers, $metadata);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'metadata');
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options)->then(function ($response) {
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\SetBlobMetadataResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()));
        }, null);
    }
    /**
     * Downloads a blob to a file, the result contains its metadata and
     * properties. The result will not contain a stream pointing to the
     * content of the file.
     *
     * @param string                $path      The path and name of the file
     * @param string                $container name of the container
     * @param string                $blob      name of the blob
     * @param Models\GetBlobOptions $options   optional parameters
     *
     * @return Models\GetBlobResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179440.aspx
     */
    public function saveBlobToFile($path, $container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobOptions $options = null)
    {
        return $this->saveBlobToFileAsync($path, $container, $blob, $options)->wait();
    }
    /**
     * Creates promise to download a blob to a file, the result contains its
     * metadata and properties. The result will not contain a stream pointing
     * to the content of the file.
     *
     * @param string                $path      The path and name of the file
     * @param string                $container name of the container
     * @param string                $blob      name of the blob
     * @param Models\GetBlobOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     * @throws \Exception
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179440.aspx
     */
    public function saveBlobToFileAsync($path, $container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobOptions $options = null)
    {
        $resource = \fopen($path, 'w+');
        if ($resource == null) {
            throw new \Exception(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::ERROR_FILE_COULD_NOT_BE_OPENED);
        }
        return $this->getBlobAsync($container, $blob, $options)->then(function ($result) use($path, $resource) {
            $content = $result->getContentStream();
            while (!\feof($content)) {
                \fwrite($resource, \stream_get_contents($content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::MB_IN_BYTES_4));
            }
            $content = null;
            \fclose($resource);
            return $result;
        }, null);
    }
    /**
     * Reads or downloads a blob from the system, including its metadata and
     * properties.
     *
     * @param string                $container name of the container
     * @param string                $blob      name of the blob
     * @param Models\GetBlobOptions $options   optional parameters
     *
     * @return Models\GetBlobResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179440.aspx
     */
    public function getBlob($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobOptions $options = null)
    {
        return $this->getBlobAsync($container, $blob, $options)->wait();
    }
    /**
     * Creates promise to read or download a blob from the system, including its
     * metadata and properties.
     *
     * @param string                $container name of the container
     * @param string                $blob      name of the blob
     * @param Models\GetBlobOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179440.aspx
     */
    public function getBlobAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_GET;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container, $blob);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobOptions();
        }
        $getMD5 = $options->getRangeGetContentMD5();
        $headers = $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        $range = $options->getRange();
        if ($range) {
            $headers = $this->addOptionalRangeHeader($headers, $range->getStart(), $range->getEnd());
        }
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_RANGE_GET_CONTENT_MD5, $getMD5 ? 'true' : null);
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_SNAPSHOT, $options->getSnapshot());
        $options->setIsStreaming(\true);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, array(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_PARTIAL_CONTENT), \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options)->then(function ($response) {
            $metadata = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::getMetadataArray(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()));
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\GetBlobResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()), $response->getBody(), $metadata);
        });
    }
    /**
     * Undeletes a blob.
     *
     * @param string                      $container name of the container
     * @param string                      $blob      name of the blob
     * @param Models\UndeleteBlobOptions  $options   optional parameters
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/undelete-blob
     */
    public function undeleteBlob($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\UndeleteBlobOptions $options = null)
    {
        $this->undeleteBlobAsync($container, $blob, $options)->wait();
    }
    /**
     * Undeletes a blob.
     *
     * @param string                      $container name of the container
     * @param string                      $blob      name of the blob
     * @param Models\UndeleteBlobOptions  $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/undelete-blob
     */
    public function undeleteBlobAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\UndeleteBlobOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container, $blob);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\UndeleteBlobOptions();
        }
        $leaseId = $options->getLeaseId();
        $headers = $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $leaseId);
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'undelete');
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options);
    }
    /**
     * Deletes a blob or blob snapshot.
     *
     * Note that if the snapshot entry is specified in the $options then only this
     * blob snapshot is deleted. To delete all blob snapshots, do not set Snapshot
     * and just set getDeleteSnaphotsOnly to true.
     *
     * @param string                   $container name of the container
     * @param string                   $blob      name of the blob
     * @param Models\DeleteBlobOptions $options   optional parameters
     *
     * @return void
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179413.aspx
     */
    public function deleteBlob($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\DeleteBlobOptions $options = null)
    {
        $this->deleteBlobAsync($container, $blob, $options)->wait();
    }
    /**
     * Creates promise to delete a blob or blob snapshot.
     *
     * Note that if the snapshot entry is specified in the $options then only this
     * blob snapshot is deleted. To delete all blob snapshots, do not set Snapshot
     * and just set getDeleteSnaphotsOnly to true.
     *
     * @param string                   $container name of the container
     * @param string                   $blob      name of the blob
     * @param Models\DeleteBlobOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd179413.aspx
     */
    public function deleteBlobAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\DeleteBlobOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_DELETE;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container, $blob);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\DeleteBlobOptions();
        }
        if (\is_null($options->getSnapshot())) {
            $delSnapshots = $options->getDeleteSnaphotsOnly() ? 'only' : 'include';
            $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_DELETE_SNAPSHOTS, $delSnapshots);
        } else {
            $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_SNAPSHOT, $options->getSnapshot());
        }
        $headers = $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_ACCEPTED, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options);
    }
    /**
     * Creates a snapshot of a blob.
     *
     * @param string                           $container The name of the container.
     * @param string                           $blob      The name of the blob.
     * @param Models\CreateBlobSnapshotOptions $options   The optional parameters.
     *
     * @return Models\CreateBlobSnapshotResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691971.aspx
     */
    public function createBlobSnapshot($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobSnapshotOptions $options = null)
    {
        return $this->createBlobSnapshotAsync($container, $blob, $options)->wait();
    }
    /**
     * Creates promise to create a snapshot of a blob.
     *
     * @param string                           $container The name of the container.
     * @param string                           $blob      The name of the blob.
     * @param Models\CreateBlobSnapshotOptions $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691971.aspx
     */
    public function createBlobSnapshotAsync($container, $blob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobSnapshotOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($container, $blob);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobSnapshotOptions();
        }
        $queryParams[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP] = 'snapshot';
        $headers = $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        $headers = $this->addMetadataHeaders($headers, $options->getMetadata());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_CREATED, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options)->then(function ($response) {
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CreateBlobSnapshotResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()));
        }, null);
    }
    /**
     * Copies a source blob to a destination blob within the same storage account.
     *
     * @param string                 $destinationContainer name of the destination
     * container
     * @param string                 $destinationBlob      name of the destination
     * blob
     * @param string                 $sourceContainer      name of the source
     * container
     * @param string                 $sourceBlob           name of the source
     * blob
     * @param Models\CopyBlobOptions $options              optional parameters
     *
     * @return Models\CopyBlobResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd894037.aspx
     */
    public function copyBlob($destinationContainer, $destinationBlob, $sourceContainer, $sourceBlob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CopyBlobOptions $options = null)
    {
        return $this->copyBlobAsync($destinationContainer, $destinationBlob, $sourceContainer, $sourceBlob, $options)->wait();
    }
    /**
     * Creates promise to copy a source blob to a destination blob within the
     * same storage account.
     *
     * @param string                 $destinationContainer name of the destination
     * container
     * @param string                 $destinationBlob      name of the destination
     * blob
     * @param string                 $sourceContainer      name of the source
     * container
     * @param string                 $sourceBlob           name of the source
     * blob
     * @param Models\CopyBlobOptions $options              optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd894037.aspx
     */
    public function copyBlobAsync($destinationContainer, $destinationBlob, $sourceContainer, $sourceBlob, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CopyBlobOptions $options = null)
    {
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CopyBlobOptions();
        }
        $sourceBlobPath = $this->getCopyBlobSourceName($sourceContainer, $sourceBlob, $options);
        return $this->copyBlobFromURLAsync($destinationContainer, $destinationBlob, $sourceBlobPath, $options);
    }
    /**
     * Copies from a source URL to a destination blob.
     *
     * @param string                        $destinationContainer name of the
     *                                                            destination
     *                                                            container
     * @param string                        $destinationBlob      name of the
     *                                                            destination
     *                                                            blob
     * @param string                        $sourceURL            URL of the
     *                                                            source
     *                                                            resource
     * @param Models\CopyBlobFromURLOptions $options              optional
     *                                                            parameters
     *
     * @return Models\CopyBlobResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd894037.aspx
     */
    public function copyBlobFromURL($destinationContainer, $destinationBlob, $sourceURL, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CopyBlobFromURLOptions $options = null)
    {
        return $this->copyBlobFromURLAsync($destinationContainer, $destinationBlob, $sourceURL, $options)->wait();
    }
    /**
     * Creates promise to copy from source URL to a destination blob.
     *
     * @param string                        $destinationContainer name of the
     *                                                            destination
     *                                                            container
     * @param string                        $destinationBlob      name of the
     *                                                            destination
     *                                                            blob
     * @param string                        $sourceURL            URL of the
     *                                                            source
     *                                                            resource
     * @param Models\CopyBlobFromURLOptions $options              optional
     *                                                            parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/dd894037.aspx
     */
    public function copyBlobFromURLAsync($destinationContainer, $destinationBlob, $sourceURL, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CopyBlobFromURLOptions $options = null)
    {
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $destinationBlobPath = $this->createPath($destinationContainer, $destinationBlob);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CopyBlobFromURLOptions();
        }
        if ($options->getIsIncrementalCopy()) {
            $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'incrementalcopy');
        }
        $headers = $this->addOptionalAccessConditionHeader($headers, $options->getAccessConditions());
        $headers = $this->addOptionalSourceAccessConditionHeader($headers, $options->getSourceAccessConditions());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_COPY_SOURCE, $sourceURL);
        $headers = $this->addMetadataHeaders($headers, $options->getMetadata());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_SOURCE_LEASE_ID, $options->getSourceLeaseId());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_ACCESS_TIER, $options->getAccessTier());
        $options->setLocationMode(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $destinationBlobPath, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_ACCEPTED, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options)->then(function ($response) {
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\CopyBlobResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()));
        }, null);
    }
    /**
     * Abort a blob copy operation
     *
     * @param string                        $container            name of the container
     * @param string                        $blob                 name of the blob
     * @param string                        $copyId               copy operation identifier.
     * @param Models\BlobServiceOptions     $options              optional parameters
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/abort-copy-blob
     */
    public function abortCopy($container, $blob, $copyId, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        return $this->abortCopyAsync($container, $blob, $copyId, $options)->wait();
    }
    /**
     * Creates promise to abort a blob copy operation
     *
     * @param string                        $container            name of the container
     * @param string                        $blob                 name of the blob
     * @param string                        $copyId               copy operation identifier.
     * @param Models\BlobServiceOptions     $options              optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/abort-copy-blob
     */
    public function abortCopyAsync($container, $blob, $copyId, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($copyId, 'copyId');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($container, 'container');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($blob, 'blob');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($copyId, 'copyId');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::HTTP_PUT;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $destinationBlobPath = $this->createPath($container, $blob);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_TIMEOUT, $options->getTimeout());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COMP, 'copy');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::QP_COPY_ID, $copyId);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_LEASE_ID, $options->getLeaseId());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_COPY_ACTION, 'abort');
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $destinationBlobPath, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::STATUS_NO_CONTENT, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING, $options);
    }
    /**
     * Establishes an exclusive write lock on a blob. To write to a locked
     * blob, a client must provide a lease ID.
     *
     * @param string                     $container         name of the container
     * @param string                     $blob              name of the blob
     * @param string                     $proposedLeaseId   lease id when acquiring
     * @param int                        $leaseDuration     the lease duration.
     *                                                      A non-infinite
     *                                                      lease can be between
     *                                                      15 and 60 seconds.
     *                                                      Default is never
     *                                                      to expire.
     * @param Models\BlobServiceOptions  $options           optional parameters
     *
     * @return Models\LeaseResult
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691972.aspx
     */
    public function acquireLease($container, $blob, $proposedLeaseId = null, $leaseDuration = null, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        return $this->acquireLeaseAsync($container, $blob, $proposedLeaseId, $leaseDuration, $options)->wait();
    }
    /**
     * Creates promise to establish an exclusive one-minute write lock on a blob.
     * To write to a locked blob, a client must provide a lease ID.
     *
     * @param string                     $container         name of the container
     * @param string                     $blob              name of the blob
     * @param string                     $proposedLeaseId   lease id when acquiring
     * @param int                        $leaseDuration     the lease duration.
     *                                                      A non-infinite
     *                                                      lease can be between
     *                                                      15 and 60 seconds.
     *                                                      Default is never to
     *                                                      expire.
     * @param Models\BlobServiceOptions  $options           optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee691972.aspx
     */
    public function acquireLeaseAsync($container, $blob, $proposedLeaseId = null, $leaseDuration = null, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        if ($options === null) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions();
        }
        if ($leaseDuration === null) {
            $leaseDuration = -1;
        }
        return $this->putLeaseAsyncImpl(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseMode::ACQUIRE_ACTION, $container, $blob, $proposedLeaseId, $leaseDuration, null, null, self::getStatusCodeOfLeaseAction(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseMode::ACQUIRE_ACTION), $options, $options->getAccessConditions())->then(function ($response) {
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()));
        }, null);
    }
    /**
     * change an existing lease
     *
     * @param string                    $container         name of the container
     * @param string                    $blob              name of the blob
     * @param string                    $leaseId           lease id when acquiring
     * @param string                    $proposedLeaseId   lease id when acquiring
     * @param Models\BlobServiceOptions $options           optional parameters
     *
     * @return Models\LeaseResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/lease-blob
     */
    public function changeLease($container, $blob, $leaseId, $proposedLeaseId, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        return $this->changeLeaseAsync($container, $blob, $leaseId, $proposedLeaseId, $options)->wait();
    }
    /**
     * Creates promise to change an existing lease
     *
     * @param string                    $container         name of the container
     * @param string                    $blob              name of the blob
     * @param string                    $leaseId           lease id when acquiring
     * @param string                    $proposedLeaseId   the proposed lease id
     * @param Models\BlobServiceOptions $options           optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/lease-blob
     */
    public function changeLeaseAsync($container, $blob, $leaseId, $proposedLeaseId, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        return $this->putLeaseAsyncImpl(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseMode::CHANGE_ACTION, $container, $blob, $proposedLeaseId, null, $leaseId, null, self::getStatusCodeOfLeaseAction(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseMode::RENEW_ACTION), \is_null($options) ? new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions() : $options)->then(function ($response) {
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()));
        }, null);
    }
    /**
     * Renews an existing lease
     *
     * @param string                    $container name of the container
     * @param string                    $blob      name of the blob
     * @param string                    $leaseId   lease id when acquiring
     * @param Models\BlobServiceOptions $options   optional parameters
     *
     * @return Models\LeaseResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/lease-blob
     */
    public function renewLease($container, $blob, $leaseId, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        return $this->renewLeaseAsync($container, $blob, $leaseId, $options)->wait();
    }
    /**
     * Creates promise to renew an existing lease
     *
     * @param string                    $container name of the container
     * @param string                    $blob      name of the blob
     * @param string                    $leaseId   lease id when acquiring
     * @param Models\BlobServiceOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/lease-blob
     */
    public function renewLeaseAsync($container, $blob, $leaseId, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        return $this->putLeaseAsyncImpl(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseMode::RENEW_ACTION, $container, $blob, null, null, $leaseId, null, self::getStatusCodeOfLeaseAction(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseMode::RENEW_ACTION), \is_null($options) ? new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions() : $options)->then(function ($response) {
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()));
        }, null);
    }
    /**
     * Frees the lease if it is no longer needed so that another client may
     * immediately acquire a lease against the blob.
     *
     * @param string                    $container name of the container
     * @param string                    $blob      name of the blob
     * @param string                    $leaseId   lease id when acquiring
     * @param Models\BlobServiceOptions $options   optional parameters
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/lease-blob
     */
    public function releaseLease($container, $blob, $leaseId, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        $this->releaseLeaseAsync($container, $blob, $leaseId, $options)->wait();
    }
    /**
     * Creates promise to free the lease if it is no longer needed so that
     * another client may immediately acquire a lease against the blob.
     *
     * @param string                    $container name of the container
     * @param string                    $blob      name of the blob
     * @param string                    $leaseId   lease id when acquiring
     * @param Models\BlobServiceOptions $options   optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/lease-blob
     */
    public function releaseLeaseAsync($container, $blob, $leaseId, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        return $this->putLeaseAsyncImpl(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseMode::RELEASE_ACTION, $container, $blob, null, null, $leaseId, null, self::getStatusCodeOfLeaseAction(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseMode::RELEASE_ACTION), \is_null($options) ? new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions() : $options);
    }
    /**
     * Ends the lease but ensure that another client cannot acquire a new lease until
     * the current lease period has expired.
     *
     * @param string                    $container     name of the container
     * @param string                    $blob          name of the blob
     * @param int                       $breakPeriod   the proposed duration of seconds that
     *                                                 lease should continue before it it broken,
     *                                                 between 0 and 60 seconds.
     * @param Models\BlobServiceOptions $options   optional parameters
     *
     * @return BreakLeaseResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/lease-blob
     */
    public function breakLease($container, $blob, $breakPeriod = null, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        return $this->breakLeaseAsync($container, $blob, $breakPeriod, $options)->wait();
    }
    /**
     * Creates promise to end the lease but ensure that another client cannot
     * acquire a new lease until the current lease period has expired.
     *
     * @param string                    $container   name of the container
     * @param string                    $blob        name of the blob
     * @param int                       $breakPeriod break period, in seconds
     * @param Models\BlobServiceOptions $options     optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/lease-blob
     */
    public function breakLeaseAsync($container, $blob, $breakPeriod = null, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions $options = null)
    {
        return $this->putLeaseAsyncImpl(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseMode::BREAK_ACTION, $container, $blob, null, null, null, $breakPeriod, self::getStatusCodeOfLeaseAction(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\LeaseMode::BREAK_ACTION), \is_null($options) ? new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BlobServiceOptions() : $options)->then(function ($response) {
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Models\BreakLeaseResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()));
        }, null);
    }
    /**
     * Adds optional header to headers if set
     *
     * @param array                  $headers         The array of request headers.
     * @param Models\AccessCondition $accessCondition The access condition object.
     *
     * @return array
     */
    public function addOptionalAccessConditionHeader(array $headers, array $accessConditions = null)
    {
        if (!empty($accessConditions)) {
            foreach ($accessConditions as $accessCondition) {
                if (!\is_null($accessCondition)) {
                    $header = $accessCondition->getHeader();
                    if ($header != \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::EMPTY_STRING) {
                        $value = $accessCondition->getValue();
                        if ($value instanceof \DateTime) {
                            $value = \gmdate(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::AZURE_DATE_FORMAT, $value->getTimestamp());
                        }
                        $headers[$header] = $value;
                    }
                }
            }
        }
        return $headers;
    }
    /**
     * Adds optional header to headers if set
     *
     * @param array $headers         The array of request headers.
     * @param array $accessCondition The access condition object.
     *
     * @return array
     */
    public function addOptionalSourceAccessConditionHeader(array $headers, array $accessConditions = null)
    {
        if (!empty($accessConditions)) {
            foreach ($accessConditions as $accessCondition) {
                if (!\is_null($accessCondition)) {
                    $header = $accessCondition->getHeader();
                    $headerName = null;
                    if (!empty($header)) {
                        switch ($header) {
                            case \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::IF_MATCH:
                                $headerName = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_SOURCE_IF_MATCH;
                                break;
                            case \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::IF_UNMODIFIED_SINCE:
                                $headerName = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_SOURCE_IF_UNMODIFIED_SINCE;
                                break;
                            case \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::IF_MODIFIED_SINCE:
                                $headerName = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_SOURCE_IF_MODIFIED_SINCE;
                                break;
                            case \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::IF_NONE_MATCH:
                                $headerName = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::X_MS_SOURCE_IF_NONE_MATCH;
                                break;
                            default:
                                throw new \Exception(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::INVALID_ACH_MSG);
                                break;
                        }
                    }
                    $value = $accessCondition->getValue();
                    if ($value instanceof \DateTime) {
                        $value = \gmdate(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Blob\Internal\BlobResources::AZURE_DATE_FORMAT, $value->getTimestamp());
                    }
                    $this->addOptionalHeader($headers, $headerName, $value);
                }
            }
        }
        return $headers;
    }
}
