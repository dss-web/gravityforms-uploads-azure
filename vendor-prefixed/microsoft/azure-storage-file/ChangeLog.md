2021.09 - version 1.2.5
* Upgraded dependency for `azure-storage-common` to version 1.5.2.

2020.12 - version 1.2.4
* Fixed an issue where 400 is reported for some curl versions.
* Guzzle version is now updated to support both 6.x and 7.x.

2020.08 - version 1.2.3
* Lower case query parameter names.

2020.01 - version 1.2.2
* Fixed the issue in SAS token where special characters were not correctly encoded.
* Fixed `createFileFromContent` authentication failure when uploading some local file stream types. 
* Fixed `createFileFromContent` fail to upload from empty content issue.

2019.04 - version 1.2.1
* Resolved some issues on Linux platform.

2019.03 - version 1.2.0
* Fixed a bug where file name '0' cannot be created.
* Documentation refinement.

2018.04 - version 1.1.0

* MD files are modified for better readability and formatting.
* CACERT can now be set when creating RestProxies using `$options` parameter.
* Removed unnecessary trailing spaces.
* Assertions are re-factored in test cases.
* Now the test framework uses `PHPUnit\Framework\TestCase` instead of `PHPUnit_Framework_TestCase`.

2018.01 - version 1.0.0

* Created `FileSharedAccessSignatureHelper` and moved method `SharedAccessSignatureHelper::generateFileServiceSharedAccessSignatureToken()` into `FileSharedAccessSignatureHelper`.
* Added static builder methods `createFileService` into `FileRestProxy`.
* Removed `dataSerializer` parameter from `FileRextProxy` constructor.
* Added `setUseTransactionalMD5` method for option of `FileRestProxy::CreateFileFromContent`.  Default false, enabling transactional MD5 validation will take more cpu and memory resources.
* Deprecated PHP 5.5 support.