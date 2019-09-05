# Notes - Laravel
###/app/Http/Controllers
I kept the controllers simple.

NotesController.php
```
class NotesController extends Controller

    public function index()
    public function add()
    public function edit(int $id)
    public function save(Request $request)
    public function delete($id)
    public function view(int $id)
``` 
ApiController.php
```
class ApiController extends Controller

    public function index()
    public function get(int $id)
    public function update(Request $request)
    public function insert(Request $request)
    public function delete($id)
    public function token()

```