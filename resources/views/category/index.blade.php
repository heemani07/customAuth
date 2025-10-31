<x-master title="Category Management">
    <x-top-bar/>
<head>


</head>

<div class="container">
 <x-page-header title="Category Management" route="{{ route('categories.create')}}"  buttonValue="Category"/>
    @if ($categories->count())
        <table class="table table-bordered" id="myDataTable">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->category_name }}</td>
                    <td>{{ $category->description }}</td>

                    <td>
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
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
        <p>No Categories available.</p>
    @endif
</div>

</x-master>



