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
 * @package   MicrosoftAzure\Storage\File
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2017 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
namespace Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File;

use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Authentication\SharedAccessSignatureAuthScheme;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Authentication\SharedKeyAuthScheme;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Middlewares\CommonRequestMiddleware;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Serialization\XmlSerializer;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\StorageServiceSettings;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources as Resources;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\IFile;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\ServiceRestProxy;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\ServiceRestTrait;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\CreateFileFromContentOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ShareACL;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ListSharesOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ListSharesResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\CreateShareOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\CreateDirectoryOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\GetShareACLResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\GetSharePropertiesResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\GetShareStatsResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ListDirectoriesAndFilesOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ListDirectoriesAndFilesResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\GetDirectoryPropertiesResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\GetDirectoryMetadataResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\GetFileMetadataResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\CreateFileOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileProperties;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\PutFileRangeOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\GetFileOptions;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\GetFileResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ListFileRangesResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\CopyFileResult;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter;
use Dekode\GravityForms\Vendor\Psr\Http\Message\StreamInterface;
use Dekode\GravityForms\Vendor\GuzzleHttp\Psr7;
/**
 * This class constructs HTTP requests and receive HTTP responses for File
 * service layer.
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\File
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2017 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class FileRestProxy extends \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\ServiceRestProxy implements \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\IFile
{
    use ServiceRestTrait;
    /**
     * Builds a file service object, it accepts the following
     * options:
     *
     * - http: (array) the underlying guzzle options. refer to
     *   http://docs.guzzlephp.org/en/latest/request-options.html for detailed available options
     * - middlewares: (mixed) the middleware should be either an instance of a sub-class that
     *   implements {@see MicrosoftAzure\Storage\Common\Middlewares\IMiddleware}, or a
     *   `callable` that follows the Guzzle middleware implementation convention
     *
     * Please refer to
     * https://azure.microsoft.com/en-us/documentation/articles/storage-configure-connection-string
     * for how to construct a connection string with storage account name/key, or with a shared
     * access signature (SAS Token).
     *
     * @param string $connectionString The configuration connection string.
     * @param array  $options          Array of options to pass to the service
     * @return FileRestProxy
     */
    public static function createFileService($connectionString, array $options = [])
    {
        $settings = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\StorageServiceSettings::createFromConnectionString($connectionString);
        $primaryUri = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryAddUrlScheme($settings->getFileEndpointUri());
        $secondaryUri = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryAddUrlScheme($settings->getFileSecondaryEndpointUri());
        $fileWrapper = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\FileRestProxy($primaryUri, $secondaryUri, $settings->getName(), $options);
        // Getting authentication scheme
        if ($settings->hasSasToken()) {
            $authScheme = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Authentication\SharedAccessSignatureAuthScheme($settings->getSasToken());
        } else {
            $authScheme = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Authentication\SharedKeyAuthScheme($settings->getName(), $settings->getKey());
        }
        // Adding common request middleware
        $commonRequestMiddleware = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Middlewares\CommonRequestMiddleware($authScheme, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STORAGE_API_LATEST_VERSION, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::FILE_SDK_VERSION);
        $fileWrapper->pushMiddleware($commonRequestMiddleware);
        return $fileWrapper;
    }
    /**
     * Creates URI path for file or share.
     *
     * @param string $share      The share name.
     * @param string $directory  The directory name.
     *
     * @return string
     */
    private function createPath($share, $directory = '')
    {
        if (empty($directory) && $directory != '0') {
            return empty($share) ? '/' : $share;
        }
        $encodedFile = \urlencode($directory);
        // Unencode the forward slashes to match what the server expects.
        $encodedFile = \str_replace('%2F', '/', $encodedFile);
        // Unencode the backward slashes to match what the server expects.
        $encodedFile = \str_replace('%5C', '/', $encodedFile);
        // Re-encode the spaces (encoded as space) to the % encoding.
        $encodedFile = \str_replace('+', '%20', $encodedFile);
        // Empty share means accessing default share
        if (empty($share)) {
            return $encodedFile;
        }
        return '/' . $share . '/' . $encodedFile;
    }
    /**
     * Helper method to create promise for getShareProperties API call.
     *
     * @param string             $share     The share name.
     * @param FileServiceOptions $options   The optional parameters.
     * @param string             $operation The operation string. Should be
     *                                      'metadata' to set metadata,
     *                                      and 'properties' to set
     *                                      properties.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    private function getSharePropertiesAsyncImpl($share, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null, $operation = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isTrue($operation == 'properties' || $operation == 'metadata', \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::FILE_SHARE_PROPERTIES_OPERATION_INVALID);
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_GET;
        $headers = array();
        $queryParams = array();
        $postParams = array();
        $path = $this->createPath($share);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_REST_TYPE, 'share');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        if ($operation == 'metadata') {
            $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_COMP, $operation);
        }
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options)->then(function ($response) {
            $responseHeaders = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\GetSharePropertiesResult::create($responseHeaders);
        }, null);
    }
    /**
     * Helper method to create promise for setShareProperties API call.
     *
     * @param string             $share      The share name.
     * @param array              $properties The array that contains
     *                                       either the properties or
     *                                       the metadata to be set.
     * @param FileServiceOptions $options    The optional parameters.
     * @param string             $operation  The operation string. Should be
     *                                       'metadata' to set metadata,
     *                                       and 'properties' to set
     *                                       properties.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    private function setSharePropertiesAsyncImpl($share, array $properties, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null, $operation = 'properties')
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isTrue($operation == 'properties' || $operation == 'metadata', \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::FILE_SHARE_PROPERTIES_OPERATION_INVALID);
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        $headers = array();
        if ($operation == 'properties') {
            $headers[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_SHARE_QUOTA] = $properties[\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_SHARE_QUOTA];
        } else {
            \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::validateMetadata($properties);
            $headers = $this->generateMetadataHeaders($properties);
        }
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_PUT;
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($share);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_REST_TYPE, 'share');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_COMP, $operation);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options);
    }
    /**
     * Creates promise to write range of bytes (more than 4MB) to a file.
     *
     * @param  string                   $share   The share name.
     * @param  string                   $path    The path of the file.
     * @param  StreamInterface          $content The content to be uploaded.
     * @param  Range                    $range   The range in the file to be put.
     *                                           4MB length min.
     * @param  PutFileRangeOptions|null $options The optional parameters.
     * @param  boolean                  $useTransactionalMD5
     *                                           Optional. Whether enable transactional
     *                                           MD5 validation during uploading.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/put-range
     *
     */
    private function multiplePutRangeConcurrentAsync($share, $path, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range $range, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\PutFileRangeOptions $options = null, $useTransactionalMD5 = \false)
    {
        $queryParams = array();
        $headers = array();
        $path = $this->createPath($share, $path);
        $selfInstance = $this;
        if ($options == null) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\PutFileRangeOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_COMP, 'range');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_WRITE, 'Update');
        $counter = 0;
        //create the generator for requests.
        $generator = function () use($headers, $path, $content, &$counter, $queryParams, $range, $useTransactionalMD5, $selfInstance) {
            $size = 0;
            $chunkContent = '';
            $start = 0;
            do {
                $start = $range->getStart() + \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::MB_IN_BYTES_4 * $counter++;
                $end = $range->getEnd();
                if ($end != null && $start >= $end) {
                    return null;
                }
                $chunkContent = $content->read(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::MB_IN_BYTES_4);
                $size = \strlen($chunkContent);
                if ($size == 0) {
                    return null;
                }
            } while (\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::allZero($chunkContent));
            $chunkRange = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range($start);
            $chunkRange->setLength($size);
            $selfInstance->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_RANGE, $chunkRange->getRangeString());
            $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::CONTENT_LENGTH, $size);
            if ($useTransactionalMD5) {
                $contentMD5 = \base64_encode(\md5($chunkContent, \true));
                $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::CONTENT_MD5, $contentMD5);
            }
            return $selfInstance->createRequest(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_PUT, $headers, $queryParams, array(), $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\LocationMode::PRIMARY_ONLY, $chunkContent);
        };
        return $this->sendConcurrentAsync($generator, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_CREATED, $options);
    }
    /**
     * Returns a list of the shares under the specified account
     *
     * @param  ListSharesOptions|null $options The optional parameters
     *
     * @return ListSharesResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/list-shares
     */
    public function listShares(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ListSharesOptions $options = null)
    {
        return $this->listSharesAsync($options)->wait();
    }
    /**
     * Create a promise to return a list of the shares under the specified account
     *
     * @param  ListSharesOptions|null $options The optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/list-shares
     */
    public function listSharesAsync(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ListSharesOptions $options = null)
    {
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_GET;
        $headers = array();
        $queryParams = array();
        $postParams = array();
        $path = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING;
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ListSharesOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_COMP, 'list');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_PREFIX_LOWERCASE, $options->getPrefix());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_MARKER_LOWERCASE, $options->getNextMarker());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_MAX_RESULTS_LOWERCASE, $options->getMaxResults());
        $isInclude = $options->getIncludeMetadata();
        $isInclude = $isInclude ? 'metadata' : null;
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_INCLUDE, $isInclude);
        $dataSerializer = $this->dataSerializer;
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options)->then(function ($response) use($dataSerializer) {
            $parsed = $dataSerializer->unserialize($response->getBody());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ListSharesResult::create($parsed, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::getLocationFromHeaders($response->getHeaders()));
        });
    }
    /**
     * Creates a new share in the given storage account.
     *
     * @param string                  $share   The share name.
     * @param CreateShareOptions|null $options The optional parameters.
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/create-share
     */
    public function createShare($share, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\CreateShareOptions $options = null)
    {
        $this->createShareAsync($share, $options)->wait();
    }
    /**
     * Creates promise to create a new share in the given storage account.
     *
     * @param string                  $share   The share name.
     * @param CreateShareOptions|null $options The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/create-share
     */
    public function createShareAsync($share, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\CreateShareOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($share, 'share');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_PUT;
        $postParams = array();
        $queryParams = array(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_REST_TYPE => 'share');
        $path = $this->createPath($share);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\CreateShareOptions();
        }
        $metadata = $options->getMetadata();
        $headers = $this->generateMetadataHeaders($metadata);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_SHARE_QUOTA, $options->getQuota());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_CREATED, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options);
    }
    /**
     * Deletes a share in the given storage account.
     *
     * @param string                  $share   name of the share
     * @param FileServiceOptions|null $options optional parameters
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/delete-share
     */
    public function deleteShare($share, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        $this->deleteShareAsync($share, $options)->wait();
    }
    /**
     * Create a promise for deleting a share.
     *
     * @param string                  $share   name of the share
     * @param FileServiceOptions|null $options optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/delete-share
     */
    public function deleteShareAsync($share, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($share, 'share');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_DELETE;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($share);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_REST_TYPE, 'share');
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_ACCEPTED, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options);
    }
    /**
     * Returns all properties and metadata on the share.
     *
     * @param string                  $share   name
     * @param FileServiceOptions|null $options optional parameters
     *
     * @return GetSharePropertiesResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-share-properties
     */
    public function getShareProperties($share, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        return $this->getSharePropertiesAsync($share, $options)->wait();
    }
    /**
     * Create promise to return all properties and metadata on the share.
     *
     * @param string                  $share   name
     * @param FileServiceOptions|null $options optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-share-properties
     */
    public function getSharePropertiesAsync($share, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        return $this->getSharePropertiesAsyncImpl($share, $options, 'properties');
    }
    /**
     * Sets quota of the share.
     *
     * @param string                  $share   name
     * @param int                     $quota   quota of the share
     * @param FileServiceOptions|null $options optional parameters
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/set-share-properties
     */
    public function setShareProperties($share, $quota, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        $this->setSharePropertiesAsync($share, $quota, $options)->wait();
    }
    /**
     * Creates promise to set quota the share.
     *
     * @param string                  $share   name
     * @param int                     $quota   quota of the share
     * @param FileServiceOptions|null $options optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/set-share-properties
     */
    public function setSharePropertiesAsync($share, $quota, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        return $this->setSharePropertiesAsyncImpl($share, [\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_SHARE_QUOTA => $quota], $options, 'properties');
    }
    /**
     * Returns only user-defined metadata for the specified share.
     *
     * @param string                  $share   name
     * @param FileServiceOptions|null $options optional parameters
     *
     * @return GetSharePropertiesResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-share-metadata
     */
    public function getShareMetadata($share, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        return $this->getShareMetadataAsync($share, $options)->wait();
    }
    /**
     * Create promise to return only user-defined metadata for the specified
     * share.
     *
     * @param string                  $share   name
     * @param FileServiceOptions|null $options optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-share-metadata
     */
    public function getShareMetadataAsync($share, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        return $this->getSharePropertiesAsyncImpl($share, $options, 'metadata');
    }
    /**
     * Updates metadata of the share.
     *
     * @param string                  $share    name
     * @param array                   $metadata metadata key/value pair.
     * @param FileServiceOptions|null $options optional  parameters
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/set-share-metadata
     */
    public function setShareMetadata($share, array $metadata, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        $this->setShareMetadataAsync($share, $metadata, $options)->wait();
    }
    /**
     * Creates promise to update metadata headers on the share.
     *
     * @param string                  $share    name
     * @param array                   $metadata metadata key/value pair.
     * @param FileServiceOptions|null $options optional  parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/set-share-metadata
     */
    public function setShareMetadataAsync($share, array $metadata, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        return $this->setSharePropertiesAsyncImpl($share, $metadata, $options, 'metadata');
    }
    /**
     * Gets the access control list (ACL) for the share.
     *
     * @param string                  $share The share name.
     * @param FileServiceOptions|null $options   The optional parameters.
     *
     * @return GetShareACLResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-share-acl
     */
    public function getShareAcl($share, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        return $this->getShareAclAsync($share, $options)->wait();
    }
    /**
     * Creates the promise to get the access control list (ACL) for the share.
     *
     * @param string                  $share The share name.
     * @param FileServiceOptions|null $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-share-acl
     */
    public function getShareAclAsync($share, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_GET;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($share);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_REST_TYPE, 'share');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_COMP, 'acl');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        $dataSerializer = $this->dataSerializer;
        $promise = $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options);
        return $promise->then(function ($response) use($dataSerializer) {
            $responseHeaders = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders());
            $etag = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($responseHeaders, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::ETAG);
            $modified = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($responseHeaders, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::LAST_MODIFIED);
            $modifiedDate = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::convertToDateTime($modified);
            $parsed = $dataSerializer->unserialize($response->getBody());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\GetShareACLResult::create($etag, $modifiedDate, $parsed);
        }, null);
    }
    /**
     * Sets the ACL and any share-level access policies for the share.
     *
     * @param string                  $share   name
     * @param ShareACL                $acl     access control list for share
     * @param FileServiceOptions|null $options optional parameters
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/set-share-acl
     */
    public function setShareAcl($share, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ShareACL $acl, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        $this->setShareAclAsync($share, $acl, $options)->wait();
    }
    /**
     * Creates promise to set the ACL and any share-level access policies
     * for the share.
     *
     * @param string                  $share   name
     * @param ShareACL                $acl     access control list for share
     * @param FileServiceOptions|null $options optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/set-share-acl
     */
    public function setShareAclAsync($share, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ShareACL $acl, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($acl, 'acl');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_PUT;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($share);
        $body = $acl->toXml($this->dataSerializer);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_REST_TYPE, 'share');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_COMP, 'acl');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::CONTENT_TYPE, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::URL_ENCODED_CONTENT_TYPE);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_OK, $body, $options);
    }
    /**
     * Get the statistics related to the share.
     *
     * @param  string                  $share   The name of the share.
     * @param  FileServiceOptions|null $options The request options.
     *
     * @return GetShareStatsResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-share-stats
     */
    public function getShareStats($share, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        return $this->getShareStatsAsync($share, $options)->wait();
    }
    /**
     * Get the statistics related to the share.
     *
     * @param  string                  $share   The name of the share.
     * @param  FileServiceOptions|null $options The request options.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-share-stats
     */
    public function getShareStatsAsync($share, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_GET;
        $headers = array();
        $queryParams = array();
        $postParams = array();
        $path = $this->createPath($share);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_REST_TYPE, 'share');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_COMP, 'stats');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        $dataSerializer = $this->dataSerializer;
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options)->then(function ($response) use($dataSerializer) {
            $parsed = $dataSerializer->unserialize($response->getBody());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\GetShareStatsResult::create($parsed);
        }, null);
    }
    /**
     * List directories and files under specified path.
     *
     * @param  string                              $share   The share that
     *                                                      contains all the
     *                                                      files and directories.
     * @param  string                              $path    The path to be listed.
     * @param  ListDirectoriesAndFilesOptions|null $options Optional parameters.
     *
     * @return ListDirectoriesAndFilesResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/list-directories-and-files
     */
    public function listDirectoriesAndFiles($share, $path = '', \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ListDirectoriesAndFilesOptions $options = null)
    {
        return $this->listDirectoriesAndFilesAsync($share, $path, $options)->wait();
    }
    /**
     * Creates promise to list directories and files under specified path.
     *
     * @param  string                              $share   The share that
     *                                                      contains all the
     *                                                      files and directories.
     * @param  string                              $path    The path to be listed.
     * @param  ListDirectoriesAndFilesOptions|null $options Optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/list-directories-and-files
     */
    public function listDirectoriesAndFilesAsync($share, $path = '', \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ListDirectoriesAndFilesOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNull($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($path, 'path');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_GET;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($share, $path);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ListDirectoriesAndFilesOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_REST_TYPE, 'directory');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_COMP, 'list');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_PREFIX_LOWERCASE, $options->getPrefix());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_MARKER_LOWERCASE, $options->getNextMarker());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_MAX_RESULTS_LOWERCASE, $options->getMaxResults());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        $dataSerializer = $this->dataSerializer;
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options)->then(function ($response) use($dataSerializer) {
            $parsed = $dataSerializer->unserialize($response->getBody());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ListDirectoriesAndFilesResult::create($parsed, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::getLocationFromHeaders($response->getHeaders()));
        }, null);
    }
    /**
     * Creates a new directory in the given share and path.
     *
     * @param string                      $share     The share name.
     * @param string                      $path      The path to create the directory.
     * @param CreateDirectoryOptions|null $options   The optional parameters.
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/create-directory
     */
    public function createDirectory($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\CreateDirectoryOptions $options = null)
    {
        $this->createDirectoryAsync($share, $path, $options)->wait();
    }
    /**
     * Creates a promise to create a new directory in the given share and path.
     *
     * @param string                      $share     The share name.
     * @param string                      $path      The path to create the directory.
     * @param CreateDirectoryOptions|null $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/create-directory
     */
    public function createDirectoryAsync($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\CreateDirectoryOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($path, 'path');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($path, 'path');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_PUT;
        $postParams = array();
        $queryParams = array(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_REST_TYPE => 'directory');
        $path = $this->createPath($share, $path);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\CreateDirectoryOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        $metadata = $options->getMetadata();
        $headers = $this->generateMetadataHeaders($metadata);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_CREATED, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options);
    }
    /**
     * Deletes a directory in the given share and path.
     *
     * @param string                  $share     The share name.
     * @param string                  $path      The path to delete the directory.
     * @param FileServiceOptions|null $options   The optional parameters.
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/delete-directory
     */
    public function deleteDirectory($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        $this->deleteDirectoryAsync($share, $path, $options)->wait();
    }
    /**
     * Creates a promise to delete a new directory in the given share and path.
     *
     * @param string                  $share     The share name.
     * @param string                  $path      The path to delete the directory.
     * @param FileServiceOptions|null $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/delete-directory
     */
    public function deleteDirectoryAsync($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($path, 'path');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_DELETE;
        $headers = array();
        $postParams = array();
        $queryParams = array(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_REST_TYPE => 'directory');
        $path = $this->createPath($share, $path);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_ACCEPTED, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options);
    }
    /**
     * Gets a directory's properties from the given share and path.
     *
     * @param string                  $share     The share name.
     * @param string                  $path      The path of the directory.
     * @param FileServiceOptions|null $options   The optional parameters.
     *
     * @return GetDirectoryPropertiesResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-directory-properties
     */
    public function getDirectoryProperties($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        return $this->getDirectoryPropertiesAsync($share, $path, $options)->wait();
    }
    /**
     * Creates promise to get a directory's properties from the given share
     * and path.
     *
     * @param string                  $share     The share name.
     * @param string                  $path      The path of the directory.
     * @param FileServiceOptions|null $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-directory-properties
     */
    public function getDirectoryPropertiesAsync($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($path, 'path');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_GET;
        $headers = array();
        $postParams = array();
        $queryParams = array(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_REST_TYPE => 'directory');
        $path = $this->createPath($share, $path);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options)->then(function ($response) {
            $parsed = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\GetDirectoryPropertiesResult::create($parsed);
        }, null);
    }
    /**
     * Gets a directory's metadata from the given share and path.
     *
     * @param string                  $share     The share name.
     * @param string                  $path      The path of the directory.
     * @param FileServiceOptions|null $options   The optional parameters.
     *
     * @return GetDirectoryMetadataResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-directory-metadata
     */
    public function getDirectoryMetadata($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        return $this->getDirectoryMetadataAsync($share, $path, $options)->wait();
    }
    /**
     * Creates promise to get a directory's metadata from the given share
     * and path.
     *
     * @param string                  $share     The share name.
     * @param string                  $path      The path of the directory.
     * @param FileServiceOptions|null $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-directory-metadata
     */
    public function getDirectoryMetadataAsync($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($path, 'path');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_GET;
        $headers = array();
        $postParams = array();
        $queryParams = array(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_REST_TYPE => 'directory');
        $path = $this->createPath($share, $path);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_COMP, 'metadata');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options)->then(function ($response) {
            $parsed = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\GetDirectoryMetadataResult::create($parsed);
        }, null);
    }
    /**
     * Sets a directory's metadata from the given share and path.
     *
     * @param string                  $share     The share name.
     * @param string                  $path      The path to delete the directory.
     * @param array                   $metadata  The metadata to be set.
     * @param FileServiceOptions|null $options   The optional parameters.
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/set-directory-metadata
     */
    public function setDirectoryMetadata($share, $path, array $metadata, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        $this->setDirectoryMetadataAsync($share, $path, $metadata, $options)->wait();
    }
    /**
     * Creates promise to set a directory's metadata from the given share
     * and path.
     *
     * @param string                  $share     The share name.
     * @param string                  $path      The path to delete the directory.
     * @param array                   $metadata  The metadata to be set.
     * @param FileServiceOptions|null $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/set-directory-metadata
     */
    public function setDirectoryMetadataAsync($share, $path, array $metadata, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($path, 'path');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_PUT;
        $postParams = array();
        $queryParams = array(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_REST_TYPE => 'directory');
        $path = $this->createPath($share, $path);
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::validateMetadata($metadata);
        $headers = $this->generateMetadataHeaders($metadata);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_COMP, 'metadata');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options);
    }
    /**
     * Create a new file.
     *
     * @param string                 $share   The share name.
     * @param string                 $path    The path and name of the file.
     * @param int                    $size    The size of the file.
     * @param CreateFileOptions|null $options The optional parameters.
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/create-file
     */
    public function createFile($share, $path, $size, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\CreateFileOptions $options = null)
    {
        return $this->createFileAsync($share, $path, $size, $options)->wait();
    }
    /**
     * Creates promise to create a new file.
     *
     * @param string                 $share   The share name.
     * @param string                 $path    The path and name of the file.
     * @param int                    $size    The size of the file.
     * @param CreateFileOptions|null $options The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/create-file
     */
    public function createFileAsync($share, $path, $size, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\CreateFileOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($path, 'path');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($path, 'path');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::isInteger($size, 'size');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_PUT;
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($share, $path);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\CreateFileOptions();
        }
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::validateMetadata($options->getMetadata());
        $headers = $this->generateMetadataHeaders($options->getMetadata());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_TYPE, 'file');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_CONTENT_LENGTH, $size);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::CONTENT_TYPE, $options->getContentType());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::CONTENT_ENCODING, $options->getContentEncoding());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::CONTENT_LANGUAGE, $options->getContentLanguage());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::CACHE_CONTROL, $options->getCacheControl());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::FILE_CONTENT_MD5, $options->getContentMD5());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::CONTENT_DISPOSITION, $options->getContentDisposition());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::CONTENT_DISPOSITION, $options->getContentDisposition());
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_CREATED, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options);
    }
    /**
     * Deletes a file in the given share and path.
     *
     * @param string                  $share     The share name.
     * @param string                  $path      The path to delete the file.
     * @param FileServiceOptions|null $options   The optional parameters.
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/delete-file2
     */
    public function deleteFile($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        $this->deleteFileAsync($share, $path, $options)->wait();
    }
    /**
     * Creates a promise to delete a new file in the given share and path.
     *
     * @param string                  $share     The share name.
     * @param string                  $path      The path to delete the file.
     * @param FileServiceOptions|null $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/delete-file2
     */
    public function deleteFileAsync($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($path, 'path');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_DELETE;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($share, $path);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_ACCEPTED, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options);
    }
    /**
     * Reads or downloads a file from the server, including its metadata and
     * properties.
     *
     * @param string              $share   name of the share
     * @param string              $path    path of the file to be get
     * @param GetFileOptions|null $options optional parameters
     *
     * @return GetFileResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-file
     */
    public function getFile($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\GetFileOptions $options = null)
    {
        return $this->getFileAsync($share, $path, $options)->wait();
    }
    /**
     * Creates promise to read or download a file from the server, including its
     * metadata and properties.
     *
     * @param string              $share   name of the share
     * @param string              $path    path of the file to be get
     * @param GetFileOptions|null $options optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-file
     */
    public function getFileAsync($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\GetFileOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($path, 'path');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_GET;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($share, $path);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\GetFileOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_RANGE, $options->getRangeString() == '' ? null : $options->getRangeString());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_RANGE_GET_CONTENT_MD5, $options->getRangeGetContentMD5() ? 'true' : null);
        $options->setIsStreaming(\true);
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, array(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_PARTIAL_CONTENT), \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options)->then(function ($response) {
            $metadata = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::getMetadataArray(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()));
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\GetFileResult::create(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders()), $response->getBody(), $metadata);
        });
    }
    /**
     * Gets a file's properties from the given share and path.
     *
     * @param string                  $share     The share name.
     * @param string                  $path      The path to delete the file.
     * @param FileServiceOptions|null $options   The optional parameters.
     *
     * @return FileProperties
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-file-properties
     */
    public function getFileProperties($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        return $this->getFilePropertiesAsync($share, $path, $options)->wait();
    }
    /**
     * Creates promise to get a file's properties from the given share
     * and path.
     *
     * @param string                  $share     The share name.
     * @param string                  $path      The path to delete the file.
     * @param FileServiceOptions|null $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-file-properties
     */
    public function getFilePropertiesAsync($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($path, 'path');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_HEAD;
        $headers = array();
        $queryParams = array();
        $postParams = array();
        $path = $this->createPath($share, $path);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options)->then(function ($response) {
            $parsed = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileProperties::createFromHttpHeaders($parsed);
        }, null);
    }
    /**
     * Sets properties on the file.
     *
     * @param string                  $share      share name
     * @param string                  $path       path of the file
     * @param FileProperties          $properties file properties.
     * @param FileServiceOptions|null $options    optional     parameters
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/set-file-properties
     */
    public function setFileProperties($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileProperties $properties, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        $this->setFilePropertiesAsync($share, $path, $properties, $options)->wait();
    }
    /**
     * Creates promise to set properties on the file.
     *
     * @param string                  $share      share name
     * @param string                  $path       path of the file
     * @param FileProperties          $properties file properties.
     * @param FileServiceOptions|null $options    optional     parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/set-file-properties
     */
    public function setFilePropertiesAsync($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileProperties $properties, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($path, 'path');
        $headers = array();
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_PUT;
        $postParams = array();
        $queryParams = array(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_COMP => 'properties');
        $path = $this->createPath($share, $path);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_CACHE_CONTROL, $properties->getCacheControl());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_CONTENT_TYPE, $properties->getContentType());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_CONTENT_MD5, $properties->getContentMD5());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_CONTENT_ENCODING, $properties->getContentEncoding());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_CONTENT_LANGUAGE, $properties->getContentLanguage());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_CONTENT_DISPOSITION, $properties->getContentDisposition());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_CONTENT_LENGTH, $properties->getContentLength());
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options);
    }
    /**
     * Gets a file's metadata from the given share and path.
     *
     * @param string                  $share     The share name.
     * @param string                  $path      The path of the file.
     * @param FileServiceOptions|null $options   The optional parameters.
     *
     * @return GetFileMetadataResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-file-metadata
     */
    public function getFileMetadata($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        return $this->getFileMetadataAsync($share, $path, $options)->wait();
    }
    /**
     * Creates promise to get a file's metadata from the given share
     * and path.
     *
     * @param string                  $share     The share name.
     * @param string                  $path      The path of the file.
     * @param FileServiceOptions|null $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/get-file-metadata
     */
    public function getFileMetadataAsync($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($path, 'path');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_GET;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($share, $path);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_COMP, 'metadata');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options)->then(function ($response) {
            $parsed = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\GetFileMetadataResult::create($parsed);
        }, null);
    }
    /**
     * Sets a file's metadata from the given share and path.
     *
     * @param string                  $share     The share name.
     * @param string                  $path      The path to delete the file.
     * @param array                   $metadata  The metadata to be set.
     * @param FileServiceOptions|null $options   The optional parameters.
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/set-file-metadata
     */
    public function setFileMetadata($share, $path, array $metadata, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        return $this->setFileMetadataAsync($share, $path, $metadata, $options)->wait();
    }
    /**
     * Creates promise to set a file's metadata from the given share
     * and path.
     *
     * @param string                  $share     The share name.
     * @param string                  $path      The path to delete the file.
     * @param array                   $metadata  The metadata to be set.
     * @param FileServiceOptions|null $options   The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/set-file-metadata
     */
    public function setFileMetadataAsync($share, $path, array $metadata, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($path, 'path');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_PUT;
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($share, $path);
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::validateMetadata($metadata);
        $headers = $this->generateMetadataHeaders($metadata);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_COMP, 'metadata');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options);
    }
    /**
     * Writes range of bytes to a file. Range can be at most 4MB in length.
     *
     * @param  string                          $share   The share name.
     * @param  string                          $path    The path of the file.
     * @param  string|resource|StreamInterface $content The content to be uploaded.
     * @param  Range                           $range   The range in the file to
     *                                                  be put.
     * @param  PutFileRangeOptions|null        $options The optional parameters.
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/put-range
     */
    public function putFileRange($share, $path, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range $range, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\PutFileRangeOptions $options = null)
    {
        $this->putFileRangeAsync($share, $path, $content, $range, $options)->wait();
    }
    /**
     * Creates promise to write range of bytes to a file. Range can be at most
     * 4MB in length.
     *
     * @param  string                          $share   The share name.
     * @param  string                          $path    The path of the file.
     * @param  string|resource|StreamInterface $content The content to be uploaded.
     * @param  Range                           $range   The range in the file to
     *                                                  be put.
     * @param  PutFileRangeOptions|null        $options The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/put-range
     *
     */
    public function putFileRangeAsync($share, $path, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range $range, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\PutFileRangeOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($path, 'path');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($path, 'path');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNull($range->getLength(), \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::RESOURCE_RANGE_LENGTH_MUST_SET);
        $stream = \Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Utils::streamFor($content);
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_PUT;
        $headers = array();
        $queryParams = array();
        $postParams = array();
        $path = $this->createPath($share, $path);
        if ($options == null) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\PutFileRangeOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_RANGE, $range->getRangeString());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::CONTENT_LENGTH, $range->getLength());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_WRITE, 'Update');
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::CONTENT_MD5, $options->getContentMD5());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_COMP, 'range');
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_CREATED, $stream, $options);
    }
    /**
     * Creates a file from a provided content.
     *
     * @param  string                             $share   the share name
     * @param  string                             $path    the path of the file
     * @param  StreamInterface|resource|string    $content the content used to
     *                                                     create the file
     * @param  CreateFileFromContentOptions|null  $options optional parameters
     *
     * @return void
     */
    public function createFileFromContent($share, $path, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\CreateFileFromContentOptions $options = null)
    {
        $this->createFileFromContentAsync($share, $path, $content, $options)->wait();
    }
    /**
     * Creates a promise to create a file from a provided content.
     *
     * @param  string                            $share   the share name
     * @param  string                            $path    the path of the file
     * @param  StreamInterface|resource|string   $content the content used to
     *                                                  create the file
     * @param  CreateFileFromContentOptions|null $options optional parameters
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function createFileFromContentAsync($share, $path, $content, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\CreateFileFromContentOptions $options = null)
    {
        $stream = \Dekode\GravityForms\Vendor\GuzzleHttp\Psr7\Utils::streamFor($content);
        $size = $stream->getSize();
        if ($options == null) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\CreateFileFromContentOptions();
        }
        //create the file first
        $promise = $this->createFileAsync($share, $path, $size, $options);
        //then upload the content
        $range = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range(0, $size - 1);
        $putOptions = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\PutFileRangeOptions($options);
        $useTransactionalMD5 = $options->getUseTransactionalMD5();
        if ($size > \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::MB_IN_BYTES_4) {
            return $promise->then(function ($response) use($share, $path, $stream, $range, $putOptions, $useTransactionalMD5) {
                return $this->multiplePutRangeConcurrentAsync($share, $path, $stream, $range, $putOptions, $useTransactionalMD5);
            }, null);
        } elseif ($size > 0) {
            return $promise->then(function ($response) use($share, $path, $stream, $range, $putOptions) {
                return $this->putFileRangeAsync($share, $path, $stream, $range, $putOptions);
            }, null);
        } else {
            return $promise;
        }
    }
    /**
     * Clears range of bytes of a file. If the specified range is not 512-byte
     * aligned, the operation will write zeros to the start or end of the range
     * that is not 512-byte aligned and free the rest of the range inside that
     * is 512-byte aligned.
     *
     * @param  string                  $share   The share name.
     * @param  string                  $path    The path of the file.
     * @param  Range                   $range   The range in the file to
     *                                          be cleared.
     * @param  FileServiceOptions|null $options The optional parameters.
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/put-range
     */
    public function clearFileRange($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range $range, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        $this->clearFileRangeAsync($share, $path, $range, $options)->wait();
    }
    /**
     * Creates promise to clear range of bytes of a file. If the specified range
     * is not 512-byte aligned, the operation will write zeros to the start or
     * end of the range that is not 512-byte aligned and free the rest of the
     * range inside that is 512-byte aligned.
     *
     * @param  string                  $share   The share name.
     * @param  string                  $path    The path of the file.
     * @param  Range                   $range   The range in the file to
     *                                          be cleared.
     * @param  FileServiceOptions|null $options The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/put-range
     *
     */
    public function clearFileRangeAsync($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range $range, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($path, 'path');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($path, 'path');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($share, 'share');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_PUT;
        $headers = array();
        $queryParams = array();
        $postParams = array();
        $path = $this->createPath($share, $path);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_RANGE, $range->getRangeString());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_WRITE, 'Clear');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_COMP, 'range');
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_CREATED, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options);
    }
    /**
     * Lists range of bytes of a file.
     *
     * @param  string                  $share   The share name.
     * @param  string                  $path    The path of the file.
     * @param  Range                   $range   The range in the file to
     *                                          be listed.
     * @param  FileServiceOptions|null $options The optional parameters.
     *
     * @return ListFileRangesResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/list-ranges
     */
    public function listFileRange($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range $range = null, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        return $this->listFileRangeAsync($share, $path, $range, $options)->wait();
    }
    /**
     * Creates promise to list range of bytes of a file.
     *
     * @param  string                  $share   The share name.
     * @param  string                  $path    The path of the file.
     * @param  Range                   $range   The range in the file to
     *                                          be listed.
     * @param  FileServiceOptions|null $options The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/list-ranges
     *
     */
    public function listFileRangeAsync($share, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\Range $range = null, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($path, 'path');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($path, 'path');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($share, 'share');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_GET;
        $headers = array();
        $queryParams = array();
        $postParams = array();
        $path = $this->createPath($share, $path);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        if ($range != null) {
            $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_RANGE, $range->getRangeString());
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_COMP, 'rangelist');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        $dataSerializer = $this->dataSerializer;
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_OK, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options)->then(function ($response) use($dataSerializer) {
            $responseHeaders = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders());
            $parsed = $dataSerializer->unserialize($response->getBody());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ListFileRangesResult::create($responseHeaders, $parsed);
        }, null);
    }
    /**
     * Informs server to copy file from $sourcePath to $path.
     * To copy a file to another file within the same storage account, you may
     * use Shared Key to authenticate the source file. If you are copying a file
     * from another storage account, or if you are copying a blob from the same
     * storage account or another storage account, then you must authenticate
     * the source file or blob using a shared access signature. If the source is
     * a public blob, no authentication is required to perform the copy
     * operation.
     * Here are some examples of source object URLs:
     * https://myaccount.file.core.windows.net/myshare/mydirectorypath/myfile
     * https://myaccount.blob.core.windows.net/mycontainer/myblob?sastoken
     *
     * @param  string                  $share      The share name.
     * @param  string                  $path       The path of the file.
     * @param  string                  $sourcePath The path of the source.
     * @param  array                   $metadata   The metadata of the file.
     *                                             If specified, source metadata
     *                                             will not be copied.
     * @param  FileServiceOptions|null $options    The optional parameters.
     *
     * @return CopyFileResult
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/copy-file
     */
    public function copyFile($share, $path, $sourcePath, array $metadata = array(), \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        return $this->copyFileAsync($share, $path, $sourcePath, $metadata, $options)->wait();
    }
    /**
     * Creates promise to inform server to copy file from $sourcePath to $path.
     *
     * To copy a file to another file within the same storage account, you may
     * use Shared Key to authenticate the source file. If you are copying a file
     * from another storage account, or if you are copying a blob from the same
     * storage account or another storage account, then you must authenticate
     * the source file or blob using a shared access signature. If the source is
     * a public blob, no authentication is required to perform the copy
     * operation.
     * Here are some examples of source object URLs:
     * https://myaccount.file.core.windows.net/myshare/mydirectorypath/myfile
     * https://myaccount.blob.core.windows.net/mycontainer/myblob?sastoken
     *
     * @param  string                  $share      The share name.
     * @param  string                  $path       The path of the file.
     * @param  string                  $sourcePath The path of the source.
     * @param  array                   $metadata   The metadata of the file.
     *                                             If specified, source metadata
     *                                             will not be copied.
     * @param  FileServiceOptions|null $options    The optional parameters.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/copy-file
     *
     */
    public function copyFileAsync($share, $path, $sourcePath, array $metadata = array(), \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($path, 'path');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($sourcePath, 'sourcePath');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($path, 'path');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($sourcePath, 'sourcePath');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_PUT;
        $queryParams = array();
        $postParams = array();
        $path = $this->createPath($share, $path);
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::validateMetadata($metadata);
        $headers = $this->generateMetadataHeaders($metadata);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_COPY_SOURCE, $sourcePath);
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_ACCEPTED, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options)->then(function ($response) {
            $headers = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Http\HttpFormatter::formatHeaders($response->getHeaders());
            return \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\CopyFileResult::create($headers);
        }, null);
    }
    /**
     * Abort a file copy operation
     *
     * @param string                  $share   name of the share
     * @param string                  $path    path of the file
     * @param string                  $copyID  copy operation identifier.
     * @param FileServiceOptions|null $options optional parameters
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/abort-copy-file
     */
    public function abortCopy($share, $path, $copyID, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        return $this->abortCopyAsync($share, $path, $copyID, $options)->wait();
    }
    /**
     * Creates promise to abort a file copy operation
     *
     * @param string                  $share   name of the share
     * @param string                  $path    path of the file
     * @param string                  $copyID  copy operation identifier.
     * @param FileServiceOptions|null $options optional parameters
     *
     * @return void
     *
     * @see https://docs.microsoft.com/en-us/rest/api/storageservices/abort-copy-file
     */
    public function abortCopyAsync($share, $path, $copyID, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions $options = null)
    {
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($path, 'path');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::canCastAsString($copyID, 'copyID');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($share, 'share');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($path, 'path');
        \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Validate::notNullOrEmpty($copyID, 'copyID');
        $method = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::HTTP_PUT;
        $headers = array();
        $postParams = array();
        $queryParams = array();
        $path = $this->createPath($share, $path);
        if (\is_null($options)) {
            $options = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\FileServiceOptions();
        }
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_TIMEOUT, $options->getTimeout());
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_COMP, 'copy');
        $this->addOptionalQueryParam($queryParams, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_COPY_ID, $copyID);
        $this->addOptionalHeader($headers, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::X_MS_COPY_ACTION, 'abort');
        return $this->sendAsync($method, $headers, $queryParams, $postParams, $path, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::STATUS_NO_CONTENT, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::EMPTY_STRING, $options);
    }
}
