@extends('layout')


@section('content')
    <table>
        <tr>
            <th>id</th>
            <th>name</th>
        </tr>

        @forelse ($positions as $position)
            <tr>
                <td>{{ $position->id }}</td>
                <td>{{ $position->name }}</td>
            </tr>
        @empty
            <p>No positions</p>
        @endforelse
    </table>

@endsection
