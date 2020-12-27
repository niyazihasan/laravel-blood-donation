<?php

namespace App\Http\Controllers;

use App\Http\Requests\{ProfileForm, UserForm};
use App\Models\{City, Donation, Hospital, User};

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function index()
    {
        if (request('role')) {
            $users = User::select(['id', 'email', 'role', 'active'])
                ->where('role', request('role'))
                ->get();
        } else {
            $users = User::select(['id', 'email', 'role', 'active'])
                ->whereIn('role', [
                    User::ROLE_USER, User::ROLE_ADMIN,
                    User::ROLE_DOCTOR, User::ROLE_LABORANT,
                    User::ROLE_SUPERDOCTOR
                ])
                ->get();
        }
        $user = new User();
        $roles = $user->roles;
        $role = request()->input('role');
        return view('users.index', compact('users', 'roles', 'role'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function create()
    {
        $hospitals = Hospital::pluck('name', 'id');
        return view('users.create', compact('hospitals'));
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function edit(User $user)
    {
        $hospitals = Hospital::pluck('name', 'id');
        return view('users.edit', compact('user', 'hospitals'));
    }

    /**
     * @param User $user
     * @param UserForm $form
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function update(User $user, UserForm $form)
    {
        if ($form['password'] === null) {
            unset($form['password']);
        }
        $user->update($form->all());
        return redirect()->route('users.index')->with('success', 'Успешно редактиран потребител.');
    }

    /**
     * @param UserForm $form
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function store(UserForm $form)
    {
        $form['added_by'] = auth()->id();
        User::create($form->all());
        return redirect()->route('users.index')->with('success', 'Успешно добавен потребител.');
    }

    /**
     * @param User $user
     * @param ProfileForm $form
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateProfile(User $user, ProfileForm $form)
    {
        if ($form['password'] === null) {
            unset($form['password']);
        }
        $user->update($form->all());
        return back()->with('success', 'Успешно редактирахте данните си.');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function profile()
    {
        $user = auth()->user();
        $cities = City::pluck('name', 'id');
        return view('users.profile', compact('user', 'cities'));
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    protected function destroy(User $user)
    {
        if ($user->role === User::ROLE_PATIENT) {
            $messsage = 'Успешно изтрит пациент.';
        } else {
            $messsage = 'Успешно изтрит потребител.';
        }
        $user->delete();
        return redirect()->back()->with('success', $messsage);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function results()
    {
        $donations = Donation::where('donor_id', auth()->id())
            ->with(['patient:id,name,fathersname,surname,egn', 'laborant:id,name,fathersname,surname'])
            ->select(['result_date', 'hepatitis_b', 'hepatitis_c', 'hiv_spin', 'syphilis', 'patient_id', 'laborant_id'])
            ->get();
        return view('users.results', compact('donations'));
    }

}
