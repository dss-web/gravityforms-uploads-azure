# Gravity Forms File Uploads to Azure

Add support for offloading Gravity Forms Uploads to the Microsoft Azure cloud.

## How to use

- Define connection settings (https://site.com/wp-admin/admin.php?page=gf_settings&subview=gravityforms-uploads-azure)

You can also define constants:

```
define( 'MICROSOFT_AZURE_ACCOUNT_NAME', '' );
define( 'MICROSOFT_AZURE_ACCOUNT_KEY', '' );
define( 'MICROSOFT_AZURE_CNAME', '' );
```

The respective settings have priority over constants in this situation.

## Development

Install NodeJS and run `npm install` and `npm run azure` to launch development server.

Use local settings:

-   Account Name: `devstoreaccount1`
-   Account Key: `Eby8vdM02xNOcqFlqUwJPLlmEtlCDXJ1OUzFT50uSRZ6IFsuFq2UVErCz4I6tq/K1SZFPTOtr/KBHBeksoGMGw==`
-   Blob Service Endpoint: `http://127.0.0.1:10000/devstoreaccount1`

## Credits

Developed by [Dekode](https://en.dekode.no/?noredirect=en_US) for [DSS](https://www.dss.dep.no/about-us/).

## Copyright

Gravity Forms File Uploads to Azure is copyright 2021 [DSS](https://www.dss.dep.no/about-us/)

Gravity Forms File Uploads to Azure is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or (at your option) any later version.

Gravity Forms File Uploads to Azure is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU Lesser General Public License along with the Extension. If not, see http://www.gnu.org/licenses/.
