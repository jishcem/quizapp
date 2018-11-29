@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Category</div>

                <div class="card-body">
                
                    <form action="{{ route('categories.update', $category->id) }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}
                        <label for="">Category</label>
                        <input type="text" name="name" value="{{ $category->name }}" class="form-control">

                        <br>
                        
                        <input type="submit" value="Update">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
