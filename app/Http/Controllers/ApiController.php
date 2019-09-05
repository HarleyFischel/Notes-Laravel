<?php

namespace App\Http\Controllers;

use App\Notes;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * List Notes.
     *
     * @return json|string
     */
    public function index()
    {
        return response()->json((new Notes())->all(), 200,
            ['Access-Control-Allow-Origin'=>'*']);
    }

    /**
     * Get a Note.
     *
     * @param  int  $id
     * @return json|string
     */
    public function get($id)
    {
        return response()->json((new Notes())->get($id), 200,
            ['Access-Control-Allow-Origin'=>'*']);
    }

    /**
     * Update Note.
     *
     * @param  Request $request
     * @return json
     */
    public function update(Request $request)
    {
        if ($request->input('id')!='') {
            (new Notes)->update([
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
     * @param  Request $request
     * @return json
     */
    public function insert(Request $request)
    {
        (new Notes)->add([
            'note'=>$request->input('note')
        ]);

        return response()->json(['success'=>'Note added successfully'], 200,
            ['Access-Control-Allow-Origin'=>'*']);
    }

    /**
     * Delete Note.
     *
     * @param  $id
     * @return json
     */
    public function delete($id)
    {
        (new Notes)->delete($id);

        return response()->json(['success'=>'Note deleted successfully'], 200,
            ['Access-Control-Allow-Origin'=>'*']);
    }

    public function token()
    {
        return response()->json(['token'=>csrf_token()], 200,
            ['Access-Control-Allow-Origin'=>'*']);
    }
}
