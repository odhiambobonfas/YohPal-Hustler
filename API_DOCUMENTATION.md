# YohPal Hustler - API Documentation

Base URL: `https://yohpal-hustler-apis-test.onrender.com`

## Authentication APIs

### 1. Sign In
- **Endpoint**: `POST /signin`
- **Description**: Authenticate user and return token
- **Request Body**:
  ```json
  {
    "email": "user@example.com",
    "password": "password123"
  }
  ```
- **Response**: User object with authentication token

### 2. Sign Up
- **Endpoint**: `POST /signup`
- **Description**: Register new user account
- **Request Body**:
  ```json
  {
    "email": "user@example.com",
    "password": "password123"
  }
  ```

### 3. Password Reset
- **Endpoint**: `POST /password_reset`
- **Description**: Initiate password reset request
- **Request Body**:
  ```json
  {
    "email": "user@example.com"
  }
  ```

### 4. Get User Profile
- **Endpoint**: `GET /profile/{uid}`
- **Description**: Retrieve user profile by UID
- **Headers**: `Authorization: Bearer {token}`

---

## Job APIs

### 5. Create Job
- **Endpoint**: `POST /jobs/create`
- **Description**: Create a new job posting
- **Headers**: `Authorization: Bearer {token}`
- **Request Body**:
  ```json
  {
    "ownerId": "user_id",
    "ownerName": "John Doe",
    "jobDetails": {
      "name": "Plumbing Work",
      "startTime": "2025-01-20T09:00:00",
      "endTime": "2025-01-20T17:00:00",
      "hustlersCount": 2,
      "description": "Fix kitchen sink",
      "jobSite": {},
      "hustlers": []
    }
  }
  ```

### 6. Get Job Details
- **Endpoint**: `GET /jobs/get_details/{jobId}`
- **Description**: Retrieve specific job details
- **Headers**: `Authorization: Bearer {token}`

### 7. Get Active Hustlers
- **Endpoint**: `GET /jobs/get_active_hustlers/{primarySkill}?start={startTime}`
- **Description**: Get available hustlers by skill and time
- **Headers**: `Authorization: Bearer {token}`

### 8. Accept Job Request
- **Endpoint**: `PUT /hustler/accept_request`
- **Description**: Hustler accepts a job request
- **Headers**: `Authorization: Bearer {token}`
- **Request Body**:
  ```json
  {
    "jobId": "job_id",
    "hustlerId": "hustler_id"
  }
  ```

### 9. Reject Job Request
- **Endpoint**: `PUT /hustler/reject_request`
- **Description**: Hustler rejects a job request
- **Headers**: `Authorization: Bearer {token}`
- **Request Body**:
  ```json
  {
    "jobId": "job_id",
    "hustlerId": "hustler_id"
  }
  ```

---

## Hustler APIs

### 10. Get Hustler Job Requests
- **Endpoint**: `GET /hustler/job_requests/{hustlerId}`
- **Description**: Get all job requests for a hustler
- **Headers**: `Authorization: Bearer {token}`

### 11. Get Hustler Job History
- **Endpoint**: `GET /hustler/job_history/{hustlerId}`
- **Description**: Get completed job history for hustler
- **Headers**: `Authorization: Bearer {token}`

### 12. Get Hustler Profile
- **Endpoint**: `GET /hustler/profile/{hustlerId}`
- **Description**: Retrieve hustler profile details
- **Headers**: `Authorization: Bearer {token}`

### 13. Update Hustler Profile
- **Endpoint**: `PUT /hustler/profile/edit`
- **Description**: Update hustler profile information
- **Headers**: `Authorization: Bearer {token}`
- **Request Body**:
  ```json
  {
    "hustlerId": "hustler_id",
    "pricing": "5000",
    "pricingType": "Daily",
    "workBio": "Experienced plumber"
  }
  ```

### 14. Update Primary Skill
- **Endpoint**: `PUT /hustler/profile/edit/primary_skill`
- **Description**: Update hustler's primary skill
- **Headers**: `Authorization: Bearer {token}`
- **Request Body**:
  ```json
  {
    "hustlerId": "hustler_id",
    "primarySkill": "Plumbing"
  }
  ```

### 15. Update Skills
- **Endpoint**: `PUT /hustler/profile/edit/skills`
- **Description**: Update hustler's skill set
- **Headers**: `Authorization: Bearer {token}`
- **Request Body**:
  ```json
  {
    "hustlerId": "hustler_id",
    "skills": ["Plumbing", "Electrical", "Carpentry"]
  }
  ```

### 16. Update Availability
- **Endpoint**: `POST /hustler/availability/update`
- **Description**: Update hustler's availability schedule
- **Headers**: `Authorization: Bearer {token}`
- **Request Body**:
  ```json
  {
    "hustlerId": "hustler_id",
    "type": "partial",
    "days": ["Monday", "Tuesday", "Wednesday"]
  }
  ```

### 17. Get Hustler Live Location
- **Endpoint**: `GET /hustler/live_location/{hustlerId}`
- **Description**: Get real-time location of hustler
- **Headers**: `Authorization: Bearer {token}`

### 18. Get Hustler Dashboard Stats
- **Endpoint**: `GET /statistics/dashboard/hustler/{hustlerId}`
- **Description**: Get hustler dashboard statistics
- **Headers**: `Authorization: Bearer {token}`

---

## Client APIs

### 19. Activate Client
- **Endpoint**: `POST /client/activate`
- **Description**: Activate client account
- **Headers**: `Authorization: Bearer {token}`
- **Request Body**:
  ```json
  {
    "userId": "user_id"
  }
  ```

### 20. Get Client Job History
- **Endpoint**: `GET /client/job_history/{ownerId}`
- **Description**: Get all jobs posted by client
- **Headers**: `Authorization: Bearer {token}`

### 21. Get Client Dashboard Stats
- **Endpoint**: `GET /statistics/dashboard/client/{userId}`
- **Description**: Get client dashboard statistics
- **Headers**: `Authorization: Bearer {token}`

---

## Service/Category APIs

### 22. Get Service Categories
- **Endpoint**: `POST /services`
- **Description**: Retrieve all available service categories
- **Response**:
  ```json
  {
    "services": [
      {
        "slug": "home-services",
        "name": "Home Services",
        "subcategories": ["Plumbing", "Electrical", "Carpentry"]
      }
    ]
  }
  ```

---

## Location APIs

### 23. Update Primary Location
- **Endpoint**: `POST /location/update_primary`
- **Description**: Update user's primary location
- **Headers**: `Authorization: Bearer {token}`
- **Request Body**:
  ```json
  {
    "uid": "user_id",
    "location": {
      "latitude": -1.286389,
      "longitude": 36.817223,
      "address": "Nairobi, Kenya"
    }
  }
  ```

---

## Communication APIs

### 24. Send OTP
- **Endpoint**: `POST /send_otp`
- **Description**: Send OTP via SMS
- **Request Body**:
  ```json
  {
    "phone": "+254712345678",
    "otp": "123456"
  }
  ```

### 25. Send Email
- **Endpoint**: `POST /send_email`
- **Description**: Send email notification
- **Request Body**:
  ```json
  {
    "to": "user@example.com",
    "subject": "Welcome to YohPal",
    "body": "Email content"
  }
  ```

---

## Notes

- All authenticated endpoints require `Authorization: Bearer {token}` header
- Base URL: `https://yohpal-hustler-apis-test.onrender.com`
- All responses return JSON format
- Error responses include `error`, `message`, and optional `response` fields
