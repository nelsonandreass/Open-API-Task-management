# Task Management API


The Task Management API is an open-source task management system that provides a simple and efficient way to manage tasks, assign tasks to members, comment on tasks, change task priorities, and allow members to view their own tasks.

## Features

- CRUD Operations: Easily create, read, update, and delete tasks with simple API endpoints.
- Task Assignment: Assign tasks to specific members for efficient task distribution.
- Task Comments: Enable communication by allowing users to comment on tasks.
- Priority Management: Change the priority of tasks to reflect their importance.
- User-Specific Views: Members can view and manage their own tasks.

Authentication
The API uses Laravel Sanctum for authentication, providing a secure way to manage user sessions and authenticate API requests.

Getting Started

Follow these steps to get the Task Management API up and running on your local environment:

1. Clone the Repository:
   git clone https://github.com/nelsonandreass/Open-API-Task-management.git
   cd task-management-api
2. composer install
3. php artisan migrate
4. php artisan key:generate
5. php artisan serve