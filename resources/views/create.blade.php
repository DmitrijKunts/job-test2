@extends('layout')


@section('content')
    <form method="POST" action="{{ route('store') }}"  enctype="multipart/form-data">
        @csrf

        name: <input type="text" name="name"><br>
        email: <input type="email" name="email"><br>
        phone: <input type="text" name="phone"><br>
        position_id: <input type="text" name="position_id"><br>
        photo: <input type="file" name="photo"><br>
        <button type="submit">submit</button>
    </form>
@endsection
