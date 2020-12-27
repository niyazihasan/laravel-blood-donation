<?php

namespace App\Http\Controllers;

use App\Models\{Donation, User};
use App\Http\Requests\ResultForm;

/**
 * Class DonationController
 * @package App\Http\Controllers
 */
class DonationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    protected function indexDoctor()
    {
        $user = auth()->user();
        if (null === $user->egn or $user->name === null or $user->surname === null or $user->fathersname === null) {
            return redirect()->route('profile')->with('success', 'За да може да проверите декларации трябва да попълните данните си.');
        }
        $waitingDeclarations = Donation::where('flag', null)
            ->with('donor')
            ->get();
        $declarations = Donation::where('flag', Donation::CHECKED)
            ->with(['donor', 'doctor'])
            ->get();
        return view('donations.index_doctor', compact('waitingDeclarations', 'declarations'));
    }

    /**
     * @param Donation $donation
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function showDoctor(Donation $donation)
    {
        return view('donations.show_doctor', compact('donation'));
    }

    /**
     * @param Donation $donation
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function updateDoctor(Donation $donation)
    {
        $this->validate(request(),
            ['blood_type' => 'required', 'description' => 'required'],
            ['blood_type.required' => 'Изберете кръвна група.', 'description.required' => 'Напишете вашите наблюдения.']
        );
        $donation->donor->update(['blood_type' => request('blood_type')]);
        $donation->update([
            'description' => request('description'),
            'doctor_id' => auth()->id(), 'flag' => Donation::CHECKED,
            'declaration_date' => date("Y-m-d H:i:s")
        ]);
        return redirect()->route('declarations.index.doctor')->with('success', 'Успешно одобрихте декларация на донор.');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    protected function indexLaborant()
    {
        $user = auth()->user();
        if (null === $user->egn or $user->name === null or $user->surname === null or $user->fathersname === null) {
            return redirect()->route('profile')->with('success', 'За да може да проверите декларации трябва да попълните данните си.');
        }
        $waitingDonations = Donation::where([
            'flag' => Donation::CHECKED,
            'hiv_spin' => null, 'syphilis' => null,
            'hepatitis_b' => null, 'hepatitis_c' => null
        ])
            ->with('donor')
            ->get();
        $donations = Donation::where([
            ['hepatitis_b', '!=', null], ['hepatitis_c', '!=', null],
            ['syphilis', '!=', null], ['hiv_spin', '!=', null]
        ])
            ->with('donor')
            ->get();
        return view('donations.index_laborant', compact('waitingDonations', 'donations'));
    }

    /**
     * @param Donation $donation
     * @param ResultForm $form
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateLaborant(Donation $donation, ResultForm $form)
    {
        $donation->update([
            'hiv_spin' => $form['hiv_spin'][$donation->id],
            'hepatitis_b' => $form['hepatitis_b'][$donation->id],
            'hepatitis_c' => $form['hepatitis_c'][$donation->id],
            'syphilis' => $form['syphilis'][$donation->id],
            'laborant_id' => auth()->id(),
            'result_date' => date("Y-m-d H:i:s")
        ]);
        return redirect()->back()->with('success', 'Успешно добавихте резултати.');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function quantityBlood()
    {
        $availableBlood = User::select('blood_type')
            ->join('donations', 'donations.donor_id', '=', 'users.id')
            ->where([
                'flag' => Donation::CHECKED,
                'hiv_spin' => Donation::RESULT_NEGATIVE,
                'syphilis' => Donation::RESULT_NEGATIVE,
                'hepatitis_b' => Donation::RESULT_NEGATIVE,
                'hepatitis_c' => Donation::RESULT_NEGATIVE
            ])
            ->selectRaw('COUNT(blood_type) as total')
            ->groupBy('blood_type')
            ->get()
            ->keyBy('blood_type')
            ->toArray();

        $needBlood = User::select('blood_type')
            ->where('role', User::ROLE_PATIENT)
            ->whereColumn('blood_quantity', '>=', 'current_blood')
            ->selectRaw('SUM(blood_quantity - current_blood) as total')
            ->groupBy('blood_type')
            ->get()
            ->keyBy('blood_type')
            ->toArray();

        $usedBlood = User::select('blood_type')
            ->join('donations', 'donations.donor_id', '=', 'users.id')
            ->where([
                'flag' => Donation::USED,
                'hiv_spin' => Donation::RESULT_NEGATIVE,
                'syphilis' => Donation::RESULT_NEGATIVE,
                'hepatitis_b' => Donation::RESULT_NEGATIVE,
                'hepatitis_c' => Donation::RESULT_NEGATIVE
            ])
            ->selectRaw('COUNT(blood_type) as total')
            ->groupBy('blood_type')
            ->get()
            ->keyBy('blood_type')
            ->toArray();

        $data = [];
        $user = new User();
        $bloodTypes = $user->bloodTypes;
        unset($bloodTypes[null]);

        foreach ($bloodTypes as $key => $blood) {
            $totalAvailable = $totalNeed = $totalUsed = 0;
            if (array_key_exists($key, $availableBlood)) {
                $totalAvailable = $availableBlood[$key]['total'];
            }
            if (array_key_exists($key, $needBlood)) {
                $totalNeed = (int)$needBlood[$key]['total'];
            }
            if (array_key_exists($key, $usedBlood)) {
                $totalUsed = $usedBlood[$key]['total'];
            }
            $data[] = [
                $blood, $totalAvailable, $totalAvailable,
                $totalNeed, $totalNeed, $totalUsed, $totalUsed
            ];
        }
        return view('donations.quantity_blood', compact('data'));
    }

    /**
     * @param Donation $donation
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    protected function destroy(Donation $donation)
    {
        $donation->donorDeclaration->answers()->delete();
        $donation->donorDeclaration->delete();
        $donation->delete();
        return redirect()->back()->with('success', 'Успешно изтрита декларация.');
    }

}
