@extends('layouts.app')

@section('title', 'Your Balance')

@section('content')

	<div class="row">
		<div class="col-sm-6">
			<p>Only enter your balance as it sits right now. We will automatically calculate the balance total, and update the balance accordingly.</p>
			<p>
				Valid entries are <strong>Always Positive</strong>.
			</p>
		</div>
		<div class="col-sm-6">
			Current Balance: <strong>{{ $balance }}</strong> &#8381;
			{{ Form::open(['route' => 'profile.balance.store', 'class' => 'mt-3']) }}
				{{ Form::number('entry', null, ['class' => 'form-control', 'placeholder' => 'Updated Balance', 'required', 'autofocus'])}}
				<button type="submit" class="btn btn-block btn-success mt-3">Update Your Balance</button>
			{{ Form::close() }}
		</div>
	</div>

	<div class="row justify-content-center mt-3">
		<div class="col-sm-8">
			<table class="table table-sm table-dark table-striped table-hover" class="w-100">
				<thead>
					<th>Entry ID #</th>
					<th>Balance Update</th>
					<th>Balance Change</th>
					<th>Updated At</th>
					<th></th>
				</thead>
				<tbody>
					@foreach($entries as $entry)
						<tr>
							<td>{{ $entry->id }}</td>
							<td>{{ $entry->balance_current }} &#8381;</td>
							@if($entry->balance_change > 0)
								<td><span class="text-success">{{ $entry->balance_change }}</span> &#8381;</td>
							@else
								<td><span class="text-danger">{{ $entry->balance_change }}</span> &#8381;</td>
							@endif
							<td>{{ $entry->created_at->diffForHumans() }}</td>
							<td>
								<a href="{{ route('profile.balance.edit', $entry->id) }}" class="btn btn-sm btn-info">
									<i class="far fa-edit"></i>
								</a>
								<a href="#" class="btn btn-sm btn-danger">
									<i class="far fa-trash-alt"></i>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<nav class="pagination mt-3">
				{{ $entries->links() }}
			</nav>
		</div>
	</div>

@endsection