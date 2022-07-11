#  Nederlandse Loterij - Code Challenge
This repository contains my submission for the Nederlandse Loterij Case Back-end Developer.

It contains a docker compose file which can be used to run the application, webserver, database, and do the drawing of prices.
The application consists of a REST API which can be used to enter a guess to have a chance of the prices within the grid. 
The database is a MariaDB database which stores the winning grid locations, and all the submissions made by the users.
As this is a Back-End code challenge, the focus of the application lies with the database seeder and the API's. Limited time has been spent to make a functional frontend.
The details and requirements for this challenge are available in the `case-description-back-end.pdf` file.

## Running the application
Make sure to have a working docker installation available before continuing.  
To run the application, you can use the following command:  
```docker-compose up```  
The application will now be available at [localhost:80](http://localhost:80/)

## Automated Tests
For testing the API endpoints a Postman test collection is available in the `nlo-code-challenge.postman_collection.json` file.

## Secret / Easter Egg
During the initial run of the database seeder the winning position might be printed to the console ;)
