# Notes - Laravel
### /resources/views

The views are setup as simple as possible.

Everything is designed to use a base layout, **/layouts/main.blade.php**. 
This allows all the global stuff to be located in one simple source.

## Notes Controller
#### index.blade.php
The index page used by the NotesController

#### add.blade.php
Used to add a new note through the NotesController

#### edit.blade.php
Used to edit an existing note through the NotesController

#### view.blade.php
Used to open and view a note through the NotesController


#### view.blade.php
Used to open and view a note through the NotesController


## Single pages using javascript to access the Notes API

#### static.blade.php
Used to navigate the notes system using the built in Rest API

http://localhost:8000/notes

This page uses jQuery only to access the notes API 

#### react.blade.php
Used to navigate the notes system using the built in Rest API

http://localhost:8000/react

This page uses React only to access the notes API 
