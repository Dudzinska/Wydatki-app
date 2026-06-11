<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class PublicGroupController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'min_total' => ['nullable', 'numeric', 'min:0'],
            'min_members' => ['nullable', 'integer', 'min:1'],
            'sort' => ['nullable', 'in:newest,oldest,name_asc,name_desc,total_desc,members_desc'],
        ]);

        $groups = Group::query()
            ->with('owner:id,name')
            ->withCount(['users', 'bills'])
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('description', 'like', '%'.$search.'%');
                });
            })
            ->when($filters['min_total'] ?? null, function ($query, float $minTotal) {
                $query->where('total_amount', '>=', $minTotal);
            })
            ->when($filters['min_members'] ?? null, function ($query, int $minMembers) {
                $query->has('users', '>=', $minMembers);
            });

        $sort = $filters['sort'] ?? 'newest';
        match ($sort) {
            'oldest' => $groups->orderBy('created_at'),
            'name_asc' => $groups->orderBy('name'),
            'name_desc' => $groups->orderByDesc('name'),
            'total_desc' => $groups->orderByDesc('total_amount'),
            'members_desc' => $groups->orderByDesc('users_count'),
            default => $groups->orderByDesc('created_at'),
        };

        return view('public.groups.index', [
            'groups' => $groups->paginate(9)->withQueryString(),
            'filters' => $filters,
        ]);
    }

    public function show(Group $group)
    {
        $group->load([
            'owner:id,name',
            'users:id,name',
            'bills' => fn ($query) => $query
                ->with('payer:id,name')
                ->latest('date')
                ->latest('id')
                ->limit(8),
        ]);

        return view('public.groups.show', [
            'group' => $group,
            'balances' => $group->getBalances(),
            'settlementPlan' => $group->getSettlementPlan(),
        ]);
    }
}
