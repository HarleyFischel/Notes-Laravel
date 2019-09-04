@extends('layouts.main')

@section('title', 'Index')

@section('header')
    @parent
        <ul class="nav">
            <li><a href="/">Back</a></li>
            <li><a class="active" href="/edit/{{ $note->id }}">Edit</a></li>
        </ul>
@endsection

@section('content')
    <pre>{{ $note->note }}</pre>
@endsection