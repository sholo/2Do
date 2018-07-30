# 2Do
This is a small project to understand and practice how to create an Rest API.
This is a To-Do project and you could create categories and tasks for an specific user

The project is created with **Laravel Framework 5.4.36** and **PHP 5.6**

### Steps to install the project:
1. Install **Composer**
2. Run **composer install**
3. Create **.env** file
4. Run **php artisan key:generate**
5. Create your database
6. Add configuration to .env file
7. Run **php artisan migrate**
8. Run **php artisan db:seed** (only in Dev environment)
9. Use these endpoints:
#### For register an user
POST: api/register
Body: {
    'name': 'juan',
    'email': 'juan@email.com',
    'password': 'secret',
    'c_password': 'secret',
}

#### For log in an user
POST: api/login
Body: {
    'email': 'juan@email.com',
    'password': 'secret',
}

#### To see details of an user
POST: api/get-details
Headers: {
    'Accept': 'application/json',
    'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1',
}

#### For create a category
POST: api/categories/
Headers: {
    'Accept': 'application/json',
    'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1',
}
Body: {
    'name': 'New Category',
}

*Requests **GET**, has a bug with Passport. If you remove passport, this works without problems*
