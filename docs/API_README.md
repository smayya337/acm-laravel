# ACM @ UVA REST API

A comprehensive RESTful API for the ACM @ UVA (Association for Computing Machinery at University of Virginia) platform, built with Laravel 10 and Laravel Sanctum.

## 📚 Documentation Files

- **[API_DOCUMENTATION.md](API_DOCUMENTATION.md)** - Complete API reference with examples
- **[API_IMPLEMENTATION_SUMMARY.md](API_IMPLEMENTATION_SUMMARY.md)** - Implementation details and architecture
- **[API_ENDPOINTS_REFERENCE.md](API_ENDPOINTS_REFERENCE.md)** - Quick reference guide for all endpoints

## 🚀 Quick Start

### 1. Install Dependencies
```bash
composer install
```

### 2. Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Run Migrations
```bash
php artisan migrate
```

### 4. Create an Admin User
```bash
php artisan tinker
```
```php
App\Models\User::create([
    'username' => 'admin',
    'email' => 'admin@virginia.edu',
    'password' => bcrypt('password'),
    'first_name' => 'Admin',
    'last_name' => 'User',
    'is_admin' => true,
    'hidden' => false,
]);
```

### 5. Start the Server
```bash
php artisan serve
```

The API will be available at `http://localhost:8000/api/v1`

## 🔐 Authentication

The API uses token-based authentication via Laravel Sanctum.

### Get a Token
```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@virginia.edu",
    "password": "password"
  }'
```

### Use the Token
```bash
curl http://localhost:8000/api/v1/auth/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

## 📋 API Overview

### Resources

| Resource | Public Endpoints | Authenticated Endpoints | Admin Endpoints |
|----------|-----------------|------------------------|-----------------|
| **Authentication** | Login | Logout, Profile | - |
| **Users** | View profile, badges | View events | Full CRUD, badge mgmt |
| **Events** | List, view | RSVP, attendees | Full CRUD, image upload |
| **Officers** | List, view | - | Full CRUD |
| **Badges** | List, view | - | Full CRUD, user mgmt |
| **Statistics** | Public stats | - | Full stats |

### Total Endpoints: 44
- 38 new v1 endpoints
- 6 legacy endpoints (backwards compatibility)

## 🎯 Key Features

### ✅ Complete CRUD Operations
- Users, Events, Officers, Badges
- Full create, read, update, delete functionality
- Comprehensive validation

### ✅ Advanced Features
- Event RSVP system with duplicate prevention
- Badge assignment and management
- File uploads (avatars, event images)
- Statistics and analytics
- Search and filtering on all list endpoints
- Pagination with metadata
- Sorting (customizable fields and order)

### ✅ Security & Performance
- Token-based authentication (Laravel Sanctum)
- Role-based access control (Public, Authenticated, Admin)
- Rate limiting (5-300 requests/minute depending on tier)
- Input validation on all endpoints
- Proper HTTP status codes and error messages

### ✅ Developer Experience
- Consistent JSON response format
- API versioning (v1)
- Comprehensive documentation
- RESTful conventions
- Backwards compatibility

## 📖 Example Usage

### JavaScript/TypeScript
```javascript
// Login
const response = await fetch('http://localhost:8000/api/v1/auth/login', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    email: 'user@virginia.edu',
    password: 'password'
  })
});
const { data } = await response.json();
const token = data.token;

// Get upcoming events
const events = await fetch('http://localhost:8000/api/v1/events/upcoming', {
  headers: { 'Authorization': `Bearer ${token}` }
}).then(r => r.json());

// RSVP to event
await fetch(`http://localhost:8000/api/v1/events/1/rsvp`, {
  method: 'POST',
  headers: { 'Authorization': `Bearer ${token}` }
});
```

### Python
```python
import requests

# Login
r = requests.post('http://localhost:8000/api/v1/auth/login', json={
    'email': 'user@virginia.edu',
    'password': 'password'
})
token = r.json()['data']['token']

headers = {'Authorization': f'Bearer {token}'}

# Get events
events = requests.get('http://localhost:8000/api/v1/events', headers=headers)

