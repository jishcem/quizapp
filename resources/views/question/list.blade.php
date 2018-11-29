@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <a class="btn btn-primary" href="{{ route('questions.create') }}">Create</a>
                <hr>

                <div class="card">
                    <div class="card-header">Questions</div>

                    <div class="card-body">

                        <table class="table">
                            <tr>
                                <td>#</td>
                                <td>Title</td>
                                <td>Edit</td>
                                <td>Delete</td>
                            </tr>
                            @foreach($questions as $question)
                                <tr>
                                    <td>{{ $question->id }}</td>
                                    <td>{{ $question->title }}</td>
                                    <td><a href="{{ route('questions.edit', $question->id) }}">Edit</a></td>
                                    <td><a data-id="{{ $question->id }}" class="delete-item" href="{{ route('questions.destroy', $question->id) }}">Delete</a></td>
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
