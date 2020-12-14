<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StepOneForm, StepTwoForm};
use App\Models\{Answer, Declaration, Donation, DonorDeclaration, Hospital};

class AnswerController extends Controller
{
    protected function stepOne()
    {
        $user = auth()->user();
        if ($user->age < 18) {
            return back()->with('success', 'За да може да дарите кръв трябва да имате навършени 18 години.');
        }
        if (session()->get('answers')) {
            return redirect()->route('answers.step.two');
        }
        if (null === $user->egn or $user->name === null or $user->surname === null or $user->fathersname === null) {
            return redirect()->route('profile')->with('success', 'За да може да дарите кръв трябва да попълните данните си.');
        }
        $userDeclaration = Donation::where(['donor_id' => $user->id, 'flag' => null])->get();
        if (count($userDeclaration)) {
            return redirect()->back()->with('success', 'Вече сте попълнили декларация.');
        }
        $declaration = Declaration::where('active', Declaration::ACTIVE)->first();
        if (null === $declaration) {
            return redirect()->back()->with('success', 'В момента не може да дарите кръв, опитайте по-късно.');
        }
        return view('answers.step_one', compact('declaration'));
    }

    protected function stepTwo()
    {
        return null !== session()->get('answers') ? view('answers.step_two') : redirect()->back()->with('success', 'Не сте минали първа стъпка.');
    }

    protected function storeOne(StepOneForm $form)
    {
        session()->put('answers', $form['answer']);
        return redirect()->route('answers.step.two');
    }

    protected function storeTwo(StepTwoForm $form)
    {
        $declaration = Declaration::where('active', Declaration::ACTIVE)->first();
        $donorDeclaration = DonorDeclaration::create([
            'user_id' => auth()->id(),
            'declaration_id' => $declaration->id
        ]);
        foreach (session()->get('answers') as $key => $value) {
            Answer::create([
                'donor_declaration_id' => $donorDeclaration->id,
                'question_id' => $key, 'name' => $value
            ]);
        }
        Donation::create([
            'donor_id' => auth()->id(),
            'patient_id' => $form['search'],
            'donor_declaration_id' => $donorDeclaration->id
        ]);
        session()->forget('answers');
        return redirect()->route('results')->with('success', 'Успешно попълнихте анкетата за кръводаряване.');
    }

    // Return all patients for step two
    protected function autoload()
    {
        $data = [];
        $hospitals = Hospital::with('patients')->get();
        foreach ($hospitals as $hospital) {
            $data[] = [
                'hospital' => $hospital->name,
                'people' => $hospital->patients
            ];
        }
        return response()->json($data);
    }

}
