# ACM @ UVA REST API Documentation

## Base URL
```
Production: https://your-domain.com/api/v1
Development: http://localhost:8000/api/v1
```

## Authentication

The API uses Laravel Sanctum for token-based authentication.

### Getting a Token
```http
POST /api/v1/auth/login
Content-Type: application/json

{
  "email": "user@virginia.edu",
  "password": "password123"
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": { ... },
    "token": "1|abc123...",
    "token_type": "Bearer"
  }
}
```

### Using the Token
Include the token in the Authorization header:
```
Authorization: Bearer 1|abc123...
```

## Response Format

### Success Response
```json
{
  "success": true,
  "data": { ... },
  "message": "Optional message"
}
```

### Error Response
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

### Paginated Response
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
      "links": {
        "first": "...",
        "last": "...",
        "prev": null,
        "next": "..."
      }
    }
  }
}
```

## Rate Limiting

| Endpoint Type | Rate Limit | Header |
|--------------|------------|--------|
| Public | 60 requests/minute | X-RateLimit-Limit: 60 |
| Authenticated | 120 requests/minute | X-RateLimit-Limit: 120 |
| Admin | 300 requests/minute | X-RateLimit-Limit: 300 |
| Login | 5 requests/minute | X-RateLimit-Limit: 5 |

## Endpoints

### Authentication

#### POST /auth/login
**Rate Limit:** 5/minute
**Auth:** None

Login and receive an API token.

**Request:**
```json
{
  "email": "user@virginia.edu",
  "password": "password123"
}
```

**Response:** See Authentication section above

---

#### POST /auth/logout
**Auth:** Required

Revoke the current authentication token.

**Response:**
```json
{
  "success": true,
  "message": "Logout successful"
}
```

---

#### GET /auth/me
**Auth:** Required

Get authenticated user details with badges and events.

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "username": "jsmith",
    "email": "jsmith@virginia.edu",
    "first_name": "John",
    "last_name": "Smith",
    "is_admin": false,
    "hidden": false,
    "bio": "CS major, class of 2026",
    "image": "users/abc123.jpg",
    "image_url": "https://.../storage/users/abc123.jpg",
    "badges": [...],
    "events": [...],
    "created_at": "2025-04-11T18:00:00Z",
    "updated_at": "2025-04-11T18:00:00Z"
  }
}
```

---

#### PUT /auth/me
**Auth:** Required

Update authenticated user's profile.

**Request:**
```json
{
  "username": "newusername",
  "email": "newemail@virginia.edu",
  "first_name": "John",
  "last_name": "Smith",
  "bio": "Updated bio"
}
```

---

#### POST /auth/me/avatar
**Auth:** Required
**Content-Type:** multipart/form-data

Upload profile avatar image.

**Form Data:**
- `image`: Image file (JPEG, PNG, JPG, GIF)

---

### Users

#### GET /users
**Auth:** Admin

List all users with pagination and filters.

**Query Parameters:**
- `page` (int): Page number
- `per_page` (int): Results per page (default: 25)
- `search` (string): Search by name, username, or email
- `is_admin` (bool): Filter by admin status
- `hidden` (bool): Filter by hidden status
- `sort` (string): Sort field (default: created_at)
- `order` (asc|desc): Sort order (default: desc)
- `include` (string): Comma-separated relations (badges, events)

**Example:**
```
GET /users?search=john&per_page=50&include=badges
```

---

#### POST /users
**Auth:** Admin

Create a new user.

**Request:**
```json
{
  "username": "jsmith",
  "email": "jsmith@virginia.edu",
  "password": "password123",
  "first_name": "John",
  "last_name": "Smith",
  "is_admin": false,
  "hidden": false,
  "bio": "Optional bio"
}
```

---

#### GET /users/{id}
**Auth:** Admin

Get user details by ID.

---

#### GET /users/username/{username}
**Auth:** Public (respects hidden flag)

Get public user profile by username.

---

#### PUT /users/{id}
**Auth:** Admin

Update user details.

---

#### DELETE /users/{id}
**Auth:** Admin

Delete a user.

---

#### GET /users/{id}/badges
**Auth:** Public

Get user's badges.

---

#### POST /users/{id}/badges
**Auth:** Admin

Assign badges to user.

**Request:**
```json
{
  "badge_ids": [1, 2, 3]
}
```

