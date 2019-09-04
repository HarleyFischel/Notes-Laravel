# Notes - Laravel
Notes project developed with the Laravel 5.8 php framework

Simply clone the project and run:
```
php artisan serve
```

open http://localhost:8000 in your browser

The interface is a very simple

The first thing you should see is the main notes list as hosted and ran by Laravel. All functionality is handled by the NotesController.

For a single page jquery only version utilizing the ApiController, goto: 
http://localhost:8000/notes

For a single page React only version (no jquery) utilizing the ApiController, goto: 
http://localhost:8000/react



## Criteria:
- There should be a list of all notes.
- You should be able to add a note.
- You should be able to edit a note.
- The notes should be persisted and retrieved via a service.
- You should be able to go straight to a note if specified in the url.


- http://localhost:8000/3
- http://localhost:8000/notes/3
- http://localhost:8000/react/3