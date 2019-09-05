<?php

namespace App\Http\Controllers;

use App\Notes;
use Illuminate\Http\Request;

/**
 * Class NotesController
 *
 * @package App\Http\Controllers
 */
class NotesController extends Controller
{
    /**
     * List Notes.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('index', ['notes' => (new Notes())->all()]);
    }

    /**
     * Add New Note.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('add');
    }

    /**
     * Edit a Note.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        return view('edit', ['note' => (new Notes())->get($id)]);
    }

    /**
     * Save Note.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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
        return redirect('/');
    }

    /**
     * Delete Note.
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        (new Notes)->delete($id);
        return redirect('/');
    }

    /**
     * View a Note.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(int $id)
    {
        return view('view', ['note' => (new Notes())->get($id)]);
    }
}
