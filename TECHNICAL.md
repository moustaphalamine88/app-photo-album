# 📸 App Photo Album – Technical Documentation

## 1. Project Overview

**App Photo Album** is a web application that allows users to create, organize, and share photo albums online. The application is built using PHP (OOP), MySQL, HTML5, CSS3, and JavaScript, following the MVC (Model-View-Controller) architecture.

---

## 2. Architecture

- **MVC Pattern:**  
  - **Models:** Handle database interactions and business logic (located in [`Models/`](Models/)).
  - **Views:** HTML templates for user interfaces (located in [`Views/`](Views/)).
  - **Controllers:** Manage user requests and coordinate between models and views (located in [`controllers/`](controllers/)).

- **Routing:**  
  All requests are routed through [`index.php`](index.php), which dispatches actions based on the `page` parameter.

---

## 3. Main Features

- User authentication and session management
- Album creation, editing, and deletion
- Photo upload (JPEG/PNG), viewing, and deletion
- Commenting on photos
- Favorites and likes system
- Admin dashboard for user and content management
- Responsive design (mobile-first)
- Security: input validation, file type filtering, session-based access control

---

## 4. Database Structure

The application uses a MySQL database. Main tables include:

- `users`: Stores user accounts and roles
- `albums`: Stores album metadata
- `photos`: Stores photo file info and associations
- `comments`: Stores user comments on photos
- `favorites`: Stores user favorite photos
- `likes`: Stores user likes on photos

See [`app_photo_album.sql`](app_photo_album.sql) for the full schema.

---

## 5. Directory Structure

```
app-photo-album/
│
├── index.php
├── config/           # App configuration (DB, constants)
├── controllers/      # PHP controllers (business logic)
├── Models/           # PHP models (database queries, classes)
├── Views/            # HTML views and integration
├── assets/           # CSS, JS, images
└── uploads/          # Photo storage
```

---

## 6. Key Files

- [`index.php`](index.php): Main entry point and router
- [`config/Database.php`](config/Database.php): Database connection class
- [`Models/User.php`](Models/User.php): User model (authentication, registration)
- [`Models/Album.php`](Models/Album.php): Album model
- [`Models/Photo.php`](Models/Photo.php): Photo model
- [`controllers/AlbumController.php`](controllers/AlbumController.php): Album controller
- [`controllers/PhotoController.php`](controllers/PhotoController.php): Photo controller
- [`Views/user_home.php`](Views/user_home.php): User dashboard view

---

## 7. Security

- Only authenticated users can access protected pages
- File uploads are filtered by MIME type and extension (JPEG/PNG only)
- User input is validated both client-side and server-side
- Role-based access: admin vs. regular user
- Sessions are used for authentication and authorization

---

## 8. How to Run

1. Import the database using [`app_photo_album.sql`](app_photo_album.sql).
2. Configure database credentials in [`config/Database.php`](config/Database.php).
3. Place the project in your web server root (e.g., `htdocs` for XAMPP).
4. Access the app via `http://localhost/App-photo-album/index.php`.

---

## 9. Extending the Application

- Add new features by creating new controllers, models, and views.
- Follow the MVC pattern for maintainability.
- Use prepared statements for all database queries.

---

## 10. Author

- **Developer:** Moustapha Mahamat Lamine
- **Program:** Full Stack Developer Bachelor (Coda)
- **Period:** April – June 2025