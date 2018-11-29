@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="errors-container">
                    @if($errors)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                        <hr>
                    @endif
                </div>

                <div class="card">
                    <div class="card-header">Create Question</div>

                    <div class="card-body">

                        <form action="{{ route('questions.store') }}" method="post">
                            @csrf
                            <label for="">Title</label>
                            <input type="text" name="title" class="form-control">

                            <br>

                            <label for="">Type</label>
                            <select class="form-control" name="type" id="type">
                                <option value="">Please select</option>
                                <option value="single-answer">Single Answer</option>
                                <option value="multiple-answers">Multiple Answers</option>
                                <option value="yes-or-no">Yes or No</option>
                                <option value="descriptive">Descriptive</option>
                            </select>

                            <br>

                            <div class="answer-container">

                            </div>

                            <input type="submit" value="Create">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).on('ready', function(){
            $('select[name=type]').on('change', function(){
                console.log(this.value);
                if ( this.value == 'single-answer' ) {
                    $('.answer-container').html(document.getElementById('single-answer-template').innerText);
                } else if ( this.value == 'multiple-answers' ) {
                    $('.answer-container').html(document.getElementById('multiple-answers-template').innerText);
                } else if ( this.value == 'yes-or-no' ) {
                    $('.answer-container').html(document.getElementById('yes-or-no-template').innerText);
                } else if ( this.value == 'descriptive' ) {
                    $('.answer-container').html(document.getElementById('descriptive-template').innerText);
                }
            });

            // Form Submit
            $('form').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    method: "POST",
                    url: this.getAttribute('action'),
                    data: $(this).serialize()
                }).done(function(response){
                    if ( response.status ) {
                        location.href = '{{ route('questions.index') }}';
                    }
                }).error(function(errors){
                    console.log(errors);
                });
            });
        });
    </script>

    <script id="single-answer-template" type="text/template">
        <label for="">Answer 1</label>
        <input type="text" name="answers[]" class="form-control">
        <br>
        <label for="">Answer 2</label>
        <input type="text" name="answers[]" class="form-control">
        <br>
        <label for="">Answer 3</label>
        <input type="text" name="answers[]" class="form-control">
        <br>
        <label for="">Answer 4</label>
        <input type="text" name="answers[]" class="form-control">
        <br>

        <hr>
        Correct Answer
        <div class="form-check">
            <input class="form-check-input" type="radio" name="correct-answer" id="correct-answer1" value="1">
            <label class="form-check-label" for="correct-answer1">
                Answer 1
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="correct-answer" id="correct-answer2" value="2">
            <label class="form-check-label" for="correct-answer2">
                Answer 2
            </label>
        </div>
        <div class="form-check disabled">
            <input class="form-check-input" type="radio" name="correct-answer" id="correct-answer3" value="3">
            <label class="form-check-label" for="correct-answer3">
                Answer 3
            </label>
        </div>
        <div class="form-check disabled">
            <input class="form-check-input" type="radio" name="correct-answer" id="correct-answer4" value="4">
            <label class="form-check-label" for="correct-answer4">
                Answer 4
            </label>
        </div>
        <hr>
    </script>
    <script id="multiple-answers-template" type="text/template">
        <label for="">Answer 1</label>
        <input type="text" name="answers[]" class="form-control">
        <br>
        <label for="">Answer 2</label>
        <input type="text" name="answers[]" class="form-control">
        <br>
        <label for="">Answer 3</label>
        <input type="text" name="answers[]" class="form-control">
        <br>
        <label for="">Answer 4</label>
        <input type="text" name="answers[]" class="form-control">
        <br>

        <hr>
        Correct Answer
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="correct-answer0" id="correct-answer1" value="1">
            <label class="form-check-label" for="correct-answer1">
                Answer 1
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="correct-answer1" id="correct-answer2" value="2">
            <label class="form-check-label" for="correct-answer2">
                Answer 2
            </label>
        </div>
        <div class="form-check disabled">
            <input class="form-check-input" type="checkbox" name="correct-answer2" id="correct-answer3" value="3">
            <label class="form-check-label" for="correct-answer3">
                Answer 3
            </label>
        </div>
        <div class="form-check disabled">
            <input class="form-check-input" type="checkbox" name="correct-answer3" id="correct-answer4" value="4">
            <label class="form-check-label" for="correct-answer4">
                Answer 4
            </label>
        </div>
        <hr>
    </script>
    <script id="yes-or-no-template" type="text/template">
        <label for="">Answer 1</label>
        <input type="text" name="answers[]" class="form-control">
        <br>
        <label for="">Answer 2</label>
        <input type="text" name="answers[]" class="form-control">
        <br>

        <hr>
        Correct Answer
        <div class="form-check">
            <input class="form-check-input" type="radio" name="correct-answer" id="correct-answer1" value="1">
            <label class="form-check-label" for="correct-answer1">
                Answer 1
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="correct-answer" id="correct-answer2" value="2">
            <label class="form-check-label" for="correct-answer2">
                Answer 2
            </label>
        </div>
        <hr>
    </script>
    <script id="descriptive-template" type="text/template">
        <label for="">Answer</label>
        <input type="text" name="answers" class="form-control">
        <hr>
    </script>
@endsection
