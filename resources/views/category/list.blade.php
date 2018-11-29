@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <a class="btn btn-primary" href="{{ route('categories.create') }}">Create</a>
            <hr>

            <div class="card">
                <div class="card-header">Categories</div>                

                <div class="card-body">
                
                    <table class="table">
                        <tr>
                            <td>#</td>
                            <td>Name</td>
                            <td>Edit</td>
                            <td>Delete</td>
                        </tr>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td><a href="{{ route('categories.edit', $category->id) }}">Edit</a></td>
                            <td><a data-id="{{ $category->id }}" class="delete-item" href="{{ route('categories.destroy', $category->id) }}">Delete</a></td>
                        </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(document).on('ready', function(){
            $(".delete-item").on('click', function(e){
                e.preventDefault();
                var consent = confirm('Are you sure you want to delete this item');
                if (! consent ) {
                    return;
                }

                $.ajax({
                    method: "POST",
                    url: this.getAttribute('href'),
                    data: {
                        id: $(this).data('id'),
                        _method: "DELETE",
                        _token: '{{csrf_token()}}'
                    }
                }).done(function(response){
                    location.reload();
                });
            });
        });
    </script>
@endsection
