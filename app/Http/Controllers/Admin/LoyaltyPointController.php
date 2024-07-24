<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Model\PointTransitions;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;


class LoyaltyPointController extends Controller
{
    public function __construct(private PointTransitions $private_transaction)
    {
    }

    /**
     * @param Request $request
     * @return Renderable
     */
    public function report(Request $request): Renderable
    {
        $from = date('Y-m-d', strtotime($request->from));
        $to = date('Y-m-d', strtotime($request->to));

        // $from_to = $from . ' 00:00:00', $to . ' 23:59:59';

      
        $data = $this->private_transaction
            ->selectRaw('sum(credit) as total_credit, sum(debit) as total_debit')
            ->when(($from && $to), function ($query) use ($request) {
                $query->whereBetween('created_at', [date('Y-m-d', strtotime($request->from)) . ' 00:00:00', date('Y-m-d', strtotime($request->to)) . ' 23:59:59']);
            })
            ->when($request->transaction_type, function ($query) use ($request) {
                $query->where('type', $request->transaction_type);
            })
            ->when($request->customer_id, function ($query) use ($request) {
                $query->where('user_id', $request->customer_id);
            })
            ->get();

        $transactions = $this->private_transaction->with(['customer'])
            ->when(($from && $to), function ($query) use ($request) {
                $query->whereBetween('created_at', [date('Y-m-d', strtotime($request->from)) . ' 00:00:00', date('Y-m-d', strtotime($request->to)) . ' 23:59:59']);
            })
            ->when($request->transaction_type, function ($query) use ($request) {
                $query->where('type', $request->transaction_type);
            })
            ->when($request->customer_id, function ($query) use ($request) {
                $query->where('user_id', $request->customer_id);
            })
            ->latest()
            ->get();
           // ->paginate(Helpers::getPagination());

        return view('admin-views.customer.loyalty-point.report', compact('data', 'transactions'));
    }
}
