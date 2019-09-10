<?php

namespace App\Http\Controllers;

use App\Notes;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    private $notes;

    public function __construct(Notes $notes)
    {
        $this->notes = $notes;
    }

    /**
     * List Notes.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('index', ['notes' => $this->notes->all()]);
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
        return view('edit', ['note' => $this->notes->get($id)]);
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
            $this->notes->update([
                'id'=>$request->input('id'),
                'note'=>$request->input('note')
            ]);
            return redirect('/'.$request->input('id'));
        } else {
            $this->notes->add([
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
        $this->notes->delete($id);
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
        return view('view', ['note' => $this->notes->get($id)]);
    }
}
