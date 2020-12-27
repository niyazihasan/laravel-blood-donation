<?php

namespace App\Http\Controllers;

use App\Models\{Declaration, Question};

/**
 * Class QuestionController
 * @package App\Http\Controllers
 */
class QuestionController extends Controller
{
    /**
     * @param Declaration $declaration
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function store(Declaration $declaration)
    {
        $declaration->addQuestion(new Question($this->validateQuestion()));
        return redirect()->back()->with('success', 'Успешно добавен въпрос.');
    }

    /**
     * @param Question $question
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
    }

    /**
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function update(Question $question)
    {
        $question->update($this->validateQuestion());
        return redirect()->route('declarations.show', $question->declaration_id)
            ->with('success', 'Успешно редактиран въпрос.');
    }

    /**
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    protected function destroy(Question $question)
    {
        $message = 'Въпроса не може да бъде изтрит.';
        if ($question->answers->isEmpty()) {
            $question->delete();
            $message = 'Успешно изтрит въпрос.';
        }
        return redirect()->back()->with('success', $message);
    }

    /**
     * @return array
     */
    private function validateQuestion()
    {
        return request()->validate(
            ['name' => 'required|min:1', 'type' => 'required'],
            ['name.required' => 'Въведете въпрос.', 'type.required' => 'Изберете тип.']
        );
    }
}
