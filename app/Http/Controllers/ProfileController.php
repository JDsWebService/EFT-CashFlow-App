<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function dashboard() {
    	// Define the user
    	$user = Auth::user();
    	// Grab all balance entries from database for user
    	$entries = Balance::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(25)->get();
    	
    	// Define Json Object
    	$balance_array[] = [
    		'Transaction ID',
    		'Current Balance',
    		(object) ['role' => 'style'],
    		(object) ['type' => 'string', 'role' => 'tooltip', 'p' => (object) ['html' => true]]
    	];

    	// Loop Through Entries and grab data
    	foreach($entries as $entry) {
    		$tooltip = "
    			<p class='p-1 m-0'>
					<strong>Transaction ID#:</strong> {$entry->id}
					<br>
					<strong>Balance:</strong> {$entry->balance_current}&#8381;
					<br>
					<strong>Change Amount:</strong> {$entry->balance_change}&#8381;
					<br>
					<strong>Change Percent:</strong> {$entry->change_percent}%
					<br>
					<strong>Created:</strong> {$entry->created_at->diffForHumans()}
				</p>
    		";
    		$entry_array = [$entry->id, $entry->balance_current, $entry->color, $tooltip];
    		array_push($balance_array, $entry_array);
    	}

    	return view('profile.dashboard')->with('balance_json', json_encode($balance_array));
    }
}
