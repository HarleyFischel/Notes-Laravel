<?php

namespace App\Http\Controllers;

use App\Notes;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    private $notes;

    public function __construct(Notes $notes)
    {
        $this->notes = $notes;
    }

    /**
     * List Notes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->notes->all(), 200,
            ['Access-Control-Allow-Origin'=>'*']);
    }

    /**
     * Get a Note.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(int $id)
    {
        return response()->json($this->notes->get($id), 200,
            ['Access-Control-Allow-Origin'=>'*']);
    }

    /**
     * Update Note.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        if ($request->input('id')!='') {
            $this->notes->update([
                'id'   => $request->input('id'),
                'note' => $request->input('note')
            ]);

            return response()->json(['success' => 'Note updated successfully'], 200,
                ['Access-Control-Allow-Origin'=>'*']);
        }
    }

    /**
     * Insert Note.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function insert(Request $request)
    {
        $this->notes->add([
            'note'=>$request->input('note')
        ]);

        return response()->json(['success'=>'Note added successfully'], 200,
            ['Access-Control-Allow-Origin'=>'*']);
    }

    /**
     * Delete Note.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $this->notes->delete($id);

        return response()->json(['success'=>'Note deleted successfully'], 200,
            ['Access-Control-Allow-Origin'=>'*']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function token()
    {
        return response()->json(['token'=>csrf_token()], 200,
            ['Access-Control-Allow-Origin'=>'*']);
    }
}
