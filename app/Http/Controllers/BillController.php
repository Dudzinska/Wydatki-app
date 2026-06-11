<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Group;
use App\Services\BillSplitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BillController extends Controller
{
    public function __construct(private readonly BillSplitService $billSplitService)
    {
    }

    public function store(Request $request, Group $group)
    {
        $this->authorizeGroupAccess($group);

        $validated = $request->validate([
            'description' => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (preg_match('/^\d+$/', trim((string) $value))) {
                        $fail('Nazwa wydatku nie moze skladac sie z samych cyfr.');
                    }
                },
            ],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payer_id' => [
                'required',
                Rule::exists('group_user', 'user_id')->where('group_id', $group->id),
            ],
        ], [
            'description.required' => 'Podaj nazwe wydatku. Bez nazwy wydatek nie zostanie zapisany.',
            'amount.required' => 'Podaj kwote wydatku.',
            'amount.numeric' => 'Kwota musi byc liczba.',
            'amount.min' => 'Kwota musi byc dodatnia. Nie mozna wpisac kwoty ujemnej ani zera.',
            'payer_id.required' => 'Wybierz platnika.',
            'payer_id.exists' => 'Platnik musi byc czlonkiem tej grupy.',
        ]);

        DB::transaction(function () use ($group, $validated): void {
            $bill = $group->bills()->create([
                'description' => $validated['description'],
                'amount' => $validated['amount'],
                'payer_id' => $validated['payer_id'],
                'date' => now(),
            ]);

            $this->billSplitService->createInitialPayerSplit($bill, $group, (int) $validated['payer_id']);

            if (DB::getDriverName() !== 'mysql') {
                $group->increment('total_amount', $validated['amount']);
            }
        });

        return back()->with('success', 'Wydatek dodany!');
    }

    public function destroy(Group $group, Bill $bill)
    {
        $this->authorizeGroupAccess($group);
        abort_unless($bill->group_id === $group->id, 404);

        $amount = $bill->amount;
        $bill->delete();

        if (DB::getDriverName() !== 'mysql') {
            $group->decrement('total_amount', $amount);
        }

        return back()->with('success', 'Rachunek usuniety.');
    }

    private function authorizeGroupAccess(Group $group): void
    {
        if (!auth()->user()->isAdmin() && !$group->users->contains(Auth::id())) {
            abort(403, 'Brak dostepu.');
        }
    }
}
