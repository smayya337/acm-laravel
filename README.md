# ACM @ UVA Laravel Website

This is a Laravel-based replication of the ACM @ UVA Django website, featuring a modern admin interface and all the original functionality.

## Features

- **Home Page**: Carousel with images and call-to-action buttons
- **About Page**: Information about ACM @ UVA with current officers
- **Events**: Event listing and individual event pages with RSVP functionality
- **ICPC**: Information about the International Collegiate Programming Contest
- **HSPC**: High School Programming Contest information and resources
- **Donate**: Donation page with Venmo and Zelle links
- **User Profiles**: User profiles with badges and event attendance
- **Admin Interface**: Comprehensive admin dashboard for managing all content

## Technology Stack

- **Backend**: Laravel 10
- **Frontend**: Tailwind CSS + DaisyUI
- **Database**: SQLite
- **Authentication**: Laravel's built-in authentication (maybe NetBadge someday?)

## Developer Setup Instructions

This works with VSCode Dev Containers. You'll need that extension and Docker to run the containers.

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd acm-laravel
   ```

2. **Open in Dev Container** -- wait for it to set up

3. **Paste the following into `.env`**
   ```
   APP_NAME="ACM @ UVA"
   APP_ENV=local
   APP_KEY=
   APP_DEBUG=true
   APP_URL=http://localhost:8080

   LOG_CHANNEL=stack
   LOG_DEPRECATIONS_CHANNEL=null
   LOG_LEVEL=debug

   DB_CONNECTION=sqlite
   ```

4. **Run setup commands**
   ```bash
   php artisan migrate
   php artisan db:seed
   php artisan key:generate
   php artisan storage:link
   ```

5. **Start the development server**
   ```bash
   php composer.phar dev
   ```

6. **Open `http://localhost:8000` in your browser**

## Admin Access

After seeding the database, you can log in with:
- **Username**: admin
- **Password**: password1234

Visit `/admin` to access the admin dashboard.

## Key Features

### Admin Dashboard
- **Statistics Overview**: View total users, events, officers, and badges
- **Event Management**: Create, edit, and delete events
- **User Management**: Manage user accounts and profiles
- **Officer Management**: Add and manage current and past officers
- **Badge System**: Create and assign badges to users

### User Features
- **Event RSVP**: Users can RSVP for events
- **Profile Management**: Users can edit their profiles and upload images
- **Badge Display**: Show user achievements and badges
- **Event History**: Track events attended by users

## File Structure

```
resources/views/
├── layouts/
│   └── app.blade.php          # Main layout with navigation
├── index.blade.php            # Home page
├── about.blade.php            # About page
├── events/
│   ├── index.blade.php        # Events listing
│   └── show.blade.php         # Individual event page
├── users/
│   └── show.blade.php         # User profile page
├── admin/
│   ├── index.blade.php        # Admin dashboard
│   ├── events.blade.php       # Event management
│   └── users.blade.php        # User management
├── icpc.blade.php             # ICPC information
├── hspc.blade.php             # HSPC information
├── donate.blade.php           # Donation page
└── errors/
    ├── 404.blade.php          # 404 error page
    └── 500.blade.php          # 500 error page
```

## Models

- **User**: Extended with badges, events, bio, and admin status
- **Event**: Events with attendees, images, and descriptions
- **Officer**: Current and past officers with positions and years
- **Badge**: User achievements with colors and descriptions
