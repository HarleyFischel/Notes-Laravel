# Notes - Laravel
Notes project developed with the Laravel 5.8 php framework

Simply clone the project, switch to the directory and run:
```
composer install
```
to populate the vendor directory, then run:
```
chmod -R o+w storage
```
to allow the storage directory to be writable, next:
```
mv env.example .env
```
to establish the environment configuration, then:
```
php artisan key:generate
```
to populate the the APP_KEY value in the .env file

### Ready to run the server
```
php artisan serve
```
to start the stand alone server

open http://localhost:8000 in your browser

The interface is a very simple

The first thing you should see is the main notes list as hosted and ran by Laravel. All functionality is handled by the NotesController.

For the single page jquery only version utilizing the ApiController, goto: 
http://localhost:8000/notes

For the single page React only version (no jquery) utilizing the ApiController, goto: 
http://localhost:8000/react



## Project Criteria:
- There should be a list of all notes.
- You should be able to add a note.
- You should be able to edit a note.
- The notes should be persisted and retrieved via a service.
- You should be able to go straight to a note if specified in the url.


- http://localhost:8000/3
- http://localhost:8000/notes/3
- http://localhost:8000/react/3