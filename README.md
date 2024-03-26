## Simple Subscription Platform

This project is a job interview project for [inisev.com](inisev.com) company, aiming to create a simple subscription platform that allows users to subscribe to websites and receive email notifications whenever a new post is published on those websites. The platform is built using PHP 8.2 and MySQL, focusing solely on RESTful APIs without any authentication requirements.

## Implemented Features

### Mandatory Features
- **PHP Version:** PHP 8.2
- **Database:** MySQL
- **Migrations:** Migrations for the required tables are implemented.
- **Endpoint to Create Post:** Endpoint to create a post for a specific website is implemented.
- **User Subscription Endpoint:** Endpoint for users to subscribe to a particular website is implemented, including necessary validations.
- **Email Notification:** Command to send email notifications to subscribers whenever a new post is published on a website is implemented.
- **Background Processing:** Queues are used to schedule sending emails in the background.
- **Prevent Duplicate Notifications:** Mechanism to prevent duplicate posts from being sent to subscribers is implemented.

### Optional Features
- **Seeded Data:** Seeded data for websites is included. (Included)
- **API Documentation:** You can find the OpenAPI document file ([openapi.yaml](openapi.yaml)) in the project root directory. This document provides detailed information about the available APIs and their usage.
- **Listeners:** Events and listeners are utilized for handling specific actions.

### Install Instructions

1. Clone the project repository from GitHub.
2. Install PHP dependencies using Composer.
3. Rename `.env.example` to `.env` and generate an application key.
4. Configure the database connection in `.env`.
5. Run migrations and seeders.
6. Serve the application using `php artisan serve`.


