@extends('cp.user.user.tabForm')
@section ('section-title', "User's Permision")
@section ('tab-active-system-permision', 'active')
@section ('tab-css')

@endsection

@section ('tab-js')
<script type="text/javascript">
	$(document).ready(function(){
		$('.item').click(function(){
			check_id = $(this).attr('for');
			permision_id = $("#"+check_id).attr('permision-id');
			features(permision_id);
		})
	})
	function features(permision_id){
		$.ajax({
		        url: "{{ route($route.'.check-system-permision') }}?user_id={{ $id }}&permision_id="+permision_id,
		        type: 'GET',
		        data: { },
		        success: function( response ) {
		            if ( response.status === 'success' ) {
		            	toastr.success(response.msg);
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

@section ('tab-content')
	<br />
	@foreach($categories as $cateogry)
		
		<h4>{{ $cateogry->title }}</h4>
		@php( $permisions = $cateogry->permisions )
		<div class="row m-t-lg">
			@foreach( $permisions as $permision )
				@php( $check = "" )
		        @foreach($data as $row)
		            @if($row->permision_id == $permision->id)
		                @php( $check = "checked" )
		            @endif
		        @endforeach
				<div class="col-sm-6 col-sm-4 col-md-3 col-lg-3">
					<div class="checkbox-bird">
						<input type="checkbox" permision-id="{{ $permision->id }}" id="permision-{{ $permision->id }}" {{ $check }}>
						<label class="item" for="permision-{{ $permision->id }}">{{ $permision->title }}</label>
					</div>
				</div>
			@endforeach
		</div>
		<hr />
	@endforeach

@endsection