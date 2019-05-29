@extends($route.'.tabForm')
@section ('section-title', "My logged records")
@section ('tab-active-logs', 'active')
@section ('tab-css')

@endsection

@section ('tab-js')
<script type="text/javascript">
	function search(){
		d_from 	= $('#from').val();
		d_till 	= $('#till').val();
		limit 	= $('#limit').val();

		url="?limit="+limit;
		if(isDate(d_from)){
			if(isDate(d_till)){
				url+='&from='+d_from+'&till='+d_till;
			}
		}
		
		$(location).attr('href', '{{ route($route.'.logs', $id) }}'+url);
	}
</script>

@endsection

@section ('tab-content')
	
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<div id="from-cnt" class='input-group date'>
					<input id="from" type='text' class="form-control" value="{{ isset($appends['from'])?$appends['from']:'' }}" placeholder="From" />
				<span class="input-group-addon">
					<i class="font-icon font-icon-calend"></i>
				</span>
				</div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="form-group">
				<div id="till-cnt" class='input-group date' >
					<input id="till" type='text' class="form-control" value="{{ isset($appends['till'])?$appends['till']:''  }}" placeholder="Till" />
					<span class="input-group-addon">
						<i class="font-icon font-icon-calend"></i>
					</span>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<button onclick="search()"  class="tabledit-delete-button btn btn-sm btn-primary" style="float: none;"><span class="fa fa-search"></span></button>
		</div>
	</div><!--.row-->
				
		
	<div class="table-responsive">
		<table id="table-edit" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Date & Time</th>
					<th>Operation System</th>
					<th>Broswer</th>
					<th>Version</th>
					<th>IP Address</th>
				</tr>
			</thead>
			<tbody>

				@php ($i = 1)
				@foreach ($data as $row)
					<tr>
						<td>{{ $i++ }}</td>
						<td>{{ $row->created_at }}</td>
						<td>{{ $row->os }}</td>
						<td>{{ $row->broswer }}</td>
						<td>{{ $row->version }}</td>
						<td>{{ $row->ip }}</td>
					</tr>
				
				@endforeach
				
				
			</tbody>
		</table>

	</div >
	
	<div class="row">
		<div class="col-xs-1" style="padding-right: 0px;">
			<select id="limit" class="form-control" style="margin-top: 15px;width:100%">
				@if(isset($appends['limit']))
				<option>{{ $appends['limit'] }}</option>
				@endif
				<option>10</option>
				<option>20</option>
				<option>30</option>
				<option>40</option>
				<option>50</option>
				<option>60</option>
				<option>70</option>
				<option>80</option>
				<option>90</option>
				<option>100</option>
			</select>
		</div>
		
		<div class="col-xs-11">
			{{ $data->appends($appends)->links('vendor.pagination.custom-html') }}
		</div>
	</div>
		

@endsection