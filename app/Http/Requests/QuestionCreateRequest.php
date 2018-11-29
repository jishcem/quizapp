<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class QuestionCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'=> 'required'
        ];
    }

    public function withValidator(Validator $validator) {
        $validator->after(function(Validator $validator) {
            if ( $this->request->get('type') == 'single-answer' ) {
                if (!
                (
                    array_has($this->request->get('answers'), '0') &&
                    array_get($this->request->get('answers'), '0') &&
                    array_has($this->request->get('answers'), '1') &&
                    array_get($this->request->get('answers'), '1') &&
                    array_has($this->request->get('answers'), '2') &&
                    array_get($this->request->get('answers'), '2') &&
                    array_has($this->request->get('answers'), '3') &&
                    array_get($this->request->get('answers'), '3')
                )
                ) {
                    $validator->errors()->add('type', 'For single answer, all the 4 answers must be
                     filled in');
                }
                if (! $this->request->get('correct-answer') ) {
                    $validator->errors()->add('correct-answer', 'There should at least be one correct
                    answer selected');
                }
            }
            if ( $this->request->get('type') == 'multiple-answers' ) {
                if (!
                (
                    array_has($this->request->get('answers'), '0') &&
                    array_get($this->request->get('answers'), '0') &&
                    array_has($this->request->get('answers'), '1') &&
                    array_get($this->request->get('answers'), '1') &&
                    array_has($this->request->get('answers'), '2') &&
                    array_get($this->request->get('answers'), '2') &&
                    array_has($this->request->get('answers'), '3') &&
                    array_get($this->request->get('answers'), '3')
                )
                ) {
                    $validator->errors()->add('type', 'For multiple answers, all the 4 answers must be
                     filled in');
                }
                if (
                    ! (
                        $this->request->get('correct-answer0') ||
                        $this->request->get('correct-answer1') ||
                        $this->request->get('correct-answer2') ||
                        $this->request->get('correct-answer3')
                    )
                ) {
                    $validator->errors()->add('correct-answer', 'There should at least be one correct
                    answer selected');
                }
            }
            if ( $this->request->get('type') == 'yes-or-no' ) {
                if (!
                (
                    array_has($this->request->get('answers'), '0') &&
                    array_get($this->request->get('answers'), '0') &&
                    array_has($this->request->get('answers'), '1') &&
                    array_get($this->request->get('answers'), '1')
                )
                ) {
                    $validator->errors()->add('type', 'For single answer, all the 2 answers must be
                     filled in');
                }
                if (! $this->request->get('correct-answer') ) {
                    $validator->errors()->add('correct-answer', 'There should at least be one correct
                    answer selected');
                }
            }
            if ( $this->request->get('type') == 'descriptive' ) {
                if (! $this->request->get('answers') ) {
                    $validator->errors()->add('correct-answer', 'Correct answer should be provided');
                }
            }
        });
    }
}
