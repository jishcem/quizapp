<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionCreateRequest;
use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();
        return view('question.list', ['questions' => $questions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('question.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionCreateRequest $request)
    {
        $question = new Question();
        $question->type = $request->get('type');
        $question->title = $request->get('title');
        $question->answer = json_encode($this->getAnswer($request->get('type'), $request));
        $question->save();
        return response()->json(['status' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);
        return view('question.edit', ['question' => $question]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $question = Question::find($id);
        $question->type = $request->get('type');
        $question->title = $request->get('title');
        $question->answer = json_encode($this->getAnswer($request->get('type'), $request));
        $question->save();
        return response()->json(['status' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id);
        $question->delete();
        return response()->json(['deleted' => true]);
    }

    private function getAnswer($type, Request $request)
    {
        if ( $type == 'single-answer' ) {
            return $this->getAnswerForSingleAnswer($request);
        } else if ( $type == 'multiple-answers' ) {
            return $this->getAnswerForMultipleAnswers($request);
        } else if ( $type == 'yes-or-no' ) {
            return $this->getAnswerForYesOrNo($request);
        } else if ( $type == 'descriptive' ) {
            return false;
        }
    }

    private function getAnswerForSingleAnswer(Request $request) {
        $answer = [];
        $answer['options'] = $request->get('answers');
        foreach ($answer['options'] as $key => $option) {
            if ( $request->get('correct-answer') == ($key + 1) ) {
                $answer['options'][$key] = [
                    'text' => $option,
                    'correct' => true
                ];
            } else {
                $answer['options'][$key] = [
                    'text' => $option,
                    'correct' => false
                ];
            }
        }
        return $answer;
    }

    private function getAnswerForMultipleAnswers(Request $request) {
        $answer = [];
        $answer['options'] = $request->get('answers');
        foreach ($answer['options'] as $key => $option) {
            if ( $request->get('correct-answer'.$key) ) {
                $answer['options'][$key] = [
                    'text' => $option,
                    'correct' => true
                ];
            } else {
                $answer['options'][$key] = [
                    'text' => $option,
                    'correct' => false
                ];
            }
        }
        return $answer;
    }

    private function getAnswerForYesOrNo(Request $request) {
        $answer = [];
        $answer['options'] = [];
        $answer['options'][] = [
            'text' => $request->get('answers')[0],
            'correct' => $request->get('correct-answer') == 1
        ];
        $answer['options'][] = [
            'text' => $request->get('answers')[1],
            'correct' => $request->get('correct-answer') == 2
        ];
        return $answer;
    }
}
