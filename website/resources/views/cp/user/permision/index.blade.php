@extends($route.'.main')
@section ('section-title', 'Permision')
@section ('display-btn-back', 'display:none')
@section ('section-css')



@section ('section-content')
	
	<div class="table-responsive">
		<table id="table-edit" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>N. of Permisions</th>
					<th></th>
				</tr>
			</thead>
			<tbody>

				@php ($i = 1)
				@foreach ($data as $row)
					<tr>
						<td>{{ $i++ }}</td>
						<td>{{ $row->title }}</td>
						<td>{{ count($row->permisions) }}</td>
						<td style="white-space: nowrap; width: 1%;">
							<div class="tabledit-toolbar btn-toolbar" style="text-align: left;">
	                           	<div class="btn-group btn-group-sm" style="float: none;">
	                           		<a href="{{ route($route.'.permisions', $row->id) }}" class="tabledit-edit-button btn btn-sm btn-success" style="float: none;"><span class="fa fa-eye"></span></a>
	                           	</div>
	                       </div>
	                    </td>
					</tr>
				
				@endforeach
				
				
			</tbody>
		</table>
	</div >

@endsection