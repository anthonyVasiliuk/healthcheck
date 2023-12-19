# healthcheck

The purpose of this repository is to have a Laravel package for all projects to provide a controller werewith we can monitor the health of the applications. It is checking the connection to the database, Redis and Sentry. If all is configured correctly and reachable then the health check endpoint will return the statis code 200. If one or more services are not reachable then it will return the status code 500. For any other errors like misconfiguration or similar it will return the status code 503. For detailed information see the returned paylod. Therewith you can see which of these three services is not reachable or misconfured.

## How to embed it to your project

TODO

## How to work locally

First of all you need to [install Composer][1] and to download the code from github repository. Then run the following command to install the required vendor packages:

    composer install
    
After that you can run tests and the linter also with Composer.

### How to run tests

The unit tests can be triggered by running:

    composer test

If you push new code to the repository then this will be fired automatically via Github Actions.

### How to fix code styling

Run the following command to fix the code styling:

    composer pint

You can also use all parameters of Pint to use the verbose mode vor example:

    composer pint -v

Check the [official page of Laravel Pint][2] to see more instructions.

[1]: https://getcomposer.org
[2]: https://laravel.com/docs/10.x/pint#running-pint