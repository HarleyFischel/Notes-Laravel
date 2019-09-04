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
        return response()->json((new Notes())->all());
    }

    /**
     * Get a Note.
     *
     * @param  int  $id
     * @return json|string
     */
    public function get($id)
    {
        return response()->json((new Notes())->get($id));
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

            return response()->json(['success' => 'Note updated successfully']);
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

        return response()->json(['success'=>'Note added successfully']);
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

        return response()->json(['success'=>'Note deleted successfully']);
    }

    public function token()
    {
        header('Set-Cookie', 'csrftoken='.csrf_token());
        return response()->json(['token'=>csrf_token()]);
    }
}