# Create badge (admin)
badge = requests.post('http://localhost:8000/api/v1/badges',
    headers=headers,
    json={
        'name': 'Hackathon Winner',
        'description': 'Won first place',
        'color': 'purple'
    }
)
```

## 🛠️ Development

### Directory Structure
```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       ├── ApiController.php          # Base controller
│   │       └── V1/
│   │           ├── AuthController.php
│   │           ├── UserController.php
│   │           ├── EventController.php
│   │           ├── OfficerController.php
│   │           ├── BadgeController.php
│   │           └── StatsController.php
│   ├── Requests/
│   │   └── Api/
│   │       └── V1/                        # Validation classes
│   └── Resources/                         # API transformers
routes/
└── api.php                                # API routes
```

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=ApiTest
```

### Route List
```bash
# View all API routes
php artisan route:list --path=api/v1
```

## 📊 Rate Limits

| Tier | Rate Limit | Applied To |
|------|-----------|------------|
| Public | 60 requests/minute | Unauthenticated requests |
| Authenticated | 120 requests/minute | Logged-in users |
| Admin | 300 requests/minute | Admin users |
| Login | 5 requests/minute | Login endpoint only |

Rate limits are tracked per-user (authenticated) or per-IP (public).

## 🔄 Response Format

### Success
```json
{
  "success": true,
  "data": { ... },
  "message": "Optional message"
}
```

### Error
```json
{
  "success": false,
  "error": {
    "code": "ERROR_CODE",
    "message": "Error description",
    "details": { ... }
  }
}
```

### Pagination
```json
{
  "success": true,
  "data": [...],
  "meta": {
    "pagination": {
      "current_page": 1,
      "per_page": 25,
      "total": 150,
      "total_pages": 6,
      "has_more": true,
      "links": { ... }
    }
  }
}
```

## 🎓 Use Cases

This API enables:

- **Mobile Applications** - Build iOS/Android apps for ACM @ UVA
- **Single-Page Applications** - Create React/Vue/Angular frontends
- **Third-Party Integrations** - Connect with Discord, Slack, etc.
- **Automation** - Automate event creation, user management
- **Analytics** - Build custom dashboards and reports
- **Webhooks** - Notify external services of events

## 📝 Common Workflows

### User Registration & Profile Management
1. Admin creates user → `POST /users`
2. User logs in → `POST /auth/login`
3. User views profile → `GET /auth/me`
4. User updates bio → `PUT /auth/me`
5. User uploads avatar → `POST /auth/me/avatar`

### Event Discovery & RSVP
1. Browse events → `GET /events/upcoming`
2. View details → `GET /events/{id}`
3. RSVP → `POST /events/{id}/rsvp`
4. View attendees → `GET /events/{id}/attendees`
5. Cancel RSVP → `DELETE /events/{id}/rsvp`

### Admin Event Management
1. Create event → `POST /events`
2. Upload image → `POST /events/{id}/image`
3. View RSVPs → `GET /events/{id}/attendees`
4. Update details → `PUT /events/{id}`
5. View statistics → `GET /stats`

## 🔧 Configuration

### Environment Variables
```env
# Required for API functionality
SANCTUM_STATEFUL_DOMAINS=localhost:8000
SESSION_DRIVER=cookie
```

### CORS Configuration
Edit `config/cors.php` to allow API access from your frontend:
```php
'paths' => ['api/*'],
'allowed_origins' => ['http://localhost:3000'],
```

## 🚦 Status Codes

| Code | Meaning |
|------|---------|
| 200 | OK - Request successful |
| 201 | Created - Resource created |
| 400 | Bad Request - Invalid syntax |
| 401 | Unauthorized - Not authenticated |
| 403 | Forbidden - Insufficient permissions |
| 404 | Not Found - Resource doesn't exist |
| 422 | Unprocessable Entity - Validation failed |
| 429 | Too Many Requests - Rate limit exceeded |
| 500 | Internal Server Error |

## 📞 Support & Contributing

### Reporting Issues
Found a bug? Have a feature request? Please open an issue on the repository.

### Contributing
Contributions are welcome! Please follow these guidelines:
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## 📄 License

This project is part of the ACM @ UVA platform. See LICENSE file for details.

## 🙏 Acknowledgments

Built with:
- Laravel 10
- Laravel Sanctum
- PHP 8.2+

Developed for ACM @ UVA (Association for Computing Machinery at University of Virginia)

---

**For detailed API documentation, see [API_DOCUMENTATION.md](API_DOCUMENTATION.md)**
