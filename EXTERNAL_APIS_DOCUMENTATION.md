# External APIs Used in YohPal Hustler Web App

## 1. YohPal Backend API (Primary API)

### Base URL
```
https://yohpal-hustler-apis-test.onrender.com
```

### Storage Location
**File**: `bindings/endpoints/endpointsBindings.php`

### All Endpoints (25 APIs)
All endpoints are stored in the `endpointsBindings.php` file and accessed via `$util->getEndpoint('key')` method.

**Hardcoded in Models** (9 endpoints - NOT in bindings):
- `data/models/Job.php`:
  - `https://yohpal-hustler-apis-test.onrender.com/jobs/create`
  - `https://yohpal-hustler-apis-test.onrender.com/hustler/accept_request`
  - `https://yohpal-hustler-apis-test.onrender.com/hustler/reject_request`
  - `https://yohpal-hustler-apis-test.onrender.com/jobs/get_details/{jobId}`

- `data/models/Hustler.php`:
  - `https://yohpal-hustler-apis-test.onrender.com/jobs/get_active_hustlers/{skill}?start={time}`
  - `https://yohpal-hustler-apis-test.onrender.com/hustler/profile/edit`
  - `https://yohpal-hustler-apis-test.onrender.com/location/update_primary`
  - `https://yohpal-hustler-apis-test.onrender.com/hustler/availability/update`
  - `https://yohpal-hustler-apis-test.onrender.com/hustler/profile/edit/primary_skill`
  - `https://yohpal-hustler-apis-test.onrender.com/hustler/profile/edit/skills`

**Stored in Bindings** (16 endpoints):
All defined in `bindings/endpoints/endpointsBindings.php`

---

## 2. Google Maps JavaScript API

### API Key Storage
**File**: `.env`
```env
GOOGLE_MAP_API_KEY = "YOUR_GOOGLE_MAPS_API_KEY_HERE"
```

### Usage Location
**File**: `partials/layout/crm/footer.php`
```html
<script src="https://maps.googleapis.com/maps/api/js?key=<?= env('GOOGLE_MAP_API_KEY') ?>&libraries=geometry&libraries=marker" defer="defer"></script>
```

### Features Used
- Maps JavaScript API
- Geometry Library
- Marker Library (Advanced Markers)

### Implementation
**File**: `assets/js/global/master.js`
- Class: `Master`
- Methods: `setMapOnPage()`, `getGeolocationPositions()`, `mapAndCreateHustlerMarkers()`

---

## 3. CDN APIs (External Libraries)

### 3.1 Bootstrap CSS & JS
**Storage**: CDN (Content Delivery Network)

**Locations**:
- `pages/web/onboard-hustler.php`
- `pages/index.php`

```html
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
```

**Also Local**: `assets/bootstrap/` (fallback)

---

### 3.2 Font Awesome Icons
**Storage**: CDN

**Locations**:
- `pages/web/onboard-hustler.php`
- `pages/index.php`
- `pages/Admin/admin.php`
- `pages/crm/dashboard/activities-ui.php`
- `pages/crm/dashboard/index.php`
- `pages/crm/client/job-map-view.php`
- `pages/crm/hustlers/job-location.php`
- `pages/crm/hustlers/index.php`
- `partials/Admin-details/details.php`

```html
<!-- Font Awesome 5.15.4 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Font Awesome 6.4.0 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<!-- Font Awesome 6.5.0 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
```

**Also Local**: `assets/build/fontawesome/` (fallback)

---

### 3.3 Popper.js
**Storage**: CDN

**Locations**:
- `pages/web/onboard-hustler.php`
- `pages/index.php`

```html
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
```

---

### 3.4 Chart.js
**Storage**: CDN

**Location**: `partials/layout/crm/footer.php`

```html
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
```

**Purpose**: Dashboard statistics visualization

---

### 3.5 Flatpickr (Date Picker)
**Storage**: CDN

**Location**: `partials/job-portal/create-job-modal.php`

```html
<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
```

**Also Local**: `assets/build/flatpickr/` (fallback)

**Purpose**: Job scheduling date/time picker

---

## 4. Third-Party Service APIs (Vendor Dependencies)

### 4.1 Telegram Bot API
**Storage**: Vendor package
**File**: `vendor/monolog/monolog/src/Monolog/Handler/TelegramBotHandler.php`

```php
private const BOT_API = 'https://api.telegram.org/bot';
```

**Purpose**: Logging notifications (if configured)
**Configuration**: Not in `.env` (optional feature)

---

### 4.2 Mandrill Email API
**Storage**: Vendor package
**File**: `vendor/monolog/monolog/src/Monolog/Handler/MandrillHandler.php`

```php
curl_setopt($ch, CURLOPT_URL, 'https://mandrillapp.com/api/1.0/messages/send-raw.json');
```

