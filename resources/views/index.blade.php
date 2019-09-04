@extends('layouts.main')

@section('title', 'Index')

@section('header')
    @parent
        <ul class="nav">
            <li><a href="/new">Add New</a></li>
        </ul>
@endsection

@section('content')
    @if ($notes)
        <ul class="notes">
        @foreach ($notes as $note)
            <li>
                <a href="/{{ $note->id }}">{{ substr($note->note,0,120) }}@if (strlen($note->note)>120)... @endif</a>
            </li>
        @endforeach
        </ul>
    @else
        <p>No notes available</p>
    @endif
@endsection