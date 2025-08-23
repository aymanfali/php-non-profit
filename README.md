
# PHP Non-Profit Organization Platform

A full-stack web application for non-profit organizations, built with a PHP MVC backend and a Vue.js frontend.

## Project Structure

```
php-non-profit/
│
├── backend/         # PHP MVC backend (API & web)
│   ├── App/         # Application core, controllers, models
│   │   ├── Controllers/   # Defining Dashboard and Guest Controllers
│   │   ├── Core/          # App , Router, DotEnv, Session, etc.
│   │   └── Models/        # models (User, News, Impacts, etc.)
│   ├── config/      # Configuration files (uses .env)
│   ├── public/      # Public entry point (index.php)
│   ├── routes/      # Route definitions (web.php, api.php)
|	|__ .gitignore   # Files and Directories ignored on Git
|	|__ .env         # Environment variables (frontend)
|	|__ .htaccess    # Configuration file used on Apache web servers
│   ├── schema.sql   # Database schema (MySQL)
│   ├── storage/     # Logs, uploads
│   ├── vendor/      # Composer dependencies
│   └── README.md    # Backend-specific documentation
│
├── frontend/        # Vue.js SPA frontend (Vite)
│   ├── public/      # Static assets (icons, images, favicon)
│   ├── src/         # Source code
│   │   ├── assets/      # CSS, global styles
│   │   ├── components/  # Reusable Vue components (Dashboard, Forms, etc.)
│   │   ├── views/       # Page views (About, Contact, Dashboard, etc.)
│   │   ├── router/      # Vue Router setup
│   │   ├── stores/      # Pinia stores
│   │   |── App.vue      # Main app component
|	|__ .gitignore   	# Files and Directories ignored on Git
|	|__ .env        	# Environment variables (backend)
│   ├── index.html   	# Main HTML file
│   ├── package.json 	# NPM dependencies
│   ├── vite.config.js   # Vite configuration
│   └── README.md    	# Frontend-specific documentation
│
├── README.md        # This file (project overview)
└── 
```

## How It Works

- **Backend (PHP MVC):**
  - Handles authentication, user management, users, impacts, news, and contact APIs.
  - Uses a custom router for dynamic web and API routes.
  - Connects to MySQL using PDO, with environment config via `.env`.
  - Entry point: `backend/api/public/index.php` (all requests routed through here).

- **Frontend (Vue.js):**
  - Modern SPA built with Vue 3 and Vite.
  - Communicates with backend API via Axios.
  - Features: Dashboard, user CRUD, impacts/news display, authentication, and more.
  - Entry point: `frontend/api/index.html`.

## Setup & Usage

### Backend

1. **Install dependencies:**
	```
	cd backend
	composer install
	```
2. **Configure environment:**
	- Copy `.env.example` to `.env` and set DB credentials.
3. **Import database schema:**
	- Import `schema.sql` into your MySQL server.
4. **Run locally:**
	- Use Apache/Nginx and point document root to `backend/public`.

### Frontend

1. **Install dependencies:**
	```
	cd frontend
	npm install
	```
2. **Configure API base URL:**
	- Set `VITE_API_BASE_URL` in `frontend/.env` to your backend API endpoint.
3. **Run locally:**
	```
	npm run dev
	```
	- Access via `http://localhost:5173`

## Key Features

- Full MVC structure for maintainable PHP backend
- RESTful API for frontend communication
- Secure authentication and session management
- Responsive Vue.js dashboard and public site
- Modular, scalable codebase

## Contributing

1. Fork the repo and create a feature branch.
2. Make your changes and submit a pull request.


