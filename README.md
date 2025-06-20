# 📸 App Photo Album

Welcome to **App Photo Album**, a web application developed as part of my individual end-of-module project at **Coda**.  
The goal is to allow users to create, organize, and share photo albums online with a secure and user-friendly interface.

## 🛠️ Technologies Used

- HTML5 / CSS3 (Orange design system, black theme for admin)
- JavaScript (OOP)
- PHP (OOP)
- SQL (MySQL)
- MVC Architecture
- No external libraries or frameworks

## 📁 Project Structure

app-photo-album/
│
├── index.php
├── config/ # App configuration (DB, constants, etc.)
├── controller/ # PHP controllers (business logic)
├── model/ # PHP models (queries, classes)
├── view/ # HTML views and integration
├── assets/ # CSS, JS, images
└── uploads/ # Photo storage


## ⚙️ Core Features

- 🔐 **User Authentication & Session Management**
- 🖼️ **Create, edit, and delete photo albums**
- 📷 **Add and view photos**
- 💬 **Comment on photos**
- 🧑‍💼 **Admin Panel**
  - View and manage all users
  - Delete any album/photo/comment
  - Moderate content (black admin theme)

## 👥 User Roles

- **Regular Users**: Can manage their own albums and photos, post comments, and view public albums.
- **Administrator**: Has access to a dedicated dark-themed dashboard to manage all users and content.

## 🔒 Security & Validation

- File upload filtering (only JPEG/PNG allowed)
- Session-based page protection
- Access rights by user role (user/admin)
- Client-side (JavaScript) + server-side (PHP) form validation

## 📱 Responsive Design

Designed **mobile-first** and fully responsive for desktop, tablet, and mobile devices.

## 🗃️ Database Schema

The application uses a relational MySQL database with the following tables:

- `users`: User accounts
- `albums`: Albums created by users
- `photos`: Uploaded photos
- `comments`: User comments on photos
- `access_rights`: Permissions between users

## ✅ Upcoming Features (Optional)

- Like system for photos
- Download entire album as ZIP
- Filter photos by tags or categories

## 📌 Project Info

- 🧑 Developed by: Moustapha Mahamat Lamine
- 🎓 Program: Full Stack Developer Bachelor (Coda)
- 📅 Period: April – June 2025
- 📁 Project name: app-photo-album

---

Thanks for checking out this project!  
Feel free to send feedback or suggestions 😊