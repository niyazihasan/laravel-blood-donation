<?php

namespace App\Http\Controllers;

use App\Models\{Donation, Hospital, User};
use App\Http\Requests\PatientForm;

class PatientController extends Controller
{
    protected function index()
    {
        $patients = User::where('role', User::ROLE_PATIENT)
            ->whereColumn('current_blood', '<', 'blood_quantity')
            ->with(['hospital:id,name,city_id', 'hospital.city:id,name'])
            ->select(['id', 'name', 'surname', 'fathersname', 'egn', 'blood_type', 'blood_quantity', 'current_blood', 'hospital_id'])
            ->latest()
            ->get();
        return view('patients.index', compact('patients'));
    }

    protected function indexHospital()
    {
        $hospital = auth()->user()->hospital;
        return view('patients.index_hospital', compact('hospital'));
    }

    protected function create()
    {
        $user = auth()->user();
        if (null === $user->egn or $user->name === null or $user->surname === null or $user->fathersname === null) {
            return redirect()->route('profile')->with('success', 'За да може да добавите пациент трябва да попълните данните си.');
        }
        $hospitals = Hospital::pluck('name', 'id');
        return view('patients.create', compact('hospitals'));
    }

    protected function store(PatientForm $form)
    {
        $form['added_by'] = auth()->id();
        $form['role'] = User::ROLE_PATIENT;
        $form['hospital_id'] = auth()->user()->hospital->id;
        User::create($form->all());
        return redirect()->route('patients.index.hospital')->with('success', 'Успешно добавихте нуждаещ от кръв.');
    }

    protected function edit(User $user)
    {
        $donations = Donation::where([
            'flag' => Donation::CHECKED,
            'hiv_spin' => Donation::RESULT_NEGATIVE,
            'syphilis' => Donation::RESULT_NEGATIVE,
            'hepatitis_b' => Donation::RESULT_NEGATIVE,
            'hepatitis_c' => Donation::RESULT_NEGATIVE
        ])
            ->with(['patient:id,egn,name,surname,fathersname', 'donor:id,blood_type,egn,name,surname,fathersname'])
            ->select(['id', 'patient_id', 'donor_id'])
            ->latest()
            ->get();
        return view('patients.edit', compact('user', 'donations'));
    }

    protected function update(User $user, PatientForm $form)
    {
        $user_ = auth()->user();
        if ($user_->role === User::ROLE_ADMIN) {
            if (request('donors')) {
                foreach (request('donors') as $id) {
                    $donation = Donation::findOrFail($id);
                    $count = $user->current_blood + 1;
                    if ($count <= $user->blood_quantity) {
                        $user->update(['current_blood' => $count]);
                        $donation->update(['patient_id' => $user->id, 'flag' => Donation::USED]);
                    }
                }
            }
            unset($form['donors']);
        }
        $user->update($form->all());
        return redirect()->back()->with('success', 'Успешно редактиран пациент.');
    }

}
