@extends('layouts.main')

@section('title', 'Index')

@section('header')
    @parent
        <ul class="nav">
            <li><a href="/">Cancel</a></li>
            <li><a href="/" onClick="document.getElementById('add').submit()">Save</a></li>
        </ul>
@endsection

@section('content')
    <form id="add" action="/" method="POST">
        @csrf
        <textarea name="note"></textarea>
    </form>
@endsection