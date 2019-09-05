<?php

namespace App;

class Notes
{
    private $path = __DIR__."/Data/notes.json";
    private $notes;
    private $model = '{"0":{
        "id":"0",
        "note":""
    }}';

    public function __construct()
    {
        $this->notes = $this->fromJSON(
            @file_get_contents($this->path)
        );
    }

    public function all() {
        return $this->notes;
    }

    public function get($id) {
        return $this->notes->$id;
    }

    public function add($data) {
        if (empty($this->notes)) {
            $this->notes = $this->fromJSON($this->model);
            $id = '0';
        } else {
            $id = ((array_key_last((array)$this->notes) ?? count((array)$this->notes)) + 1);
        }
        $this->notes->$id = (object)['id'=>$id, 'note'=>$data['note']];
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
        file_put_contents($this->path, $this->toJSON($this->notes));
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
