# Enterprise-Grade CodeIgniter 4 Blog CMS

This is a fully functional, production-level Blog CMS built with CodeIgniter 4. It includes an admin dashboard, a public-facing blog, a REST API, an authentication system with roles, an email notification queue, and a comprehensive test suite.

## Features

-   **Frontend Blog:** Responsive blog with post listings, single post view, categories, and search.
-   **Admin Panel:** Secure dashboard for managing posts, categories, tags, and users.
-   **REST API:** A full-featured API for interacting with posts and categories, suitable for mobile apps or other clients.
-   **Authentication:** A robust authentication system powered by CodeIgniter Shield, with role-based access control (SuperAdmin, Editor, Viewer).
-   **Email & Queues:** Asynchronous email notifications for new posts, handled by a database-driven job queue.
-   **Testing:** A comprehensive suite of unit and feature tests to ensure code quality and reliability.
-   **External API Integration:** Fetch random featured images from the Dog API.

## Requirements

-   PHP 8.1+
-   MySQL
-   Composer

## Project Setup

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/socialtunegraphics-max/CI4Blogsite.git
    cd CI4Blogsite
    ```

2.  **Install dependencies:**
    ```bash
    composer install
    ```

3.  **Configure your environment:**
    Copy the `.env.example` file to `.env` and update it with your local environment settings, especially the database and email configurations.
    ```bash
    cp .env.example .env
    ```

4.  **Run database migrations and seeders:**
    This will set up the database schema and populate it with dummy data.
    ```bash
    php spark migrate --all
    php spark db:seed DatabaseSeeder
    ```

5.  **Start the development server:**
    ```bash
    php spark serve
    ```
    The application will be available at `http://localhost:8080`.

## `.env` Configuration Example

```
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080'

database.default.hostname = localhost
database.default.database = ci4blog
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi

# Email Configuration (for mailtrap.io or similar)
email.fromEmail = 'you@example.com'
email.fromName = 'CI4 Blog'
email.SMTPHost = 'smtp.mailtrap.io'
email.SMTPUser = 'your-smtp-user'
email.SMTPPass = 'your-smtp-pass'
email.SMTPPort = 2525
email.SMTPCrypto = 'tls'
```

## Running the Application

-   **Serve the application:**
    ```bash
    php spark serve
    ```
-   **Run the job queue processor:**
    To process pending jobs (like sending emails), run the following command:
    ```bash
    php spark jobs:run
    ```

## Testing

To run the full suite of unit and feature tests, use the following command:
```bash
php spark test
```

## Folder Structure

-   `/app` - The main application directory.
    -   `/Commands` - Custom `spark` commands.
    -   `/Controllers` - Application controllers (Admin, API, Frontend).
    -   `/Database` - Migrations and seeders.
    -   `/Libraries` - Custom libraries like `JobService`.
    -   `/Models` - Database models.
    -   `/Views` - Application views (Admin, Emails, Frontend).
-   `/tests` - Unit and feature tests.
    -   `/feature` - Feature tests (e.g., `AuthControllerTest`).
    -   `/unit` - Unit tests (e.g., `JobQueueTest`).
-   `/writable` - Directory for logs, cache, and uploads.

## API Documentation

For detailed information about the REST API, please see the [API_DOCUMENTATION.md](API_DOCUMENTATION.md) file.

## Contribution Guide

1.  Fork the repository.
2.  Create a new branch (`git checkout -b feature/your-feature`).
3.  Commit your changes (`git commit -am 'Add some feature'`).
4.  Push to the branch (`git push origin feature/your-feature`).
5.  Create a new Pull Request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.