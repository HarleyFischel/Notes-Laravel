<?php

namespace App;

class Notes
{
    static public $path = __DIR__."/Data/notes.json";
    static private $data;
    private $notes;

    public function __construct()
    {
        $this->notes = $this->fromJSON(
            file_get_contents(__DIR__."/Data/notes.json")
        );
        self::$data = $this->notes;
    }

    public function all() {
        return $this->notes;
    }

    public function get($id) {
        return $this->notes->$id;
    }

    public function add($data) {
        $id = ((array_key_last((array)$this->notes)??count((array)$this->notes))+1);
        $this->notes->$id = ['id'=>$id, 'note'=>$data['note']];
        $this->save();
    }

    public function update($data) {
        $id = $data['id'];
        $this->notes->$id = ['id'=>$id, 'note'=>$data['note']];
        $this->save();
    }

    public function delete($id) {
        unset($this->notes->$id);
        $this->save();
    }

    public function save()
    {
        file_put_contents(__DIR__."/Data/notes.json", $this->toJSON($this->notes));
    }

    /**
     * @param $data
     *
     * @return false|string
     */
    private function toJSON($data)
    {
        return json_encode($data);
    }

    /**
     * @param $data
     *
     * @return false|string
     */
    private function fromJSON($data)
    {
        return json_decode($data);
    }
}
