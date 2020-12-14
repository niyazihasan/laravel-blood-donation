<?php

namespace App\Http\Controllers;

use App\Models\Declaration;

class DeclarationController extends Controller
{
    protected function index()
    {
        $declarations = Declaration::withCount('questions')->latest()->get();
        return view('declarations.index', compact('declarations'));
    }

    protected function create()
    {
        return view('declarations/create');
    }

    protected function store()
    {
        Declaration::create($this->validateDeclaration());
        return redirect()->route('declarations.index')->with('success', 'Успешно добавена декларация.');
    }

    protected function show(Declaration $declaration)
    {
        return view('declarations.show', compact('declaration'));
    }

    protected function edit(Declaration $declaration)
    {
        return view('declarations.edit', compact('declaration'));
    }

    protected function update(Declaration $declaration)
    {
        $declaration->update($this->validateDeclaration());
        return redirect()->route('declarations.index')->with('success', 'Успешно редактирана декларация.');
    }

    protected function destroy(Declaration $declaration)
    {
        $message = 'Декларация с въпроси не може да бъде изтрита.';
        if ($declaration->questions->isEmpty()) {
            $declaration->delete();
            $message = 'Успешно изтрита декларация.';
        }
        return redirect()->back()->with('success', $message);
    }

    private function validateDeclaration()
    {
        return request()->validate(
            ['name' => 'required|min:1|max:255'],
            ['name.required' => 'Въведете име.']
        );
    }

    protected function updateActivity(Declaration $declaration)
    {
        $form = request()->all();
        $message = '';
        if (array_key_exists('active', $form) and in_array($form['active'], Declaration::ACTIVES)) {
            $active = (int)$form['active'];
            if ($active !== $declaration->active) {
                $error = false;
                $message = 'Успешно активирахте декларация.';
                if (Declaration::ACTIVE === $active) {
                    if (count(Declaration::where('active', Declaration::ACTIVE)->get())) {
                        $error = true;
                        $message = 'Има активна декларация.';
                    } else if (!$declaration->questions->count()) {
                        $error = true;
                        $message = 'Декларацията не съдържа въпроси.';
                    }
                } else if (Declaration::INACTIVE === $active) {
                    $message = 'Успешно деактивирахте декларация.';
                }
                if (false === $error) {
                    $declaration->update(['active' => $active]);
                }
            }
        }
        return back()->with('success', $message);
    }

}
