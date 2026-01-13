# API Endpoints Quick Reference

Base URL: `/api/v1`

## Legend
- 🌐 Public - No authentication required
- 🔐 Auth - Requires authentication token
- 👑 Admin - Requires admin privileges

---

## Authentication

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/auth/login` | 🌐 | Login and get token (Rate: 5/min) |
| POST | `/auth/logout` | 🔐 | Logout and revoke token |
| GET | `/auth/me` | 🔐 | Get authenticated user details |
| PUT | `/auth/me` | 🔐 | Update own profile |
| POST | `/auth/me/avatar` | 🔐 | Upload profile avatar |

---

## Users

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/users` | 👑 | List all users (paginated) |
| POST | `/users` | 👑 | Create new user |
| GET | `/users/{id}` | 👑 | Get user by ID |
| GET | `/users/username/{username}` | 🌐 | Get public profile by username |
| PUT | `/users/{id}` | 👑 | Update user |
| DELETE | `/users/{id}` | 👑 | Delete user |
| GET | `/users/{id}/badges` | 🌐 | Get user's badges |
| POST | `/users/{id}/badges` | 👑 | Assign badges to user |
| DELETE | `/users/{id}/badges` | 👑 | Remove badges from user |
| GET | `/users/{id}/events` | 🔐 | Get user's RSVPed events |
| POST | `/users/{id}/password` | 👑 | Reset user password |

### Query Parameters for GET /users
```
?page=1
&per_page=25
&search=john
&is_admin=true|false
&hidden=true|false
&sort=created_at|username|email
&order=asc|desc
&include=badges,events
```

---

## Events

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/events` | 🌐 | List all events (paginated) |
| GET | `/events/upcoming` | 🌐 | List upcoming events |
| GET | `/events/past` | 🌐 | List past events |
| POST | `/events` | 👑 | Create new event |
| GET | `/events/{id}` | 🌐 | Get event details |
| PUT | `/events/{id}` | 👑 | Update event |
| DELETE | `/events/{id}` | 👑 | Delete event |
| POST | `/events/{id}/image` | 👑 | Upload event image |
| GET | `/events/{id}/attendees` | 🔐 | Get event attendees |
| POST | `/events/{id}/rsvp` | 🔐 | RSVP to event (join) |
| DELETE | `/events/{id}/rsvp` | 🔐 | Cancel RSVP (leave) |

### Query Parameters for GET /events
```
?page=1
&per_page=25
&search=hackathon
&start_after=2025-04-01
&start_before=2025-05-01
&location=Rice Hall
&sort=start|name|created_at
&order=asc|desc
&include=attendees
```

---

## Officers

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/officers` | 🌐 | List all officers (paginated) |
| GET | `/officers/current` | 🌐 | Get current year's officers |
| GET | `/officers/year/{year}` | 🌐 | Get officers for specific year |
| POST | `/officers` | 👑 | Create new officer |
| GET | `/officers/{id}` | 🌐 | Get officer details |
| PUT | `/officers/{id}` | 👑 | Update officer |
| DELETE | `/officers/{id}` | 👑 | Delete officer |
| DELETE | `/officers/year/{year}` | 👑 | Delete all officers for year |

### Query Parameters for GET /officers
```
?page=1
&per_page=50
&year=2025
&position=President
&sort=year|sort_order
&order=asc|desc
```

---

## Badges

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/badges` | 🌐 | List all badges |
| POST | `/badges` | 👑 | Create new badge |
| GET | `/badges/{id}` | 🌐 | Get badge details |
| PUT | `/badges/{id}` | 👑 | Update badge |
| DELETE | `/badges/{id}` | 👑 | Delete badge |
| GET | `/badges/{id}/users` | 👑 | Get users with this badge |

### Badge Colors
```
blue, indigo, purple, pink, red, orange, yellow,
green, teal, cyan, black, white, gray, gray-dark
```

---

## Statistics

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/stats` | 👑 | Get comprehensive admin statistics |
| GET | `/stats/public` | 🌐 | Get public statistics |

---

## Rate Limits

| Endpoint Type | Limit | Applied To |
|--------------|-------|------------|
| Public (🌐) | 60/min | All public endpoints |
| Authenticated (🔐) | 120/min | All authenticated endpoints |
| Admin (👑) | 300/min | All admin endpoints |
| Login | 5/min | `/auth/login` only |

Rate limits are per-user (when authenticated) or per-IP (when not authenticated).

---

## Common Response Codes

