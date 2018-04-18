## Test Dilitrust

I made a small website using laravel, because that's the quickest tool to use and I was late on the realisation of the test.

The website allow users to upload their file and chose if they want it public or private :
![private](https://raw.githubusercontent.com/taitai42/test-dilitrust/master/screens/upload.PNG)

if they are set to private, the user can chose to give access to the file to another user of the website as you can see in the following screenshot : 

![private](https://raw.githubusercontent.com/taitai42/test-dilitrust/master/screens/private.PNG)

if the file is set as public, any user can see it from the homepage, and the owner can see who viewed the file:

![private](https://raw.githubusercontent.com/taitai42/test-dilitrust/master/screens/public.PNG)

## Deployment

I used docker to deploy the app so you can easily test it by cloning the repo, add the .env file I will provide by mail that contains the necessary keys and using the command 
`make`
this will download the dependances of the project, as well as creating and mounting docker images
once the database image is up and running, you can perform the following command :
`make migrations`
this will create the necessary tables and seed inside the database.

once this is up you can navigate to [http://localhost:8181](http://localhost:8181) to test it.

## Architecture
The website is using laravel framework, and mysql, via eloquent, which means we can easily change the database manager into postgres for exemple (that's what i used for development). 
Files uploaded are stored in Amazon S3, encrypted, which allow us to be sure they are available at any time and secure, they are displayed to the user by a temporary url (10 minutes), to make sure it's not predictable by a potential hacker 

## Code test

unit test are located inside the tests/unit folder, you can run them using `phpunit` 