---

#### DELETE /users/{id}/badges
**Auth:** Admin

Remove badges from user.

**Request:**
```json
{
  "badge_ids": [1, 2]
}
```

---

#### GET /users/{id}/events
**Auth:** Authenticated

Get events user has RSVPed to.

---

#### POST /users/{id}/password
**Auth:** Admin

Reset user password.

**Request:**
```json
{
  "password": "newpassword123",
  "password_confirmation": "newpassword123"
}
```

---

### Events

#### GET /events
**Auth:** Public

List all events with pagination and filters.

**Query Parameters:**
- `page` (int): Page number
- `per_page` (int): Results per page (default: 25)
- `search` (string): Search by name, description, or location
- `start_after` (date): Filter events starting after date
- `start_before` (date): Filter events starting before date
- `location` (string): Filter by location
- `sort` (string): Sort field (default: start)
- `order` (asc|desc): Sort order (default: asc)
- `include` (string): Include attendees

**Example:**
```
GET /events?start_after=2025-04-01&include=attendees
```

---

#### GET /events/upcoming
**Auth:** Public

List upcoming events (start >= now).

---

#### GET /events/past
**Auth:** Public

List past events (start < now).

---

#### POST /events
**Auth:** Admin

Create a new event.

**Request:**
```json
{
  "name": "Spring Hackathon 2025",
  "start": "2025-04-15T09:00:00Z",
  "end": "2025-04-15T21:00:00Z",
  "location": "Rice Hall 130",
  "description": "24-hour hackathon for all skill levels"
}
```

---

#### GET /events/{id}
**Auth:** Public

Get event details including attendee count.

---

#### PUT /events/{id}
**Auth:** Admin

Update event details.

---

#### DELETE /events/{id}
**Auth:** Admin

Delete an event.

---

#### POST /events/{id}/image
**Auth:** Admin
**Content-Type:** multipart/form-data

Upload event image.

**Form Data:**
- `image`: Image file (JPEG, PNG, JPG, GIF)

---

#### GET /events/{id}/attendees
**Auth:** Authenticated

Get list of users who RSVPed to this event.

---

#### POST /events/{id}/rsvp
**Auth:** Authenticated

RSVP to an event (join).

**Response:**
```json
{
  "success": true,
  "message": "RSVP successful",
  "data": { ... }
}
```

**Errors:**
- `422 ALREADY_RSVPED`: Already RSVPed to this event

---

#### DELETE /events/{id}/rsvp
**Auth:** Authenticated

Cancel RSVP (leave).

**Errors:**
- `422 NOT_RSVPED`: Haven't RSVPed to this event

---

### Officers

#### GET /officers
**Auth:** Public

List all officers with pagination.

**Query Parameters:**
- `page` (int): Page number
- `per_page` (int): Results per page (default: 50)
- `year` (int): Filter by academic year
- `position` (string): Filter by position
- `sort` (string): Sort field (default: year)
- `order` (asc|desc): Sort order (default: desc)

---

#### GET /officers/current
**Auth:** Public

Get current year's officers sorted by sort_order.

---

#### GET /officers/year/{year}
**Auth:** Public

Get officers for a specific academic year.

**Example:**
```
GET /officers/year/2025
```

---

#### POST /officers
**Auth:** Admin

Create a new officer entry.

**Request:**
```json
{
  "position": "President",
  "year": 2025,
  "sort_order": 1,
  "user_id": 5
}
```

---

#### GET /officers/{id}
**Auth:** Public

Get officer details.

---

#### PUT /officers/{id}
**Auth:** Admin

Update officer details.

---

#### DELETE /officers/{id}
**Auth:** Admin

Delete a specific officer.

---

#### DELETE /officers/year/{year}
**Auth:** Admin

Delete all officers for a specific year.

---

### Badges

#### GET /badges
**Auth:** Public

List all badges.

**Query Parameters:**
- `per_page` (int): Optional pagination
- `sort` (string): Sort field (default: name)
- `order` (asc|desc): Sort order (default: asc)

**Note:** Without `per_page`, returns all badges unpaginated.

---

#### POST /badges
**Auth:** Admin

Create a new badge.

**Request:**
```json
{
  "name": "Hackathon Winner",
  "description": "Won first place in an ACM hackathon",
  "color": "purple"
}
```

