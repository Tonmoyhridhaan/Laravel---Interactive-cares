URL Shortener API
A simple RESTful API built with Laravel that provides URL shortening services. Users can register, log in, shorten URLs, and track the visit count of each shortened URL.

Features
User Registration and Authentication: Secure user registration and login with API token-based authentication.
URL Shortening: Users can shorten long URLs and receive a unique short URL.
Visit Tracking: The API keeps a count of how many times each short URL is visited.
User-Specific URL Listing: Users can view all URLs they've shortened along with their visit counts.
URL Redirection: Short URLs redirect users to the original long URLs.
Technologies Used
Framework: Laravel 11
Database: SQLite


List of API URLs
Register a User

URL: POST /api/register
Log In

URL: POST /api/login
Shorten a URL

URL: POST /api/shorten
List All URLs Created by the User

URL: GET /api/urls
URL Redirection

URL Format: GET /{short_url}
