<?php

namespace App\Http\Controllers;

use App\Models\{Hospital, City};

class HospitalController extends Controller
{
    protected function index()
    {
        $hospitals = Hospital::with('city:id,name')->get();
        return view('hospitals.index', compact('hospitals'));
    }

    protected function create()
    {
        $cities = City::pluck('name', 'id');
        return view('hospitals.create', compact('cities'));
    }

    protected function store()
    {
        Hospital::create($this->validateHospital());
        return redirect()->route('hospitals.index')->with('success', 'Успешно добавена болница.');
    }

    protected function show(Hospital $hospital)
    {
        return view('hospitals.show', compact('hospital'));
    }

    protected function edit(Hospital $hospital)
    {
        $cities = City::pluck('name', 'id');
        return view('hospitals.edit', compact('cities', 'hospital'));
    }

    protected function update(Hospital $hospital)
    {
        $hospital->update($this->validateHospital());
        return redirect()->route('hospitals.index')->with('success', 'Успешно редактирана болница.');
    }

    protected function destroy(Hospital $hospital)
    {
        $hospital->delete();
        return redirect()->back()->with('success', 'Успешно изтрита болница.');
    }

    private function validateHospital()
    {
        return request()->validate(
            ['name' => 'required|min:1', 'city_id' => 'required'],
            ['name.required' => 'Въведете име.', 'city_id.required' => 'Моля изберете град.']
        );
    }

}
