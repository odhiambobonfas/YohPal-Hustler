# Browser Errors Analysis & Solutions

## Issues Identified

### 1. Google Maps JavaScript API Loading Error
**Error**: `Google Maps JavaScript API has been loaded directly without loading=async`

**Current Implementation** (in `footer.php`):
```html
<script src="https://maps.googleapis.com/maps/api/js?key=<?= env('GOOGLE_MAP_API_KEY') ?>&libraries=geometry&libraries=marker" defer="defer"></script>
```

**Problems**:
- Missing `loading=async` parameter
- Invalid API key (`YOUR_GOOGLE_MAPS_API_KEY_HERE` in `.env`)
- Duplicate `libraries` parameter
- Using deprecated `defer` attribute with Google Maps

**Solution**:
```html
<script async src="https://maps.googleapis.com/maps/api/js?key=<?= env('GOOGLE_MAP_API_KEY') ?>&libraries=geometry,marker&callback=initMap"></script>
```

---

### 2. Invalid Google Maps API Key
**Error**: `Google Maps JavaScript API warning: InvalidKey`

**Current `.env`**:
```
GOOGLE_MAP_API_KEY = "YOUR_GOOGLE_MAPS_API_KEY_HERE"
```

**Solution**:
1. Get valid API key from [Google Cloud Console](https://console.cloud.google.com/)
2. Enable required APIs:
   - Maps JavaScript API
   - Geocoding API
   - Places API
3. Update `.env`:
```
GOOGLE_MAP_API_KEY = "AIzaSyXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"
```

---

### 3. Invalid Selector Error
**Error**: `Invalid selector element passed to addNewUploadSection master.js:278:15`

**Location**: `master.js` line 278

**Problem**:
```javascript
addNewUploadSection(selector) {
    const btn = document.querySelector(selector);
    if (!documentContains(btn)) {
        console.warn("Invalid selector element passed to addNewUploadSection");
        return;
    }
}
```

**Cause**: Function called with invalid/non-existent selector

**Solution**:
- Check where `addNewUploadSection()` is called
- Ensure selector exists in DOM before calling
- Add validation:
```javascript
if (selector && typeof selector === 'string') {
    const btn = document.querySelector(selector);
    // rest of code
}
```

---

### 4. Source Map Missing
**Error**: `Source map error: bootstrap.min.css.map`

**Problem**: Bootstrap CSS references non-existent source map

**Solutions**:

**Option 1** - Create `.htaccess` rule to ignore:
```apache
<FilesMatch "\\.map$">
    Header set Cache-Control "no-store"
</FilesMatch>
```

**Option 2** - Remove source map reference from `bootstrap.min.css`:
```bash
sed -i '$ d' assets/bootstrap/css/bootstrap.min.css
```

**Option 3** - Download source map:
```bash
cd assets/bootstrap/css/
wget https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css.map
```

---

## API Handling Issues

### Current API Architecture

**Problems Identified**:

1. **No Centralized API Handler**
   - API calls scattered across controllers
   - Inconsistent error handling
   - No request/response interceptors

2. **Hardcoded API URLs**
   ```php
   $endpoint = "https://yohpal-hustler-apis-test.onrender.com/jobs/create";
   ```

3. **Mixed API Handling**
   - Some use `endpointsBindings.php`
   - Others hardcode URLs directly
   - Inconsistent authentication

4. **No API Response Caching**
   - Repeated calls for same data
   - No offline support

5. **Poor Error Handling**
   ```php
   return [
       'error' => true,
       'message' => $error->getMessage(),
   ];
   ```

---

## Recommended Solutions

### 1. Fix Google Maps Loading

**File**: `partials/layout/crm/footer.php`

**Replace**:
```html
<script src="https://maps.googleapis.com/maps/api/js?key=<?= env('GOOGLE_MAP_API_KEY') ?>&libraries=geometry&libraries=marker" defer="defer"></script>
```

**With**:
```html
<script>
    function initMap() {
        // Map initialization callback
        if (typeof Master !== 'undefined') {
            console.log('Google Maps loaded successfully');
        }
    }
</script>
<script async src="https://maps.googleapis.com/maps/api/js?key=<?= env('GOOGLE_MAP_API_KEY') ?>&libraries=geometry,marker&callback=initMap"></script>
```

---

### 2. Centralize API Configuration

**Create**: `utils/config/api.php`

```php
<?php
return [
    'base_url' => env('API_BASE_URL', 'https://yohpal-hustler-apis-test.onrender.com'),
    'timeout' => 30,
    'retry_attempts' => 3,
    'cache_ttl' => 300, // 5 minutes
];
```

**Update `.env`**:
```
API_BASE_URL = "https://yohpal-hustler-apis-test.onrender.com"
API_TIMEOUT = 30
API_CACHE_ENABLED = true
```

---

### 3. Create API Service Layer

**Create**: `utils/Http/ApiService.php`

```php
<?php
namespace Yohpal\Utils;

use GuzzleHttp\Client;
use Yohpal\Application\Auth;

class ApiService {
    private $client;
    private $baseUrl;
    
    public function __construct() {
        $this->baseUrl = config('api.base_url');
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => config('api.timeout', 30),
        ]);
    }
    
    public function get($endpoint, $params = []) {
        return $this->request('GET', $endpoint, ['query' => $params]);
    }
    
    public function post($endpoint, $data = []) {
        return $this->request('POST', $endpoint, ['json' => $data]);
    }
    
    public function put($endpoint, $data = []) {
        return $this->request('PUT', $endpoint, ['json' => $data]);
    }
    
    private function request($method, $endpoint, $options = []) {
        $token = Auth::get('auth_token');
        if ($token) {
            $options['headers']['Authorization'] = "Bearer {$token->token}";
        }
        
        try {
            $response = $this->client->request($method, $endpoint, $options);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}
```

---

### 4. Update Models to Use ApiService

**Example**: Update `Job.php`

**Before**:
```php
$endpoint = "https://yohpal-hustler-apis-test.onrender.com/jobs/create";
$response = $this->client->post($endpoint, [...]);
```

**After**:
```php
$api = new ApiService();
$response = $api->post('/jobs/create', $jobDetails);
```

---

### 5. Add JavaScript API Handler

**Create**: `assets/js/global/api.js`

```javascript
class ApiHandler {
    constructor() {
        this.baseUrl = '/api';
    }
    
    async request(method, endpoint, data = null) {
        const options = {
            method,
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        };
        
        if (data) options.body = JSON.stringify(data);
        
        try {
            const response = await fetch(`${this.baseUrl}${endpoint}`, options);
            return await response.json();
        } catch (error) {
            console.error('API Error:', error);
            return { status: 'error', message: error.message };
        }
    }
    
    get(endpoint) { return this.request('GET', endpoint); }
    post(endpoint, data) { return this.request('POST', endpoint, data); }
    put(endpoint, data) { return this.request('PUT', endpoint, data); }
}

const api = new ApiHandler();
```

---

### 6. Fix Map Initialization

**Update**: `assets/js/global/master.js`

**Add before class**:
```javascript
let googleMapsLoaded = false;
window.initMap = function() {
    googleMapsLoaded = true;
    console.log('Google Maps API loaded');
};
```

**Update `setMapOnPage` method**:
```javascript
async setMapOnPage(hustlerData = [], domSection = ".geomap") {
    // Wait for Google Maps to load
    if (typeof google === 'undefined') {
        console.warn('Google Maps not loaded yet');
        return;
    }
    
    try {
        // existing code...
    } catch (error) {
        console.error("Map error:", error);
    }
}
```

---

## Implementation Priority

### High Priority (Fix Immediately)
1. ✅ Update Google Maps API key in `.env`
2. ✅ Fix Google Maps loading with `async` and `callback`
3. ✅ Fix invalid selector error in `master.js`

### Medium Priority (This Week)
4. ⚠️ Create centralized `ApiService` class
5. ⚠️ Update all models to use `ApiService`
6. ⚠️ Add proper error handling

### Low Priority (Future Enhancement)
7. 📋 Add API response caching
8. 📋 Implement request retry logic
9. 📋 Add API rate limiting
10. 📋 Create API documentation generator

---

## Testing Checklist

- [ ] Google Maps loads without errors
- [ ] Valid API key configured
- [ ] Map displays correctly
- [ ] No console errors for selectors
- [ ] API calls work consistently
- [ ] Error handling works properly
- [ ] Authentication tokens passed correctly
- [ ] Source map warnings resolved
