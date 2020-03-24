<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mews\Purifier\Facades\Purifier;

class BalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $balance = Auth::user()->balance_total;
        $entries = Balance::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(25);
        return view('profile.balance.index')->withBalance($balance)->withEntries($entries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the Request
        $request->validate([
            'entry' => 'required|integer'
        ]);

        // Purify the Request
        $entry = intval(Purifier::clean($request->entry));
        
        // Grab the User Currently Logged In
        $user = User::where('id', Auth::user()->id)->first();

        // Grab the User's Balance from the User Model
        $user_balance = $user->balance_total;

        // Calculate if the difference
        $difference = abs($user_balance - $entry);

        if($difference == 0) {
            Session::flash('danger', 'Current Balance Is The Same As Entry. Please Update To Current Balance');
            return redirect()->route('profile.balance.index');
        }
        
        // Check if its Neg or Pos Change
        if($user_balance >= $entry) {
            // If Negative
            $current_balance = $user_balance - $difference;
            $difference = 0 - $difference;
            $color = "#aa0000";
        } else {
            // If Positive
            $current_balance = $user_balance + $difference;
            $difference = 0 + $difference;
            $color = "#00aa00";
        }

        // Get The Percentage Change
        $percentage = $this->getPercentageChange($user_balance, $entry);

        // Open New Balance Entry & Update
        $balance = new Balance;
        $balance->user_id = $user->id;
        $balance->balance_current = $entry;
        $balance->balance_change = $difference;
        $balance->color = $color;
        $balance->change_percent = $percentage;
        $balance->save();

        // Update Users Current Balance
        $user->balance_total = $entry;
        $user->save();

        // Return the User to the Balance Index
        return redirect()->route('profile.balance.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entry = Balance::where('id', $id)->first();
        return view('profile.balance.edit')->withEntry($entry);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the Request
        $request->validate([
            'entry' => 'required|integer'
        ]);

        // Define the User
        $user = Auth::user();

        // Grab the Balance Entry Via ID
        $balance = Balance::where('id', $id)->first();
        
        // Grab Previous Entry Before the Edited Entry
        $previous_balance = Balance::where('user_id', $user->id)->orderBy('created_at', 'desc')->where('id', '<=', $id)->skip(1)->take(1)->first()->balance_current;

        // Calculate if the difference
        $difference = abs($previous_balance - intval(Purifier::clean($request->entry)));

        if($difference == 0) {
            Session::flash('danger', 'Previous Balance Is The Same As Entry. Please Update To Current Balance at the time of entry.');
            return redirect()->route('profile.balance.edit', $id);
        }
        
        // Check if its Neg or Pos Change
        if($previous_balance >= $request->entry) {
            // If Negative
            $updated_balance = $previous_balance - $difference;
            $difference = 0 - $difference;
            $color = "#aa0000";
        } else {
            // If Positive
            $updated_balance = $previous_balance + $difference;
            $difference = 0 + $difference;
            $color = "#00aa00";
        }

        // Get The Percentage Change
        $percentage = $this->getPercentageChange($previous_balance, $request->entry);

        // Update the balance
        $balance->balance_current = $request->entry;
        $balance->balance_change = $difference;
        $balance->color = $color;
        $balance->change_percent = $percentage;
        $balance->save();

        // Flash a message and redirect
        Session::flash('success', 'You have edited balance with the ID of ' . $id . ' successfully!');
        return redirect()->route('profile.balance.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Should I Add This?
    }

    // ---------------------
    // Helper Functions
    // ---------------------
    /**
    * Calculates in percent, the change between 2 numbers.
    * e.g from 1000 to 500 = 50%
    * 
    * @param oldNumber The initial value
    * @param newNumber The value that changed
    */
    function getPercentageChange($oldNumber, $newNumber){
        if($oldNumber == 0) {
            return 100;
        }
        $decreaseValue = $oldNumber - $newNumber;
        $percentage = ($decreaseValue / $oldNumber) * 100;
        $percentage = $percentage * -1;
        return $percentage;
    }
}
