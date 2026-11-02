<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function showDashboard(): View
    {
        $startOfMonth = now()->startOfMonth();
        $startOfYear = now()->startOfYear();
        $endOfYear = now()->endOfYear();
        $yearlyContracts = Contract::query()
            ->whereBetween('created_at', [$startOfYear, $endOfYear])
            ->get(['created_at']);

        $monthlyInquiryTotals = $yearlyContracts
            ->countBy(fn (Contract $contract): string => $contract->created_at->format('n'));

        return view('Admin.dashboard', [
            'totalUsers' => User::query()->count(),
            'newUsersThisMonth' => User::query()->where('created_at', '>=', $startOfMonth)->count(),
            'totalInquiries' => Contract::query()->count(),
            'newInquiriesThisMonth' => Contract::query()->where('created_at', '>=', $startOfMonth)->count(),
            'recentUsers' => User::query()->latest()->limit(5)->get(['name', 'email', 'created_at']),
            'recentContracts' => Contract::query()->latest()->limit(5)->get(['name', 'email', 'subject', 'created_at']),
            'monthlyInquiryTotals' => collect(range(1, 12))
                ->map(fn (int $month): int => $monthlyInquiryTotals->get((string) $month, 0))
                ->values()
                ->all(),
        ]);
    }
}
