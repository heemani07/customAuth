@extends('layout.app')

@section('content')
<head>


</head>
<div class="container">
    <h1> User Manager</h1>


    @if ($users->count())
        <table class="table table-bordered" id="myDataTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>


                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No tasks available.</p>
    @endif
</div>





@endsection
