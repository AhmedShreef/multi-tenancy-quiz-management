

# Multi Tenancy Quiz Management Task


This project is a **multi-tenancy quiz management system** built using **Laravel**. It allows an admin to create tenants (clients), manage members, create quizzes, and enable members to solve quizzes. The system is designed to be clean, maintainable, and scalable, with an intuitive user experience.
## Features
-   **Multi-Tenancy Setup**: Each tenant has its own isolated environment (database, users, and resources).
    
-   **Admin Dashboard**: Manage members, create quizzes, and assign roles using  **Filament**.
    
-   **Member Dashboard**: Members can view and solve quizzes, and receive their scores via email.
    
-   **Email Notifications**: Email notifications are sent using  **Laravel Queues**  for tenant creation and quiz results.
    
-   **Automatic Quiz Scoring**: The system automatically scores quizzes and sends results to members.
    
-   **Dockerization**: The application is containerized using Docker for easy deployment.


## How to Run the Application
#### 1. Clone the Repository
```bash
git clone git@github.com:AhmedShreef/multi-tenancy-quiz-management.git
```
Navigate to the project directory:
```bash
cd multi-tenancy-quiz-management
```

#### 2. Run the Application with Docker
Ensure you have **Docker** and **docker-compose** installed on your machine. To set up and run the application, use the following command:
```bash
docker-compose up -d
```
and wait for the docker images to be pulled, built and the containers to be up and running.

#### 3. Install App Dependencies & Generate App Key
```bash
docker-compose exec app cp .env.example .env
docker-compose exec app composer install --no-dev
docker-compose exec app php artisan key:generate
```
These three commands will ensure composer dependencies are installed and the application key is generated if they fail to install via Dockerfile for any reason.

#### 4. Run Database Migrations and Seeders
```bash
docker-compose exec app php artisan migrate
```
This command will create the necessary tables for central database.

#### 5. Required configurations
Since we use mailtrap as smtp mail provider, you need to add valid smtp credentials in .env file to be able to recieve registration/quizzes-score mails.
```bash
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
```


#### 6. Test the App (Locally)
##### Create New Client
Once the setup is complete, open your browser and navigate to:
```bash
http://multi-tenancy-quiz-management.test/tenants/create
```
1. Fill in the form with client info and make sure to fill in a valid email so that you can recieve an email containing tenant dashboard url and admin login credentails.
Now if you have a valid mail credentials configured on .env file you should recieve an email containing the dashboard link and admin user/password.

2. You can proceed with creating members and creating quizzes and login by member to see and answer these quizzes and recieve an email with your score.

#### 7. Test the App (Live)
open your browser and navigate to:
```bash
https://multi-tenancy-quiz-management.live
```
Repeat the same steps under point 5

## Technologies Used

- **PHP 8.1 or higher**
-   **Laravel 10.x**
-   **Laravel Filament v3** (for Dashboard)
-   **MySQL**
-   **Docker** (with Docker Compose)


## License

This project is open-source and licensed under the MIT License.
