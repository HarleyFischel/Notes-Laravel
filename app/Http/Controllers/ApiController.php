<?php

namespace App\Http\Controllers;

use App\Notes;
use Illuminate\Http\Request;

/**
 * Class ApiController
 *
 * @package App\Http\Controllers
 */
class ApiController extends Controller
{
    /**
     * List Notes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json((new Notes())->all(), 200,
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
        return response()->json((new Notes())->get($id), 200,
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
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
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
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        (new Notes)->delete($id);

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