**Valid Colors:**
- blue, indigo, purple, pink, red, orange, yellow
- green, teal, cyan, black, white, gray, gray-dark

---

#### GET /badges/{id}
**Auth:** Public

Get badge details including user count.

---

#### PUT /badges/{id}
**Auth:** Admin

Update badge details.

---

#### DELETE /badges/{id}
**Auth:** Admin

Delete a badge.

---

#### GET /badges/{id}/users
**Auth:** Admin

Get users who have this badge.

---

### Statistics

#### GET /stats
**Auth:** Admin

Get comprehensive admin statistics.

**Response:**
```json
{
  "success": true,
  "data": {
    "users": {
      "total": 150,
      "admins": 5,
      "hidden": 3
    },
    "events": {
      "total": 45,
      "upcoming": 8,
      "past": 37
    },
    "officers": {
      "total": 28,
      "current_year": 7
    },
    "badges": {
      "total": 15,
      "assigned": 234
    },
    "rsvps": {
      "total": 892
    }
  }
}
```

---

#### GET /stats/public
**Auth:** Public

Get public statistics.

**Response:**
```json
{
  "success": true,
  "data": {
    "members": 147,
    "upcoming_events": 8,
    "total_events": 45,
    "active_officers": 7
  }
}
```

---

## HTTP Status Codes

| Code | Description |
|------|-------------|
| 200 | OK - Request successful |
| 201 | Created - Resource created successfully |
| 400 | Bad Request - Malformed request |
| 401 | Unauthorized - Missing/invalid authentication |
| 403 | Forbidden - Insufficient permissions |
| 404 | Not Found - Resource doesn't exist |
| 422 | Unprocessable Entity - Validation errors |
| 429 | Too Many Requests - Rate limit exceeded |
| 500 | Internal Server Error - Server error |

## Error Codes

| Code | Description |
|------|-------------|
| VALIDATION_ERROR | Request validation failed |
| INVALID_CREDENTIALS | Invalid email or password |
| UNAUTHORIZED | Not authenticated |
| FORBIDDEN | Insufficient permissions |
| NOT_FOUND | Resource not found |
| ALREADY_RSVPED | Already RSVPed to event |
| NOT_RSVPED | Not RSVPed to event |
| DUPLICATE_BADGES | User already has selected badges |

## Example Usage

### JavaScript (Fetch API)

```javascript
// Login
const loginResponse = await fetch('http://localhost:8000/api/v1/auth/login', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    email: 'user@virginia.edu',
    password: 'password123'
  })
});
const { data } = await loginResponse.json();
const token = data.token;

// Get upcoming events
const eventsResponse = await fetch('http://localhost:8000/api/v1/events/upcoming', {
  headers: { 'Authorization': `Bearer ${token}` }
});
const events = await eventsResponse.json();

// RSVP to event
await fetch(`http://localhost:8000/api/v1/events/${eventId}/rsvp`, {
  method: 'POST',
  headers: { 'Authorization': `Bearer ${token}` }
});
```

### Python (Requests)

```python
import requests

# Login
response = requests.post('http://localhost:8000/api/v1/auth/login', json={
    'email': 'user@virginia.edu',
    'password': 'password123'
})
token = response.json()['data']['token']

# Get events
headers = {'Authorization': f'Bearer {token}'}
events = requests.get('http://localhost:8000/api/v1/events', headers=headers)

# Create event (admin)
new_event = requests.post('http://localhost:8000/api/v1/events',
    headers=headers,
    json={
        'name': 'New Event',
        'start': '2025-05-01T18:00:00Z',
        'location': 'Rice Hall',
        'description': 'Event description'
    }
)
```

### cURL

```bash
# Login
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@virginia.edu","password":"password123"}'

# Get events with token
curl http://localhost:8000/api/v1/events \
  -H "Authorization: Bearer 1|abc123..."

# RSVP to event
curl -X POST http://localhost:8000/api/v1/events/1/rsvp \
  -H "Authorization: Bearer 1|abc123..."
```

## Legacy Endpoints (Backwards Compatibility)

The following legacy endpoints are maintained for backwards compatibility:

```
GET    /api/user
GET    /api/admin/users
POST   /api/admin/users
GET    /api/admin/officers
POST   /api/admin/officers
DELETE /api/admin/officers
```

**Note:** New applications should use the v1 endpoints instead.
