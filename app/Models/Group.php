<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'owner_id', 'total_amount'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function getBalances(): array
    {
        return $this->getBalanceCollection()->all();
    }

    public function getSettlementPlan(): array
    {
        $balances = $this->getBalanceCollection();

        $creditors = $balances
            ->filter(fn (array $entry): bool => $entry['balance'] > 0.01)
            ->map(fn (array $entry): array => [
                'user' => $entry['user'],
                'amount_cents' => (int) round($entry['balance'] * 100),
            ])
            ->sortByDesc('amount_cents')
            ->values()
            ->all();

        $debtors = $balances
            ->filter(fn (array $entry): bool => $entry['balance'] < -0.01)
            ->map(fn (array $entry): array => [
                'user' => $entry['user'],
                'amount_cents' => (int) round(abs($entry['balance']) * 100),
            ])
            ->sortByDesc('amount_cents')
            ->values()
            ->all();

        $settlements = [];
        $creditorIndex = 0;
        $debtorIndex = 0;

        while (isset($creditors[$creditorIndex], $debtors[$debtorIndex])) {
            $transferCents = min(
                $creditors[$creditorIndex]['amount_cents'],
                $debtors[$debtorIndex]['amount_cents']
            );

            if ($transferCents <= 0) {
                break;
            }

            $settlements[] = [
                'from' => $debtors[$debtorIndex]['user'],
                'to' => $creditors[$creditorIndex]['user'],
                'amount' => round($transferCents / 100, 2),
            ];

            $creditors[$creditorIndex]['amount_cents'] -= $transferCents;
            $debtors[$debtorIndex]['amount_cents'] -= $transferCents;

            if ($creditors[$creditorIndex]['amount_cents'] === 0) {
                $creditorIndex++;
            }

            if ($debtors[$debtorIndex]['amount_cents'] === 0) {
                $debtorIndex++;
            }
        }

        return $settlements;
    }

    private function getBalanceCollection(): Collection
    {
        $members = $this->users()->get();
        if ($members->isEmpty()) {
            return collect();
        }

        $bills = $this->bills()->get(['id', 'payer_id', 'amount']);
        $billIds = $bills->pluck('id');

        $paidByUser = $bills
            ->groupBy('payer_id')
            ->map(fn (Collection $userBills): float => (float) $userBills->sum('amount'));

        $owedByUser = $billIds->isEmpty()
            ? collect()
            : BillSplit::query()
                ->selectRaw('user_id, SUM(amount) as owed')
                ->whereIn('bill_id', $billIds)
                ->groupBy('user_id')
                ->pluck('owed', 'user_id')
                ->map(fn ($amount): float => (float) $amount);

        return $members->map(function (User $user) use ($paidByUser, $owedByUser): array {
            $paid = (float) ($paidByUser[$user->id] ?? 0);
            $owed = (float) ($owedByUser[$user->id] ?? 0);

            return [
                'user' => $user,
                'paid' => $paid,
                'owed' => $owed,
                'balance' => round($paid - $owed, 2),
            ];
        });
    }
}
