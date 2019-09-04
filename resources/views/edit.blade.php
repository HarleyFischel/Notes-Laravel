@extends('layouts.main')

@section('title', 'Index')

@section('header')
    @parent
        <ul class="nav">
            <li><a class="active" href="/{{ $note->id }}">Cancel</a></li>
            <li><a href="/delete/{{ $note->id }}">Delete</a></li>
            <li><a href="javascript:void(0)" onClick="document.getElementById('edit').submit()">Save</a></li>
        </ul>
@endsection

@section('content')
    <form id="edit" action="/" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $note->id }}">
        <textarea name="note">{{ $note->note }}</textarea>
    </form>
@endsection