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
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
namespace Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models;

use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources as Resources;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\MarkerContinuationToken;
use Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\MarkerContinuationTokenTrait;
/**
 * Share to hold list directories and files response object.
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\File\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class ListDirectoriesAndFilesResult
{
    use MarkerContinuationTokenTrait;
    private $directories;
    private $files;
    private $maxResults;
    private $accountName;
    private $marker;
    /**
     * Creates ListDirectoriesAndFilesResult object from parsed XML response.
     *
     * @param array  $parsedResponse XML response parsed into array.
     * @param string $location       Contains the location for the previous
     *                               request.
     *
     * @internal
     *
     * @return ListDirectoriesAndFilesResult
     */
    public static function create(array $parsedResponse, $location = '')
    {
        $result = new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\ListDirectoriesAndFilesResult();
        $serviceEndpoint = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetKeysChainValue($parsedResponse, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::XTAG_ATTRIBUTES, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::XTAG_SERVICE_ENDPOINT);
        $result->setAccountName(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryParseAccountNameFromUrl($serviceEndpoint));
        $nextMarker = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($parsedResponse, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_NEXT_MARKER);
        if ($nextMarker != null) {
            $result->setContinuationToken(new \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Models\MarkerContinuationToken($nextMarker, $location));
        }
        $result->setMaxResults(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($parsedResponse, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_MAX_RESULTS));
        $result->setMarker(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($parsedResponse, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_MARKER));
        $entries = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($parsedResponse, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_ENTRIES);
        if (empty($entries)) {
            $result->setDirectories(array());
            $result->setFiles(array());
        } else {
            $directoriesArray = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($entries, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_DIRECTORY);
            $filesArray = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\Common\Internal\Utilities::tryGetValue($entries, \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_FILE);
            $directories = array();
            $files = array();
            if ($directoriesArray != null) {
                if (\array_key_exists(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_NAME, $directoriesArray)) {
                    $directoriesArray = [$directoriesArray];
                }
                foreach ($directoriesArray as $directoryArray) {
                    $directories[] = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\Directory::create($directoryArray);
                }
            }
            if ($filesArray != null) {
                if (\array_key_exists(\Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Internal\FileResources::QP_NAME, $filesArray)) {
                    $filesArray = [$filesArray];
                }
                foreach ($filesArray as $fileArray) {
                    $files[] = \Dekode\GravityForms\Vendor\MicrosoftAzure\Storage\File\Models\File::create($fileArray);
                }
            }
            $result->setDirectories($directories);
            $result->setFiles($files);
        }
        return $result;
    }
    /**
     * Sets Directories.
     *
     * @param array $directories list of directories.
     *
     * @return void
     */
    protected function setDirectories(array $directories)
    {
        $this->directories = array();
        foreach ($directories as $directory) {
            $this->directories[] = clone $directory;
        }
    }
    /**
     * Gets directories.
     *
     * @return Directory[]
     */
    public function getDirectories()
    {
        return $this->directories;
    }
    /**
     * Sets files.
     *
     * @param array $files list of files.
     *
     * @return void
     */
    protected function setFiles(array $files)
    {
        $this->files = array();
        foreach ($files as $file) {
            $this->files[] = clone $file;
        }
    }
    /**
     * Gets files.
     *
     * @return File[]
     */
    public function getFiles()
    {
        return $this->files;
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
