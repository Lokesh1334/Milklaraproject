<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MilkEntry;
use App\Models\Member;
use Carbon\Carbon;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\DB; 

class MilkController extends Controller
{
    public function index()
{
    // Detailed milk entries
    $detailedMilkEntries = MilkEntry::all(); // Or any filter you need

    // Aggregate total quantity and total amount per member
    $aggregatedMilkEntries = DB::table('milk_entries')
        ->select('member_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(quantity * price_per_liter) as total_amount'))
        ->groupBy('member_id')
        ->get();

    // Fetch member details for each entry
    $memberIds = $aggregatedMilkEntries->pluck('member_id')->unique();
    $members = Member::whereIn('id', $memberIds)->get()->keyBy('id');

    // Calculate total number of unique dates
    $totalDates = MilkEntry::select(DB::raw('COUNT(DISTINCT date) as total_dates'))->pluck('total_dates')->first();

    return view('milk_entries.index', [
        'detailedMilkEntries' => $detailedMilkEntries,
        'aggregatedMilkEntries' => $aggregatedMilkEntries,
        'members' => $members,
        'totalDates' => $totalDates
    ]);
}

    
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'quantity' => 'required|numeric',
            'price_per_liter' => 'required|numeric',
        ]);

        MilkEntry::create([
            'member_id' => $request->member_id,
            'quantity' => $request->quantity,
            'date' => Carbon::now(),
            'price_per_liter' => $request->price_per_liter,
        ]);

        $this->sendSms($request->member_id);

        return redirect()->back()->with('success', 'Milk entry recorded!');
    }

    private function sendSms($memberId)
    {
        $member = Member::find($memberId);

        if (!$member) {
            \Log::error("Member with ID {$memberId} not found.");
            return;
        }

        $entries = MilkEntry::where('member_id', $memberId)
                            ->whereDate('date', Carbon::now()->toDateString())
                            ->get();

        $totalQuantity = $entries->sum('quantity');
        $totalAmount = $entries->sum(function ($entry) {
            return $entry->quantity * $entry->price_per_liter;
        });

        // Fetch credentials from environment
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $twilio = new Client($sid, $token);

        try {
            $twilio->messages->create(
                $member->mobile_number,
                [
                    'from' => env('TWILIO_PHONE_NUMBER'),
                    'body' => "Today's milk entry: {$totalQuantity} liters. Total amount due: ₹{$totalAmount}."
                ]
            );
        } catch (\Exception $e) {
            \Log::error('Twilio error: ' . $e->getMessage());
        }
    }

    public function testSms()
    {
        $memberId = 1; // Replace with a valid member ID
        $this->sendSms($memberId);
        return 'Test SMS sent!';
    }
}
