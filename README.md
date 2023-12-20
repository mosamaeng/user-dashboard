# Users Dashboard Prototype

## Server Requirements
- PHP >= 8.1
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- Filter PHP Extension
- Hash PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Session PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Installation

Follow these step-by-step instructions to set up the TUNE Users Dashboard:

1. **Clone the repository:**

    ```bash
    git clone [repository_url]
    ```

    Replace `[repository_url]` with the actual URL of your repository.

2. **Install dependencies using Composer:**

    ```bash
    composer install
    ```

3. **Configure the environment in the `.env` file:**
    - Set the application name and configure the database connection.

4. **Create the database:**
    - Run migrations and seed the database:

        ```bash
        php artisan migrate --seed
        ```

5. **Start the server:**

    ```bash
    php artisan serve
    ```

6. **Open the provided link in your browser:**
    - Commonly http://127.0.0.1:8000.

## Features

- **Users Dashboard:**
  - Each user card displays the avatar, name, occupation, line chart, impression counts, conversion count, and revenue.
  
- **Search functionality:**
  - Users can search by name, impressions, conversions, and revenue.

## User Interface

- Each card displays the user's avatar, name, and occupation. For users without an image avatar, the first letter of their first name is shown.
- The card shows the sum of all impressions, conversions, and revenue.
- A simple chart of conversions per day is displayed.

## Data

Mock data is provided in two sets:

- `users.json`: An array of user objects with id, name, avatar, and occupation.
- `logs.json`: Event information about traffic with type (impression or conversion), date, time, user ID, and revenue.

## Application Design

- The application is designed to eventually use a database as the source of user and log information.
- Consider future use of the API for additional views of users and event stats.

## Bonus Items

- Implemented the ability to sort cards by name and by total impressions, conversions, or revenue.
- Included unit tests for testable portions of the code.

## Testing

To run tests for searching functionality, use the following command:

```bash
php artisan test
```
