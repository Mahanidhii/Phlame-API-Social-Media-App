# Social Media App - Phlame API framework + Python CLI

## Project Overview 
This project is a Social Media Application built using **[Phlame API framework](https://github.com/Oryvex/phlame)** (a custom micro-framework developed by **[Oryvex](https://github.com/Oryvex)**) and a simple user-friendly Python CLI that gets input and sends the requests to the backend which listens for data using URL.

## Project Features
- **User Authentication** : Secure user registration with password hashing and a session-based login system.
- **Posting** : Logged-in users can create and share new text-based posts.
- **Interactive Feed** Users can view a feed of all posts from all users, sorted chronoloigcally. The feed is interactive allowing users to 
    - Scroll through posts one by one.
    - Like posts directly from the feed by pressing 'L'.
- **Dynamic UI** : The CLI menu is context-aware, changing it's display based on the user's login status.


## Functionality and API endpoints: 
### **Backend** - Phlame API (PHP)
- **Routes Added:**
    - **Static Routes**
        - `/` : Loads the index page
        - `/users/register` : Registers a new user (POST)
        - `/login` : Authenticates a user (POST)
        - `/posts` : Creates a new post (POST)
        - `/posts` : Retrieves all posts (GET)
    - **Dynamic Routes:**
        - `/posts/<id>/like` : Likes a post by its ID (POST)
- **Database Connectivity** : Configured in _inint.php using MySQLi with exception handling.
- **Source Files Added:**
    - register.src.php
    - login.src.php
    - create_posts.src.php
    - get_posts.src.php
    - like_post.src.php

### Frontend - Python CLI
- Sends HTTP requests to the backend via URLs.
- Displays data in terminal.
- Allows user inputs for registration, login, posting, viewing and liking.  



## Tech Stack :
- **Backend :** PHP (Phlame API Framework)
- **Frontend :** Python 3.12
- **Database :** MySQL
- **Server :** XAMPP (Apache, MySQL)
- **Tools used :** Requests library for Python CLI


## Getting Started
Follow these instructions to set up and run the project on your local machine.

### 1. Backend Setup (Phlame API)
