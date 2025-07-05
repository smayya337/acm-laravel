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

- **Backend**: Laravel 11
- **Frontend**: Tailwind CSS + DaisyUI
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel's built-in authentication

## Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd acm-laravel
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   - Update `.env` with your database credentials
   - Run migrations: `php artisan migrate`
   - Seed the database: `php artisan db:seed`

5. **Storage setup**
   ```bash
   php artisan storage:link
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

## Admin Access

After seeding the database, you can log in with:
- **Username**: admin
- **Password**: password

Visit `/admin` to access the admin dashboard.

## Key Features

### Admin Dashboard
- **Statistics Overview**: View total users, events, officers, and badges
- **Event Management**: Create, edit, and delete events
- **User Management**: Manage user accounts and profiles
- **Officer Management**: Add and manage current and past officers
- **Badge System**: Create and assign badges to users
- **Carousel Management**: Manage home page carousel images
- **HSPC Management**: Upload contest materials and problem sets
- **Navigation Management**: Customize navbar links

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
- **CarouselImage**: Home page carousel images
- **HSPCContest**: HSPC contest materials and problem sets
- **NavBarLink**: Customizable navigation links

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## License

This project is licensed under the MIT License.
