@extends($route.'.tabForm')
@section ('section-title', 'Overview')
@section ('tab-active-edit', 'active')
@section ('tab-css')
	<link href="{{ asset ('public/user/css/plugin/fileinput/fileinput.min.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{ asset ('public/user/css/plugin/fileinput/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
	<!-- some CSS styling changes and overrides -->
	<style>
		.kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
		    margin: 0;
		    padding: 0;
		    border: none;
		    box-shadow: none;
		    text-align: center;
		}
		.kv-avatar .file-input {
		    display: table-cell;
		    max-width: 220px;
		}
	</style>
@endsection

@section ('imageuploadjs')
    <script type="text/javascript" src="{{ asset ('public/user/js/plugin/fileinput/fileinput.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset ('public/user/js/plugin/fileinput/theme.js') }}" type="text/javascript"></script>
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
			

		}); 
	
	</script>

	

	<script>
		
		var btnCust = ''; 
		$("#picture").fileinput({
		    overwriteInitial: true,
		    maxFileSize: 1500,
		    showClose: false,
		    showCaption: false,
		    showBrowse: false,
		    browseOnZoneClick: true,
		    removeLabel: '',
		    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
		    removeTitle: 'Cancel or reset changes',
		    elErrorContainer: '#kv-avatar-errors-2',
		    msgErrorClass: 'alert alert-block alert-danger',
		    defaultPreviewContent: '<img src="{{ asset($data->picture) }}" alt="Missing Image" class="img img-responsive"><span class="text-muted">Click to select <br /><i style="font-size:12px">Image dimesion must be 200x165 with .jpg or .png type</i></span>',
		    layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
		    allowedFileExtensions: ["jpg", "png", "gif"]
		});
	</script>
@endsection

@section ('tab-content')
	@include('cp.layouts.error')
	<form id="form" action="{{ route($route.'.update') }}" name="form" method="POST"  enctype="multipart/form-data">
		{{ csrf_field() }}
		{{ method_field('POST') }}
		<input type="hidden" name="id" value="{{ $data->id }}">
		
		<div class="form-group row">
			<label class="col-sm-2 form-control-label" for="kh_name">Name (KH)</label>
			<div class="col-sm-10">
				<input 	id="kh_name"
						name="kh_name"
					   	value = "{{ $data->kh_name }}"
					   	type="text"
					   	placeholder = "Eg. Name in khmer"
					   	class="form-control"
					   	data-validation="[L>=1, L<=18]"
						data-validation-message="$ is required" />
						
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 form-control-label" for="en_name">Name (EN)</label>
			<div class="col-sm-10">
				<input 	id="en_name"
						name="en_name"
					   	value = "{{ $data->en_name }}"
					   	type="text"
					   	placeholder = "Eg. Name in english"
					   	class="form-control"
					   	data-validation="[L>=1, L<=18]"
						data-validation-message="$ is required" />
						
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 form-control-label" for="email">E-mail</label>
			<div class="col-sm-10">
				<input 	id="email"
						name="email"
						value = "{{ $data->email }}"
						type="text"
						placeholder = "Eg. you@example.com"
					   	class="form-control"
					   	data-validation="[EMAIL]">
			</div>
		</div>
		
		<div class="form-group row">
				<label class="col-sm-2 form-control-label" for="telegram_chat_id">Telegram Chat ID</label>
				<div class="col-sm-10">
					<input 	id="telegram_chat_id"
							name="telegram_chat_id"
						   	value = "{{$data->telegram_chat_id}}"
						   	type="text"
						   	placeholder = "Please enter your telegram chat ID!"
						   	class="form-control" />
							
				</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 form-control-label" for="phone">Phone</label>
			<div class="col-sm-10">
				<input 	id="phone"
						name="phone"
					   	value = "{{ $data->phone }}"
					   	type="text" 
					   	placeholder = "Eg. 093123457"
					   	class="form-control"
					   	data-validation="[L>=9, L<=10, numeric]"
						data-validation-message="$ is not correct." 
						data-validation-regex="/(^[00-9].{8}$)|(^[00-9].{9}$)/"
						data-validation-regex-message="$ must start with 0 and has 10 or 11 digits" />
						
			</div>
		</div>
		
		<div class="form-group row">
			<label for="position_id" class="col-sm-2 form-control-label">Position</label>
			<div class="col-sm-10">
				<select id="position_id" name="position_id" class="form-control">
					<option value="{{ $data->position_id }}" >{{ $data->position->name }}</option>
					@foreach( $positions as $position)
						@if($position->id != $data->position_id)
							<option value="{{ $position->id }}" >{{ $position->name }}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 form-control-label" for="email">Image</label>
			<div class="col-sm-10">
				<div class="kv-avatar center-block">
			        <input id="picture" name="picture" type="file" class="file-loading">
			    </div>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 form-control-label" for="kh_content">Status</label>
			<div class="col-sm-10">
				<div class="checkbox-toggle">
					<input id="status-status" type="checkbox"  @if($data->status ==1 ) checked @endif >
					<label onclick="booleanForm('status')" for="status-status"></label>
				</div>
				<input type="hidden" name="status" id="status" value="{{ $data->status }}">
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-sm-2 form-control-label" for="kh_content">Validate IP</label>
			<div class="col-sm-10">
				<div class="checkbox-toggle">
					<input id="validate"  type="checkbox"  @if($data->is_ip_validated ==1 ) checked @endif >
					<label onclick="booleanForm('is_ip_validated')" for="validate"></label>
				</div>
				<input type="hidden" name="is_ip_validated" id="is_ip_validated" value="{{ $data->is_ip_validated }}">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label"></label>
			<div class="col-sm-10">
				<button type="submit" class="btn btn-success"> <fa class="fa fa-cog"></i> Update</button>
				<button type="button" onclick="deleteConfirm('{{ route($route.'.trash', $data->id) }}', '{{ route($route.'.index') }}')" class="btn btn-danger"> <fa class="fa fa-trash"></i> Delete</button>
			</div>
		</div>
	</form>
@endsection