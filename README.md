# next-basket
Technical assessment for next basket

### Tech challenge BE

Create an application with 2 microservices that communicate via message bus.
Service "users" has an endpoint POST /users and on request with body {"email","firstName","lastName"}, stores the submitted data in a database or in a log file.
When the submitted data is saved, an event is generated and it is sent through a message broker to the "notifications" service. In "notifications" service the event is consumed and the sent data is saved in a log file.
The code must be covered with tests - unit, integration and functional tests.
Prepare needed containers in docker.
Create README file with instructions.
Upload the code to one repository in Github.
Bonus points if you use DDD or/and CQRS.


### Project Stucture
The project is made up of two microservices, the user service and notification service both writen using PHP/Laravel and Mysql DB. The messaging broker used is Redis.

### Installation Guide
Clone the repo,
cd notificationService
RUN composer install
cd ../usersService
RUN composer install

1. **Start Docker Compose:**
   - Run the following command in your terminal to start the Docker containers in the background:
     ```bash
     docker-compose up -d
     ```

2. **Access Services:**
   - Once Docker Compose has started the services, you can access them in your browser:
     - **User Service:**
       - Open your web browser and navigate to [http://localhost:8000](http://localhost:8000)
     - **Notification Service:**
       - Open your web browser and navigate to [http://localhost:8001](http://localhost:8001)

## Unit and Integration tests

To run the unit and integration tests, enter docker Cli for each running image or use docker exec command 
Run the command ``` php artisan test ```

To test the application using api,
Make a post request to ``` http://localhost:8000/api/users ```
Request body 
    ``` {
    "email": "jerov5ds@gmail.com",
    "firstName": "Jeremiah",
    "lastName": "Ovabor"
} ```

Go into each database (You can find the database configuration in docker-compose.yml file)

You can also check the ``` /usersService/storage/logs/laravel.log ``` file. Records are logged in this file.
For the notification service Logs can be found in ``` /notificationService/storage/logs/laravel.log ```
