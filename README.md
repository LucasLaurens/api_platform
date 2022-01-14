# api_platform

## Steps to install the project
```bash
composer install # install dependencies
php bin/console doctrine:database:create # create the database
php bin/console doctrine:migrations:migrate # run all migration to fill the database
```
## Features
### PHP 7.4.9
- First step with
- Serialize
- Validation
- Pagination and filters
### PHP 8.0.10
- Custom operation
- Improve the documentation
- DataProvider
- DataPersister
- Create a custom endpoint (without Entity) to post a log message
- Create a data provider whitout any orm persistance
