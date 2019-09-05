# Notes - Laravel
### /app

The Notes.php file handles everything accessing the json data.

Designed to operate more like a service, it keeps the functionality simple and clean.

Notes.php
```
namespace App;

class Notes

    private $path = __DIR__."/Data/notes.json";
    private $notes;
    private $model = '{"0":{
        "id":"0",
        "note":""
    }}';

    public function __construct()

    public function all()
    public function get(int $id)
    public function add(array $data)
    public function update(array $data)
    public function delete(int $id)
    public function save()

    private function toJSON($data)
    private function fromJSON($data)

```