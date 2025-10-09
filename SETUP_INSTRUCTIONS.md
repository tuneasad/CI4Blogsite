# Database Setup Instructions

Follow these steps to set up your new database and resolve the "Table 'auth_identities' doesn't exist" error.

These commands assume you have already configured your `.env` file with the correct database credentials.

### Step 1: Run All Database Migrations

This command will create all the necessary tables for the application, including the tables required by the CodeIgniter Shield authentication system.

Open your terminal in the project root and run:

```bash
php8 spark migrate --all
```

You should see a confirmation message that all migrations have run successfully.

### Step 2: Seed the Database

This command will populate the database with the demo data, including the SuperAdmin, Editor, and standard User accounts, as well as sample categories and posts.

Run the following command:

```bash
php8 spark db:seed DatabaseSeeder
```

After this command completes, your database will be fully set up and populated.

### Step 3: Start the Application

You can now start the development server and log in with one of the demo accounts:

```bash
php8 spark serve
```

The application will be available at `http://localhost:8080`.

**Demo User Credentials:**

-   **SuperAdmin:**
    -   **Email:** `superadmin@example.com`
    -   **Password:** `password`
-   **Editor:**
    -   **Email:** `editor@example.com`
    -   **Password:** `password`
-   **Viewer:**
    -   **Email:** `viewer@example.com`
    -   **Password:** `password`