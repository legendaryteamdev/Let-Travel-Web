@extends($route.'.tabForm')
@section ('section-title', 'Account Information')
@section ('tab-active-password', 'active')
@section ('tab-css')
	
@endsection

@section ('tab-js')
	<script type="text/JavaScript">
		$(document).ready(function(event){
		
			$('#form').validate({
				modules : 'file',
				submit: {
					settings: {
						inputContainer: '.form-group',
						errorListClass: 'form-tooltip-error'
					}
				}
			}); 
			$('#form').submit(function(event){
				event.prevenDefault();
				alert('This is form submit.');
			})

		}); 
	</script>
@endsection

@section ('tab-content')
	@if (count($errors) > 0)
	    <div class="form-error-text-block">
	        <h2 style="color:red"> Error Occurs</h2>
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif
	<form id="form" action="{{ route($route.'.update-password') }}" name="form" method="POST"  enctype="multipart/form-data">
		{{ csrf_field() }}
		{{ method_field('POST') }}
		<input type="hidden" name="id" value="{{ $data->id }}">
		<div class="form-group row">
			<label class="col-sm-4 form-control-label" for="name">Current Password</label>
			<div class="col-sm-8">
				<input 	id="old_password"
						name="old_password"
					   	value = ""
					   	type="password"
					   	placeholder = ""
					   	class="form-control"
					   	data-validation="[L>=6, L<=18]"
						data-validation-message="$ must be between 6 and 18 characters." />
						
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-4 form-control-label" for="new_password">New Password</label>
			<div class="col-sm-8">
				<input 	id="new_password"
						name="new_password"
					   	value = ""
					   	type="password"
					   	placeholder = ""
					   	class="form-control"
					   	data-validation="[L>=6, L<=18]"
						data-validation-message="$ must be between 6 and 18 characters." />
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-4 form-control-label" for="confirm_password">Confirm Password</label>
			<div class="col-sm-8">
				<input 	id="confirm_password"
						name="confirm_password"
					   	value = ""
					   	type="password"
					   	placeholder = ""
					   	class="form-control"
					   	data-validation="[L>=6, L<=18]"
						data-validation-message="$ must be between 6 and 18 characters." />
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-sm-4 form-control-label"></label>
			<div class="col-sm-8">
				<button type="submit" class="btn btn-success"> <fa class="fa fa-key"></i> Change</button>
			</div>
		</div>
	</form>
@endsection