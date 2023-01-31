# dockerMongo
dockerMongo
Requirements

    Docker and Docker Compose installed on your machine

Steps to run the application

    1.Clone the repository to your local machine
    2.Open a terminal window and navigate to the cloned repository
    3.Run the command ' docker-compose up --build ' to build and start the containers
    4.Once the containers are up and running, use the command docker exec -it dockermongo-php-1 /bin/bash to access the PHP container
    5.Inside the container, run the command ' composer install ' to install the required dependencies
    6.Exit the container using the command ' exit '
    7.Restart the container
    8.Visit localhost:8080/index.html in your browser to see the application

Note

This readme assumes that you have already setup and configured Docker and Docker Compose on your machine.
