# BIC4 Project: The films about the unknown

## The films about the unknown

This software lists films and actors belongs to them.
It is possible to search for films by various parameters.

## VIEWS
All routes that are needed are implemented:
 * **GET** ```/actor``` &rarr; Lists all actors
 * **GET** ```/list/actor``` &rarr; Returns JSON of all actors
 * **GET** ```/list/film``` &rarr; Returns JSON of all film
 * **POST** ```/actor``` &rarr; Stores new actors
 * **GET** ```/actor/{slug}``` &rarr; Show actor
 * **PUT** ```/actor/{slug}``` &rarr; Update actor
 * **DELETE** ```/actor/{slug}``` &rarr; Delete actor
 * **GET** ```/actor/{slug}/edit``` &rarr; Edit actor
 * **GET** ```/search/actor``` &rarr; Search actors
 * **POST** ```/search/actor``` &rarr; Query actors
 * **GET** ```/film``` &rarr; Lists all films
 * **GET** ```/list/film``` &rarr; Returns JSON of all film
 * **POST** ```/film``` &rarr; Stores new film
 * **GET** ```/film/{slug}``` &rarr; Show film
 * **PUT** ```/film/{slug}``` &rarr; Update film
 * **DELETE** ```/film/{slug}``` &rarr; Delete film
 * **GET** ```/film/{slug}/edit``` &rarr; Edit film

All views can be found in ```/resources/views```.

### BLADES

 * ```/resources/views/film```
     * /resources/views/film/create.blade.php```
     * /resources/views/film/edit.blade.php```
     * /resources/views/film/index.blade.php```
     * /resources/views/film/show.blade.php```
 * ```/resources/views/actor```
      */resources/views/actor/create.blade.php```
      */resources/views/actor/edit.blade.php```
      */resources/views/actor/index.blade.php```
      */resources/views/actor/search.blade.php```
      */resources/views/actor/show.blade.php```


#### CSS (SCSS)

[Bulma](https://bulma.io) is used to layout and style the website.
If wanted default styles can be overwritten by setting variables in the ```/resources/sass/_variables.scss``` file.
Also it is possible to write custom styles in ```/resources/sass/_custom.scss```.


##### CONFIGURATION

1. Download, extract and move SQLite database file to database directory in cloned project.
2. Run "composer install" and "npm install" in project folder to get all needed libraries.
3. Copy ".env.example" and name it ".env"
4. Run "php artisan key:generate" to generate encryption key for your application.
5. Run "php artisan migrate" to create all needed TABLES.
6. Run "php artisan db:seed" to migrate the DATA
7. Run "php artisan serve" to starte the page
8. Open your webrowser with the following url "http://localhost:8000/home"



