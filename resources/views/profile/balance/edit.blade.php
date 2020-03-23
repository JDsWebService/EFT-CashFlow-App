@extends('layouts.app')

@section('title', 'Edit Balance Entry')

@section('content')

	<div class="row">
		<div class="col-sm-6">
			<h3>Uh-oh!</h3>
			<p>Hey, everyone messes up, we get it. No problem! We got your back! Just update this entry by entering the correct balance at the time of entry.</p>
		</div>
		<div class="col-sm-6">
			<p>
				Balance Value To Edit: <strong>{{ $entry->balance_current }}</strong> &#8381;
			</p>

			{{ Form::model($entry, ['route' => ['profile.balance.update', $entry->id], 'class' => 'mt-3', 'method' => 'PUT']) }}
				{{ Form::number('entry', $entry->balance_current, ['class' => 'form-control', 'placeholder' => 'New Balance', 'required', 'autofocus'])}}
				<button type="submit" class="btn btn-block btn-success mt-3">Save Changes To Entry</button>
			{{ Form::close() }}
		</div>
	</div>

@endsection