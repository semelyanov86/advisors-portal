# Advisor portal

## Installation Instructions

### Deployment

* Extract the archive and put it in the folder you want
* Run docker containers using `make up` command 
* Run `cp .env.example .env` file to copy example file to `.env`
* Then edit your .env file with DB credentials and other settings.
* Run `make setup` command
* Make sure that you have write permissions for storage folder

And that's it, go to your domain and login:

Default credentials

Username: admin@admin.com

Password: password

### Api Documentation

We generated OpenAPI documentation, it is located here: `documentation/openapi.json`

### Notes
* In docker container we have an issue with converting images to lower resolution. Problem with docker settings not solved yet. On live server everything is OK.
* For logging monitoring purposes we connected `flareapp.io` service
* For scalability purposes we need to isolate domains, for now we structure our project only by feature,  not DDD.
