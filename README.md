# Loan Processing Application

This is a Laravel-based Loan Processing Application designed to manage loan details and calculate EMIs. It features dynamic EMI table generation and supports re-processing of data.

---

## Installation

Follow these steps to set up the project locally:

1.  **Clone the Repository**
    ```bash
    git clone <repository_url>
    cd loan_app
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    ```

3.  **Environment Configuration**
    Copy the example environment file and generate the application key:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Make sure to configure your database settings in the `.env` file.*

4.  **Database Setup**
    Run migrations and seed the database with initial data (including the default user and loan details):
    ```bash
    php artisan migrate --seed
    ```

5.  **Run the Application**
    Start the local development server:
    ```bash
    php artisan serve
    ```
    The application will be accessible at `http://localhost:8000`.

---

## Login Credentials

A default developer account is created by the seeders. Use the following credentials to log in:

*   **Username:** `developer`
*   **Password:** `Test@Password123#`

---

## Data Management

### Adding New Loans
To add new loan data for testing or development:

1.  Open the seeder file: `database/seeders/LoanDetailsSeeder.php`.
2.  Add your new loan records to the array in the `run` method.
3.  Re-run the seeders to populate the database:
    ```bash
    php artisan db:seed --class=LoanDetailsSeeder
    ```
    *(Note: usage of `migrate:fresh --seed` will wipe all existing data and re-seed everything)*

---

## Usage Guide

1.  **Login**: Access the application and log in using the credentials provided above.
2.  **Loan Details**: After logging in, navigate to the **Loan Details** page to view the list of loans currently in the system.
3.  **EMI Details**: Navigate to the **EMI Details** page.
    *   This page displays the calculated EMI data.
    *   **Process Data**: Click the **"Process Data"** button to trigger the EMI calculation logic. This processes the distinct loan data and creates/updates the dynamic EMI tables in the database.
4.  **Calculator**: (Optional) Use the calculator feature for manual EMI verifications if available.
