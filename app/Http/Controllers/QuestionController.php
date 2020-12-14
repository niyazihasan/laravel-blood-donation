<?php

namespace App\Http\Controllers;

use App\Models\{Declaration, Question};

class QuestionController extends Controller
{
    protected function store(Declaration $declaration)
    {
        $declaration->addQuestion(new Question($this->validateQuestion()));
        return redirect()->back()->with('success', 'Успешно добавен въпрос.');
    }

    protected function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
    }

    protected function update(Question $question)
    {
        $question->update($this->validateQuestion());
        return redirect()->route('declarations.show', $question->declaration_id)
            ->with('success', 'Успешно редактиран въпрос.');
    }

    protected function destroy(Question $question)
    {
        $message = 'Въпроса не може да бъде изтрит.';
        if ($question->answers->isEmpty()) {
            $question->delete();
            $message = 'Успешно изтрит въпрос.';
        }
        return redirect()->back()->with('success', $message);
    }

    private function validateQuestion()
    {
        return request()->validate(
            ['name' => 'required|min:1', 'type' => 'required'],
            ['name.required' => 'Въведете въпрос.', 'type.required' => 'Изберете тип.']
        );
    }
}
