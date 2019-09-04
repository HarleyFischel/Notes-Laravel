<?php

namespace App\Http\Controllers;

use App\Notes;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    /**
     * List Notes.
     *
     * @return View
     */
    public function index()
    {
        return view('index', ['notes' => (new Notes())->all()]);
    }

    /**
     * Add New Note.
     *
     * @return View
     */
    public function add()
    {
        return view('add');
    }

    /**
     * Edit a Note.
     *
     * @param  int  $id
     * @return View
     */
    public function edit($id)
    {
        return view('edit', ['note' => (new Notes())->get($id)]);
    }

    /**
     * Save Note.
     *
     * @param  Request  $request
     * @return Response
     */
    public function save(Request $request)
    {
        if ($request->input('id')!='') {
            (new Notes)->update([
                'id'=>$request->input('id'),
                'note'=>$request->input('note')
            ]);
            return redirect('/'.$request->input('id'));
        } else {
            (new Notes)->add([
                'note'=>$request->input('note')
            ]);
        }
        //return response()->view('index', ['msg'=>'success'], 200);
        return redirect('/'); //->action('NotesController@index'); //->route('index');
    }

    /**
     * Save Note.
     *
     * @param  Request  $request
     * @return Response
     */
    public function delete($id)
    {
        (new Notes)->delete($id);
        return redirect('/');
    }

    /**
     * View a Note.
     *
     * @param  int  $id
     * @return View
     */
    public function view($id)
    {
        return view('view', ['note' => (new Notes())->get($id)]);
    }
}
