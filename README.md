# eden-tech-labs-api

Steps to run the app:

1. Checkout project
2. run `composer install`
3. create `database.sqlite` in `database` folder under the root folder of project. 
  If using unix system run this: `touch database/database.sqlite` from project root folder.
4. paste following configurations in .env
      ```APP_NAME=eden-tech-labs-api
      APP_ENV=local
      APP_KEY=base64:LEmtmcqxxmBRxd6+Q/PziGXRRatyHiprz3A95ir6HeU=
      APP_DEBUG=true
      APP_URL=http://localhost
      DB_CONNECTION=sqlite```
5. run `php artisan migrate`
6. run `php artisan db:seed`
7. run `php artisan jwt:secret`
8. setup your web server and run the app, suggest using 'Valet' if you are on macOS.

There is the postman collection i've created:
https://www.getpostman.com/collections/b776741f9c238ce577ce

Setup your environment in postman and add variable `base_url` with your local host in envoironment variables or just replace `{{base_url}}` with your local host.

To be able to create Post you should first authorize with name and email.
Once you run `/authorize` API endpoint you should get Authorization token from response headers and attach it in request headers in create post API endpoint.
