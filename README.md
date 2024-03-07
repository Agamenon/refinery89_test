
## About Tenet Backend Test
This project was create with Laravel Framework v10 and it only for interview proposal.

## User Case

We need to create a small application with Laravel 10 that will have the features to
view/create departments and assign users to them.

### Departments:
* Each department must have an id and a name (you can add more fields if
you consider it necessary).
* A department could belong to another department (could be a
subdepartment).

### Users: id, name, email (you can add more fields if you consider it necessary).
The view must have the following features:
* View generated departments and hierarchy between them.
* Create, edit, and delete departments.
* Create, edit, and delete users.
* Assign/remove people to departments.

### Additional Notes:
* The depth of the tree is N children and each department has N users. A user
can belong to multiple departments at the same time.
* Tests must be included.
* The use of tailwind must be included.


## Project setup

### First time setup
Install dependencies with:
```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

After you are in sync with `origin/main` Then you can run
```shell
vendor/bin/sail up -d
vendor/bin/sail shell
php artisan migrate --seed
php artisan db:seed UserSeeder
php artisan db:seed DemoDataSeeder
```
### Daily usage
After you are in sync with `origin/main` Then you can run
Inside the shell you can run typical artisan commands like:
```sh
php artisan migrate --seed
```

### First time set up
### Run test suite
And then
```shell
vendor/bin/sail shell
php artisan test
```

if you want to see a coverage report, run:
```shell
vendor/bin/sail shell

export XDEBUG_MODE=coverage
php artisan test --coverage
```

## Postman Collection
You can find a Postman collection called `Tenet_Backend.postman_collection` to import in your Postman Workspace on root directory.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
