<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Group;
use Illuminate\Support\Collection;

class BillSplitService
{
    public function createInitialEqualSplit(Bill $bill, Group $group, int $payerId): void
    {
        $memberIds = $group->users()->pluck('users.id')->values();
        if ($memberIds->isEmpty()) {
            return;
        }

        $shares = $this->distributeEvenly($this->toCents((float) $bill->amount), $memberIds);

        $this->persistSplits($bill, $shares, $payerId);
    }

    public function recalculateFromItems(Bill $bill, Group $group, int $payerId): bool
    {
        $bill->loadMissing('items');

        if ($bill->items->isEmpty()) {
            return false;
        }

        $groupUserIds = $group->users()->pluck('users.id')->values();
        if ($groupUserIds->isEmpty()) {
            return false;
        }

        $rawShares = $groupUserIds->mapWithKeys(fn (int $userId): array => [$userId => 0]);
        $itemsTotalCents = 0;

        foreach ($bill->items as $item) {
            $itemTotalCents = $this->toCents((float) $item->price * (int) $item->quantity);
            if ($itemTotalCents <= 0) {
                continue;
            }

            $itemsTotalCents += $itemTotalCents;
            $distributed = $this->distributeEvenly($itemTotalCents, $groupUserIds);

            foreach ($distributed as $userId => $shareCents) {
                $rawShares[$userId] += $shareCents;
            }
        }

        if ($itemsTotalCents <= 0) {
            return false;
        }

        $billTotalCents = $this->toCents((float) $bill->amount);
        if ($itemsTotalCents < $billTotalCents) {
            $missingCents = $billTotalCents - $itemsTotalCents;
            $missingShares = $this->distributeEvenly($missingCents, $groupUserIds);

            foreach ($missingShares as $userId => $shareCents) {
                $rawShares[$userId] += $shareCents;
            }

            $finalShares = $rawShares;
        } elseif ($itemsTotalCents === $billTotalCents) {
            $finalShares = $rawShares;
        } else {
            $finalShares = $this->normalizeToTotal($rawShares, $billTotalCents, $itemsTotalCents, $groupUserIds);
        }

        $this->persistSplits($bill, $finalShares, $payerId);

        return true;
    }

    private function persistSplits(Bill $bill, Collection $shares, int $payerId): void
    {
        $bill->splits()->delete();

        $bill->splits()->createMany(
            $shares->map(function (int $shareCents, int $userId) use ($payerId): array {
                return [
                    'user_id' => $userId,
                    'amount' => $this->fromCents($shareCents),
                    'is_paid' => $userId === $payerId,
                ];
            })->values()->all()
        );
    }

    private function distributeEvenly(int $totalCents, Collection $userIds): Collection
    {
        $count = $userIds->count();
        if ($count === 0 || $totalCents <= 0) {
            return $userIds->mapWithKeys(fn (int $userId): array => [$userId => 0]);
        }

        $baseShare = intdiv($totalCents, $count);
        $remainder = $totalCents % $count;

        return $userIds->values()->mapWithKeys(
            fn (int $userId, int $index): array => [$userId => $baseShare + ($index < $remainder ? 1 : 0)]
        );
    }

    private function normalizeToTotal(Collection $rawShares, int $targetTotalCents, int $rawTotalCents, Collection $fallbackUsers): Collection
    {
        if ($rawTotalCents <= 0) {
            return $this->distributeEvenly($targetTotalCents, $fallbackUsers);
        }

        $normalized = collect();
        $remainders = collect();
        $distributed = 0;

        foreach ($rawShares as $userId => $rawShareCents) {
            $scaled = $rawShareCents * $targetTotalCents;
            $base = intdiv($scaled, $rawTotalCents);
            $remainder = $scaled % $rawTotalCents;

            $normalized->put($userId, $base);
            $remainders->put($userId, $remainder);
            $distributed += $base;
        }

        $missing = max(0, $targetTotalCents - $distributed);

        if ($missing > 0) {
            $remainders
                ->sortDesc()
                ->keys()
                ->take($missing)
                ->each(function (int $userId) use ($normalized): void {
                    $normalized[$userId] += 1;
                });
        }

        return $normalized;
    }

    private function toCents(float $value): int
    {
        return (int) round($value * 100);
    }

    private function fromCents(int $value): float
    {
        return round($value / 100, 2);
    }
}
