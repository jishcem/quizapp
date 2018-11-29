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
                    <div class="card-header">Edit Question</div>

                    <div class="card-body">

                        <form action="{{ route('questions.update', $question->id) }}" method="post">
                            @csrf
                            {{ method_field('PUT') }}
                            <label for="">Title</label>
                            <input value="{{ $question->title }}" type="text" name="title" class="form-control">

                            <br>

                            <label for="">Type</label>
                            <select class="form-control" name="type" id="type">
                                <option value="">Please select</option>
                                <option @if($question->type == 'single-answer') selected @endif value="single-answer">Single Answer</option>
                                <option @if($question->type == 'multiple-answers') selected @endif value="multiple-answers">Multiple Answers</option>
                                <option @if($question->type == 'yes-or-no') selected @endif value="yes-or-no">Yes or No</option>
                                <option @if($question->type == 'descriptive') selected @endif value="descriptive">Descriptive</option>
                            </select>

                            <br>

                            <div class="answer-container">

                            </div>

                            <input type="submit" value="Update">
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

            // Set the old values.
            $('select[name=type]').val('');
            $('select[name=type]').val('{{ $question->type }}');
            $('select[name=type]').trigger('change', '');

            if ( '{{ $question->type  }}' === 'single-answer' ) {
                assignSingleAnswerValues();
            } else if ( '{{ $question->type  }}' === 'multiple-answers' ) {
                assignMultipleAnswersValues();
            } else if ( '{{ $question->type  }}' === 'yes-or-no' ) {
                assignYesOrNoValues();
            }

            function assignSingleAnswerValues() {
               var answers = JSON.parse('{!! $question->answer !!}');
               $('input[type=text][name="answers[]"]').eq(0).val(answers.options[0].text);
               $('input[type=text][name="answers[]"]').eq(1).val(answers.options[1].text);
               $('input[type=text][name="answers[]"]').eq(2).val(answers.options[2].text);
               $('input[type=text][name="answers[]"]').eq(3).val(answers.options[3].text);
               $('#correct-answer1').attr('checked', answers.options[0].correct);
               $('#correct-answer2').attr('checked', answers.options[1].correct);
               $('#correct-answer3').attr('checked', answers.options[2].correct);
               $('#correct-answer4').attr('checked', answers.options[3].correct);
            }

            function assignMultipleAnswersValues() {
                var answers = JSON.parse('{!! $question->answer !!}');
                $('input[type=text][name="answers[]"]').eq(0).val(answers.options[0].text);
                $('input[type=text][name="answers[]"]').eq(1).val(answers.options[1].text);
                $('input[type=text][name="answers[]"]').eq(2).val(answers.options[2].text);
                $('input[type=text][name="answers[]"]').eq(3).val(answers.options[3].text);
                $('#correct-answer1').attr('checked', answers.options[0].correct);
                $('#correct-answer2').attr('checked', answers.options[1].correct);
                $('#correct-answer3').attr('checked', answers.options[2].correct);
                $('#correct-answer4').attr('checked', answers.options[3].correct);
            }

            function assignYesOrNoValues() {
                var answers = JSON.parse('{!! $question->answer !!}');
                $('input[type=text][name="answers[]"]').eq(0).val(answers.options[0].text);
                $('input[type=text][name="answers[]"]').eq(1).val(answers.options[1].text);
                $('#correct-answer1').attr('checked', answers.options[0].correct);
                $('#correct-answer2').attr('checked', answers.options[1].correct);
            }
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
