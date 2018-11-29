@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Category</div>

                <div class="card-body">
                
                    <form action="{{ route('categories.store') }}" method="post">
                        @csrf
                        <label for="">Category</label>
                        <input type="text" name="name" class="form-control">

                        <br>
                        
                        <input type="submit" value="Create">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
