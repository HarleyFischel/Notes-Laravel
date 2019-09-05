<?php

namespace App;

/**
 * Class Notes
 *
 * @package App
 */
class Notes
{
    /**
     * @var string
     */
    private $path = __DIR__."/Data/notes.json";

    /**
     * @var \stdClass
     */
    private $notes;

    /**
     * @var string
     */
    private $model = '{"0":{
        "id":"0",
        "note":""
    }}';

    /**
     * Notes constructor.
     */
    public function __construct()
    {
        $this->notes = $this->fromJSON(
            @file_get_contents($this->path)
        );
    }

    /**
     * @return false|\stdClass|string
     */
    public function all()
    {
        return $this->notes;
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function get(int $id)
    {
        return $this->notes->$id;
    }

    /**
     * @param array $data
     */
    public function add(array $data)
    {
        if (empty($this->notes)) {
            $this->notes = $this->fromJSON($this->model);
            $id = 0;
        } else {
            $id = ((array_key_last((array)$this->notes) ?? count((array)$this->notes)) + 1);
        }
        $this->notes->$id = (object)['id'=>$id, 'note'=>$data['note']];
        $this->save();
    }

    /**
     * @param array $data
     */
    public function update(array $data)
    {
        $id = $data['id'];
        $this->notes->$id = ['id'=>$id, 'note'=>$data['note']];
        $this->save();
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
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
