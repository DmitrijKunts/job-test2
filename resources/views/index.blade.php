@extends('layout')


@section('content')
    <a href="{{ route('positions') }}">positions</a> |
    <a href="{{ route('create') }}">Create user</a> |
    <table>
        <tr>
            <th>name</th>
            <th>email</th>
            <th>phone</th>
            <th>position</th>
            <th>photo</th>
        </tr>

        @forelse ($users as $user)
            <tr>
                <td><a href="{{ route('view', $user->id) }}">{{ $user->name }}</a></td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->position }}</td>
                <td><img src="{{ $user->photo }}" alt=""></td>
            </tr>
        @empty
            <p>No users</p>
        @endforelse
    </table>

    @if ($prev_url)
        <a href="{{ $prev_url }}">Назад</a>
    @endif
    @if ($next_url)
        <a href="{{ $next_url }}">Вперед</a>
    @endif
@endsection
