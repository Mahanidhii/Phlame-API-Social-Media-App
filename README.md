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
Follow these steps to set up and run the project on your local machine.

### 1. Backend Setup (Phlame API)
### Prerequisites:
- XAMPP (or any other local server stack with Apache, PHP and MySQL. This project works on XAMPP) installed.
### Installation:
1. **Clone the repository** into your XAMPP ```htdocs``` directory with.
```git clone https://github.com/Mahanidhii/Phlame-API-Social-Media-App.git C:/xampp/htdocs/Phlame```
2. **Start XAMPP :** Open the XAMPP Control Panel and start the Apache and MySQL services.
3. **Create the Database :**
   - Go to ```http://localhost/phpmyadmin``` in your browser.
   - Create a new database named ```social_media```.
   - Select the ```social_media``` database and go to the "SQL" tab.
   - Execute the following SQL commands to create the necessary table.

```sql
   CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    UNIQUE(user_id, post_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
); 
```


4. **Configure** ```.htaccess```: Ensure the .htaccess in the file in the project root (```/Phlame```) has the ```RewriteBase``` set correctly:
```RewriteBase /Phlame/```
The backend is now running and accessible at ```http://localhost/Phlame-API-Social-Media-App```

### 2. Frontend Setup (Python CLI)
**Prerequisites:**
- Python 3
**Installtion:**
1. Navigate to the project directory in your terminal:
```cd C:/xampp/htdocs/Phlame-API-Social-Media-App```
2. Create a virtual environment (Recommended):

For Windows:
```python
python -m venv venv
venv\Scripts\activate 
```

For Mac & Linux:
```python
python3 -m venv venv
source venv/bin/activate
```

3. Install dependencies from the requirements.txt file:
```python
pip install -r requirements.txt
```

4. **Confirm API URL:** Open the app.py and ensure the API_URL variable is set correct for your environment
```python
API_URL="http://localhost/Phlame"
```


### How To Use
1. Make sure your XAMPP services (Apache & MySQL) are running.
2. Navigate to the project directory in your terminal and activate the virtual environment.
3. Run the application with the following command:
```python
python app.py
```

4. The Application is running now with the backend local server ready to accept requests.
5. Follow the menu shown to register new user, login, view posts, create posts and like them.

# Future Additions : 
1. Delete Posts
2. Edit Posts
3. Photo Posting (Beta)