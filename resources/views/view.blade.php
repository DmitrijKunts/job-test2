@extends('layout')


@section('content')
    {{ $user->id }}<br>
    {{ $user->name }}<br>
    {{ $user->email }}<br>
    {{ $user->phone }}<br>
    {{ $user->position }}<br>
    <img src="{{ $user->photo }}" alt=""><br>
@endsection
