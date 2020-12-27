<?php

namespace App\Http\Controllers;

use App\Models\City;

/**
 * Class CityController
 * @package App\Http\Controllers
 */
class CityController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function index()
    {
        $cities = City::all();
        return view('cities.index', compact('cities'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function create()
    {
        return view('cities.create');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function store()
    {
        City::create($this->validateCity());
        return redirect()->route('cities.index')->with('success', 'Успешно добавен град.');
    }

    /**
     * @param City $city
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function edit(City $city)
    {
        return view('cities.edit', compact('city'));
    }

    /**
     * @param City $city
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function update(City $city)
    {
        $city->update($this->validateCity());
        return redirect()->route('cities.index')->with('success', 'Успешно редактиран град.');
    }

    /**
     * @param City $city
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    protected function destroy(City $city)
    {
        $city->delete();
        return redirect()->back()->with('success', 'Успешно изтрит град.');
    }

    /**
     * @return array
     */
    private function validateCity()
    {
        return request()->validate(['name' => 'required|min:1'], ['name.required' => 'Въведете име.']);
    }

}
