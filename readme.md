# Address Book

This project is a basic address book. It allows you to add/edit and delete contacts. Each contact can have an unlimited amount of attributes, of set types.

## Project Setup Instructions

#### 1. Configure composer, dependencies and autoloader

1. From the command line run `php composer.phar install`

 
#### 2. Configure and setup the database

1. Configure the database details in `config.php`
2. Ensure the database already exists and the user has full permissions
2. Run the database schema setup script `vendor/bin/doctrine orm:schema-tool:update --force`
3. Alternatively, if the user can not create tables, import the structure from `data/structure.sql`


#### 4. Configure host

1. The host needs to be absolute because the api endpoints are absolute. My local env is http://addressbook.dev.
2. The document root is the `public` directory and the index file is `index.php`
3. Make sure `public/assets/css` is writable
 


#### 4. Configure and run tests
***N.B. All data will be cleared prior to running the tests.***

1. From the command line run to install dev dependencies `php composer.phar update —dev`
2. The tests are configured to use the host http://addressbook.dev to perform REST tests. This can be configured in `test/BaseTest.php`. Configured incorrectly and the tests will fail.
3. Run the tests with `vendor/bin/phpunit test`


#### Notes

 - The CSS is compiled using LESS. For it to compile correctly, Node LESS is required to be installed and accessible via your systems `$PATH`. The CSS is currently compiled, so as long as there’s no changes to any less files (`public/less/*`), LESS doesn’t need to be installed. If any changes are made, they are compiled automatically but Node LESS needs to be installed and can be done by running `npm install -g less`.



