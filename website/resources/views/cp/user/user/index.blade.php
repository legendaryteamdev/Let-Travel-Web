@extends($route.'.main')
@section ('section-title', 'All Users')
@section ('display-btn-add-new', 'display:none')
@section ('section-css')

@endsection
@section ('section-js')
	<script type="text/javascript">
		$(document).ready(function() {
			
		});

	    function changePassword(id) {
	     	swal({
						title: "Reset Password",
						text: "",
						type: "input",
						showCancelButton: true,
						closeOnConfirm: false,
						inputPlaceholder: "Please type a new Password:"
					}, function (inputValue) {
						if (inputValue === false) return false;
						if (inputValue.length <6 ){
	                        toastr.error("Your password at least 6 digits long!");
							return false
						}
						$.ajax({
						        url: "{{ route($route.'.update-password') }}",
						        type: 'POST',
						        data: {id:id, password:inputValue },
						        success: function( response ) {
						            if ( response.status === 'success' ) {
						            	swal("Nice!", response.msg ,"success");
						            }else{
						            	swal("Error!", "Sorry there is an error happens. " ,"error");
						            }
						        },
						        error: function( response ) {
						           swal("Error!", "Sorry there is an error happens. " ,"error");
						        }
						
					});
	            })
	    }

	    function updateStatus(id){
         	thestatus = $('#status-'+id);
         	status = thestatus.attr('data-value');

         	if(status == 1){
         		status = 0;
         		thestatus.attr('data-value', 1);
         	}else{
         		status = 1;
         		thestatus.attr('data-value', 0);
         	}

         	$.ajax({
		        url: "{{ route($route.'.update-status') }}",
		        method: 'POST',
		        data: {id:id, status:status },
		        success: function( response ) {
		            if ( response.status === 'success' ) {
		            	swal("Nice!", response.msg ,"success");
		            	
		            }else{
		            	swal("Error!", "Sorry there is an error happens. " ,"error");
		            }
		        },
		        error: function( response ) {
		           swal("Error!", "Sorry there is an error happens. " ,"error");
		        }
			});

    	}

    	

    	function updateValidateIP(id){
         	thestatus = $('#validate-ip-'+id);
         	active = thestatus.attr('data-value');

         	if(active == 1){
         		active = 0;
         		thestatus.attr('data-value', 1);
         	}else{
         		active = 1;
         		thestatus.attr('data-value', 0);
         	}

         	$.ajax({
		        url: "{{ route($route.'.update-valid-ip') }}",
		        method: 'POST',
		        data: {id:id, active:active },
		        success: function( response ) {
		            if ( response.status === 'success' ) {
		            	swal("Nice!", response.msg ,"success");
		            	
		            }else{
		            	swal("Error!", "Sorry there is an error happens. " ,"error");
		            }
		        },
		        error: function( response ) {
		           swal("Error!", "Sorry there is an error happens. " ,"error");
		        }
			});

    	}
    
	</script>
@endsection

@section ('section-content')
	
<div class="table-responsive">
	<table id="table-edit" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Position</th>
				<th>Status</th>
				<th>Validate IP</th>
				<th>Last Updated</th>
				<th>Image</th>
				<th></th>
			</tr>
		</thead>
		<tbody>

			@php ($i = 1)
			@foreach ($data as $row)
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{ $row->en_name }}</td>
					<td>{{ $row->position->name }}</td>
					<td>
						<div class="checkbox-toggle">
					        <input onclick="updateStatus({{ $row->id }})" type="checkbox" id="status-{{ $row->id }}" @if ($row->status == 1) checked data-value="1" @else data-value="0" @endif >
					        <label @if($row->position_id == 2) for="status-{{ $row->id }}" @endif></label>
				        </div>
					</td>
					<td>
						<div class="checkbox-toggle">
					        <input onclick="updateValidateIP({{ $row->id }})" type="checkbox" id="validate-ip-{{ $row->id }}" @if ($row->is_ip_validated == 1) checked data-value="1" @else data-value="0" @endif >
					        <label @if($row->position_id == 2)  for="validate-ip-{{ $row->id }}" @endif></label>
				        </div>
					</td>
					<td>{{ $row->updated_at }}</td>
					<td class="table-photo">
						<img src="{{ asset ($row->picture) }}" alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $row->name }}">
					</td>
					<td style="white-space: nowrap; width: 1%;">
						<div class="tabledit-toolbar btn-toolbar" style="text-align: left;">
                           	<div class="btn-group btn-group-sm" style="float: none;">
                           		<a href="{{ route($route.'.edit', $row->id) }}" class="tabledit-edit-button btn btn-sm btn-success" style="float: none;"><span class="fa fa-eye"></span></a>
                           		<a href="#" onclick="changePassword({{ $row->id }})" class="tabledit-edit-button btn btn-sm btn-warning" style="float: none;"><span class="fa fa-key"></span></a>
                           		<a href="#" onclick="deleteConfirm('{{ route($route.'.trash', $row->id) }}', '{{ route($route.'.index') }}')" class="tabledit-delete-button btn btn-sm btn-danger" style="float: none;"><span class="glyphicon glyphicon-trash"></span></a>
                           	</div>
                       </div>
                    </td>
				</tr>
			
			@endforeach
			
			
		</tbody>
	</table>
</div >
Note: <br />
- If Status is marked with blue color, User can are active on the system else he/she cannot access.<br />
- If Agent is marked with blue color, User can be visible on website.<br />
- If Validate IP is marked with blue color, User cannot log to the system with other internet beside company. However, User having position as andmin is still able.<br />


@endsection