| Code | Meaning |
|------|---------|
| 200 | OK - Request successful |
| 201 | Created - Resource created |
| 400 | Bad Request |
| 401 | Unauthorized - Not logged in |
| 403 | Forbidden - Insufficient permissions |
| 404 | Not Found |
| 422 | Validation Error |
| 429 | Rate Limit Exceeded |
| 500 | Server Error |

---

## Legacy Endpoints (Backwards Compatibility)

These endpoints remain available but are deprecated:

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/api/user` | 🔐 | Get authenticated user (use `/api/v1/auth/me`) |
| GET | `/api/admin/users` | 👑 | List users (use `/api/v1/users`) |
| POST | `/api/admin/users` | 👑 | Create user (use `/api/v1/users`) |
| GET | `/api/admin/officers` | 👑 | List officers (use `/api/v1/officers`) |
| POST | `/api/admin/officers` | 👑 | Create officer (use `/api/v1/officers`) |
| DELETE | `/api/admin/officers` | 👑 | Delete all officers |

---

## Example Workflows

### User Registration & Login Flow
```
1. Admin creates user: POST /api/v1/users
2. User logs in: POST /api/v1/auth/login
3. User views profile: GET /api/v1/auth/me
4. User updates profile: PUT /api/v1/auth/me
5. User uploads avatar: POST /api/v1/auth/me/avatar
```

### Event RSVP Flow
```
1. Browse events: GET /api/v1/events/upcoming
2. View event details: GET /api/v1/events/{id}
3. RSVP to event: POST /api/v1/events/{id}/rsvp
4. View attendees: GET /api/v1/events/{id}/attendees
5. Cancel RSVP: DELETE /api/v1/events/{id}/rsvp
```

### Admin Event Management Flow
```
1. Login as admin: POST /api/v1/auth/login
2. Create event: POST /api/v1/events
3. Upload image: POST /api/v1/events/{id}/image
4. View attendees: GET /api/v1/events/{id}/attendees
5. Update event: PUT /api/v1/events/{id}
6. Delete event: DELETE /api/v1/events/{id}
```

### Badge Management Flow
```
1. Create badge: POST /api/v1/badges
2. View all badges: GET /api/v1/badges
3. Assign to user: POST /api/v1/users/{id}/badges
4. View user's badges: GET /api/v1/users/{id}/badges
5. Remove from user: DELETE /api/v1/users/{id}/badges
```

---

## Quick Test Commands

### Test Public Endpoints (No Auth)
```bash
# Get upcoming events
curl http://localhost:8000/api/v1/events/upcoming

# Get current officers
curl http://localhost:8000/api/v1/officers/current

# Get all badges
curl http://localhost:8000/api/v1/badges

# Get public stats
curl http://localhost:8000/api/v1/stats/public
```

### Test Authenticated Endpoints
```bash
# Login first
TOKEN=$(curl -s -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password"}' \
  | jq -r '.data.token')

# Get my profile
curl http://localhost:8000/api/v1/auth/me \
  -H "Authorization: Bearer $TOKEN"

# RSVP to event
curl -X POST http://localhost:8000/api/v1/events/1/rsvp \
  -H "Authorization: Bearer $TOKEN"

# Get my RSVPed events
curl http://localhost:8000/api/v1/users/1/events \
  -H "Authorization: Bearer $TOKEN"
```

### Test Admin Endpoints
```bash
# Login as admin
ADMIN_TOKEN=$(curl -s -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}' \
  | jq -r '.data.token')

# Create new event
curl -X POST http://localhost:8000/api/v1/events \
  -H "Authorization: Bearer $ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Spring Social",
    "start": "2025-05-01T18:00:00Z",
    "location": "Rice Hall",
    "description": "End of semester social event"
  }'

# Create new user
curl -X POST http://localhost:8000/api/v1/users \
  -H "Authorization: Bearer $ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "username": "newuser",
    "email": "newuser@virginia.edu",
    "password": "password123",
    "first_name": "New",
    "last_name": "User"
  }'

# Get admin stats
curl http://localhost:8000/api/v1/stats \
  -H "Authorization: Bearer $ADMIN_TOKEN"
```

---

## Total: 44 Endpoints

- **Authentication:** 5 endpoints
- **Users:** 11 endpoints
- **Events:** 11 endpoints
- **Officers:** 8 endpoints
- **Badges:** 6 endpoints
- **Statistics:** 2 endpoints
- **Legacy:** 6 endpoints (deprecated)