**Purpose**: Email logging (if configured)
**Configuration**: Not in `.env` (optional feature)

---

### 4.3 Slack API
**Storage**: Vendor package
**File**: `vendor/monolog/monolog/src/Monolog/Handler/SlackHandler.php`

**Purpose**: Slack notifications for logs (if configured)
**Configuration**: Not in `.env` (optional feature)

---

### 4.4 Pushover API
**Storage**: Vendor package
**File**: `vendor/monolog/monolog/src/Monolog/Handler/PushoverHandler.php`

**Purpose**: Push notifications for logs (if configured)
**Configuration**: Not in `.env` (optional feature)

---

### 4.5 Flowdock API
**Storage**: Vendor package
**File**: `vendor/monolog/monolog/src/Monolog/Handler/FlowdockHandler.php`

**Purpose**: Team communication logs (if configured)
**Configuration**: Not in `.env` (optional feature)

---

### 4.6 SendGrid API
**Storage**: Vendor package
**File**: `vendor/monolog/monolog/src/Monolog/Handler/SendGridHandler.php`

**Purpose**: Email sending via SendGrid (if configured)
**Configuration**: Not in `.env` (optional feature)

---

## Summary of API Storage Locations

### 1. Environment Variables (`.env`)
```env
# Primary Backend API (implicit - used in bindings)
# Base: https://yohpal-hustler-apis-test.onrender.com

# Google Maps API
GOOGLE_MAP_API_KEY = "YOUR_GOOGLE_MAPS_API_KEY_HERE"

# Database (Local)
DB_CONNECTION = 'mysql'
DB_HOST = '127.0.0.1'
DB_PORT = '3306'
DB_NAME = "yohpal_hustler"
DB_USERNAME = "root"
DB_PASSWORD = ""
```

### 2. Bindings File (`bindings/endpoints/endpointsBindings.php`)
- 16 YohPal API endpoints
- Accessed via: `$util->getEndpoint('endpoint_key')`

### 3. Hardcoded in Models
- `data/models/Job.php` - 4 endpoints
- `data/models/Hustler.php` - 6 endpoints

### 4. CDN Links (Hardcoded in HTML)
- Bootstrap CSS/JS
- Font Awesome Icons
- Popper.js
- Chart.js
- Flatpickr

### 5. Vendor Packages (Optional)
- Telegram Bot API
- Mandrill Email API
- Slack API
- Pushover API
- Flowdock API
- SendGrid API

---

## Configuration Required for Production

### Critical (Must Configure):
1. ✅ **Google Maps API Key** - `.env` file
   ```env
   GOOGLE_MAP_API_KEY = "AIzaSyXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"
   ```

2. ✅ **Database Credentials** - `.env` file
   ```env
   DB_HOST = 'your_db_host'
   DB_NAME = "yohpal_hustler"
   DB_USERNAME = "your_username"
   DB_PASSWORD = "your_password"
   ```

### Optional (For Enhanced Features):
3. ⚠️ **Email Service** (SendGrid/Mandrill) - If using email notifications
4. ⚠️ **Slack Webhook** - If using Slack logging
5. ⚠️ **Telegram Bot Token** - If using Telegram notifications
6. ⚠️ **Pushover Keys** - If using push notifications

---

## API Authentication Methods

### YohPal Backend API
**Method**: Bearer Token
**Storage**: Session (`Auth::get('auth_token')`)
**Header**: `Authorization: Bearer {token}`

### Google Maps API
**Method**: API Key
**Storage**: `.env` file
**Usage**: URL parameter `?key={API_KEY}`

### CDN Resources
**Method**: None (Public CDNs)
**Authentication**: Not required

---

## Recommendations

### 1. Centralize API Configuration
Create `utils/config/api.php`:
```php
return [
    'yohpal' => [
        'base_url' => 'https://yohpal-hustler-apis-test.onrender.com',
        'timeout' => 30,
    ],
    'google_maps' => [
        'api_key' => env('GOOGLE_MAP_API_KEY'),
        'libraries' => ['geometry', 'marker'],
    ],
];
```

### 2. Move Hardcoded URLs to Bindings
Update `Job.php` and `Hustler.php` to use `endpointsBindings.php`

### 3. Add API Keys to `.env`
```env
# External APIs
GOOGLE_MAP_API_KEY = "your_key_here"
SENDGRID_API_KEY = "your_key_here"
SLACK_WEBHOOK_URL = "your_webhook_here"
```

### 4. Use Environment-Specific URLs
```env
# Development
API_BASE_URL = "https://yohpal-hustler-apis-test.onrender.com"

# Production
API_BASE_URL = "https://yohpal-hustler-apis.onrender.com"
```
