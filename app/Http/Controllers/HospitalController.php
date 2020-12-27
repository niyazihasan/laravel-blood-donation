<?php

namespace App\Http\Controllers;

use App\Models\{Hospital, City};

/**
 * Class HospitalController
 * @package App\Http\Controllers
 */
class HospitalController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function index()
    {
        $hospitals = Hospital::with('city:id,name')->get();
        return view('hospitals.index', compact('hospitals'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function create()
    {
        $cities = City::pluck('name', 'id');
        return view('hospitals.create', compact('cities'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function store()
    {
        Hospital::create($this->validateHospital());
        return redirect()->route('hospitals.index')->with('success', 'Успешно добавена болница.');
    }

    /**
     * @param Hospital $hospital
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function show(Hospital $hospital)
    {
        return view('hospitals.show', compact('hospital'));
    }

    /**
     * @param Hospital $hospital
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function edit(Hospital $hospital)
    {
        $cities = City::pluck('name', 'id');
        return view('hospitals.edit', compact('cities', 'hospital'));
    }

    /**
     * @param Hospital $hospital
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function update(Hospital $hospital)
    {
        $hospital->update($this->validateHospital());
        return redirect()->route('hospitals.index')->with('success', 'Успешно редактирана болница.');
    }

    /**
     * @param Hospital $hospital
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    protected function destroy(Hospital $hospital)
    {
        $hospital->delete();
        return redirect()->back()->with('success', 'Успешно изтрита болница.');
    }

    /**
     * @return array
     */
    private function validateHospital()
    {
        return request()->validate(
            ['name' => 'required|min:1', 'city_id' => 'required'],
            ['name.required' => 'Въведете име.', 'city_id.required' => 'Моля изберете град.']
        );
    }

}
