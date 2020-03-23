@if (app()->environment('local'))
	<link href="https://fonts.googleapis.com/css?family=Rokkitt" rel="stylesheet">

	<style type="text/css">
		#who-component {
			font-family: "Rokkitt";
			font-size: 1.05em;
			color: white;
			background: black;
			width: 100%;
		}
		/* Logged Out Color */
		#who-component .logged-out {
			color: rgba(255, 0, 0, 0.9);
		}
		/* Logged In Color */
		#who-component .logged-in {
			color: rgba(0, 255, 0, 0.9);
		}
	</style>

	<div id="who-component" class="text-center">
		{{-- User --}}
		<span class="user-type">user: </span>
		@guest
		<span class="logged-out">logged out</span>
		@else
		<span class="logged-in">logged in</span>
		@endguest
		 | 
		{{-- Admin --}}
		<span class="user-type">admin: </span>
		<span class="logged-out">logged out</span>
	</div>
@endif