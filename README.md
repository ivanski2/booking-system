
# Booking System API

This is a Laravel-based booking system with API support. The system provides CRUD functionality for managing appointments and user authentication with Bearer tokens.

---

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/ivanski2/booking-system
   cd booking-system
   ```

2. Configure the environment:
    - Copy `.env.example` to `.env`
      ```
      cp .env.example .env
      ```
    - Update database credentials in the `.env` file:
      ```
      DB_CONNECTION=mysql
      DB_HOST=127.0.0.1
      DB_PORT=3306
      DB_DATABASE=booking_system
      DB_USERNAME=root
      DB_PASSWORD=
      ```

3. Run migrations and seeders:
   ```
   php artisan migrate --seed
   ```

4. Start the server:
   ```
   php artisan serve
   ```

---

## Testing web : 
Open browser and type : 
```http://127.0.0.1:8000/appointments```  or visit ```https://360vu.eu/project/booking-system/public/appointments```

## Testing the API

### 1. Login Endpoint

- **URL:** `POST /api/login`
- **Description:** Authenticate a user and receive a Bearer token.
- **Request Body:**
  ```json
  {
    "email": "ivan@example.com",
    "password": "ivanpass"
  }
  ```
- **Response:**
  ```json
  {
    "token": "your_bearer_token",
    "expires_at": "2024-01-01 10:00:00"
  }
  ```

### 2. Protected Routes

All endpoints below require the `Authorization` header with a Bearer token:
```
Authorization: Bearer your_bearer_token
```

#### a) Get All Appointments
- **URL:** `GET /api/appointments`
- **Response:**
  ```json
  [
    {
      "id": 1,
      "appointment_datetime": "2025-01-01 10:00",
      "client_name": "Ivan Ivanov",
      "client_egn": "1234567890",
      "notification_type": "SMS",
      "description": "General appointment"
    }
  ]
  ```

#### b) Create an Appointment
- **URL:** `POST /api/appointments`
- **Request Body:**
  ```json
  {
    "appointment_datetime": "2025-01-01T10:00",
    "client_name": "Ivan Ivanov",
    "client_egn": "1234567890",
    "notification_type": "Email",
    "description": "Dentist appointment"
  }
  ```
- **Response:**
  ```json
  {
    "id": 1,
    "appointment_datetime": "2025-01-01T10:00",
    "client_name": "Ivan Ivanov",
    "client_egn": "1234567890",
    "notification_type": "Email",
    "description": "Dentist appointment"
  }
  ```

#### c) Update an Appointment
- **URL:** `PUT /api/appointments/{id}`
- **Request Body:**
  ```json
  {
    "appointment_datetime": "2025-01-01T12:00",
    "client_name": "Ivan Ivanov2",
    "client_egn": "9876543210",
    "notification_type": "SMS",
    "description": "Updated description"
  }
  ```
- **Response:**
  ```json
  {
    "id": 1,
    "appointment_datetime": "2025-01-01T12:00",
    "client_name": "Ivan Ivanov2",
    "client_egn": "9876543210",
    "notification_type": "SMS",
    "description": "Updated description"
  }
  ```

#### d) Delete an Appointment
- **URL:** `DELETE /api/appointments/{id}`
- **Response:**
  ```json
  {
    "message": "Appointment deleted successfully."
  }
  ```

---

## Testing with Postman

1. **Login:**
    - Send a `POST` request to `/api/login` with the user credentials.
    - Copy the `token` from the response.

2. **Authenticated Requests:**
    - For all other endpoints, add the following header:
      ```
      Authorization: Bearer your_bearer_token
      ```

---

## Running Unit Tests

To ensure the functionality of the Booking System, you can run the included unit tests:

 -Run the tests:

     php artisan test

---

## Additional Notes

- Ensure your PHP version is `>=8.2.0`.
- Use the `artisan` CLI for clearing caches if needed:
  ```
  php artisan optimize:clear
  ```
- For frontend styling, Bootstrap is used.

