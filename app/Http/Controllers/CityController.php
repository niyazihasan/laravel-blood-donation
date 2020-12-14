<?php

namespace App\Http\Controllers;

use App\Models\City;

class CityController extends Controller
{
    protected function index()
    {
        $cities = City::all();
        return view('cities.index', compact('cities'));
    }

    protected function create()
    {
        return view('cities.create');
    }

    protected function store()
    {
        City::create($this->validateCity());
        return redirect()->route('cities.index')->with('success', 'Успешно добавен град.');
    }

    protected function edit(City $city)
    {
        return view('cities.edit', compact('city'));
    }

    protected function update(City $city)
    {
        $city->update($this->validateCity());
        return redirect()->route('cities.index')->with('success', 'Успешно редактиран град.');
    }

    protected function destroy(City $city)
    {
        $city->delete();
        return redirect()->back()->with('success', 'Успешно изтрит град.');
    }

    private function validateCity()
    {
        return request()->validate(['name' => 'required|min:1'], ['name.required' => 'Въведете име.']);
    }

}
