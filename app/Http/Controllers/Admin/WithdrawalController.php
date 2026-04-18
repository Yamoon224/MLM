<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use App\Services\WithdrawalService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class WithdrawalController extends Controller
{
    public function __construct(private WithdrawalService $service) {}

    /**
     * Liste toutes les demandes (filtrables par statut).
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'PENDING');

        $withdrawals = WithdrawalRequest::with('user')
            ->when($status !== 'ALL', fn ($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->appends(['status' => $status]);

        $counts = [
            'PENDING'  => WithdrawalRequest::pending()->count(),
            'APPROVED' => WithdrawalRequest::approved()->count(),
            'REJECTED' => WithdrawalRequest::rejected()->count(),
        ];

        return view('admin.withdrawals.index', compact('withdrawals', 'status', 'counts'));
    }

    /**
     * Approuve un retrait.
     */
    public function approve(WithdrawalRequest $withdrawal)
    {
        try {
            $this->service->approve($withdrawal, auth()->id());
            return back()->with('success', __('locale.withdrawal_approved_ok'));
        } catch (\RuntimeException $e) {
            return back()->withErrors(['approve' => $e->getMessage()]);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }
    }

    /**
     * Rejette un retrait avec une note optionnelle.
     */
    public function reject(Request $request, WithdrawalRequest $withdrawal)
    {
        $request->validate([
            'admin_note' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $this->service->reject($withdrawal, auth()->id(), $request->admin_note);
            return back()->with('success', __('locale.withdrawal_rejected_ok'));
        } catch (\RuntimeException $e) {
            return back()->withErrors(['reject' => $e->getMessage()]);
        }
    }
}
