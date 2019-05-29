@extends('cp.layouts.app')
@section('active-main-menu-users', 'opened')
@section('title')
	Profile: @yield('section-title')
@endsection

@section ('appheadercss')
	@yield('section-css')
@endsection


@section ('appbottomjs')
	@yield('section-js')
@endsection

@section ('page-content')
	<header class="page-content-header">
		<div class="container-fluid">
			<div class="tbl">
				<div class="tbl-row">
					<div class="tbl-cell">
						<h3>Profile <span> <i class="fa fa-long-arrow-right"></i> @yield('section-title')</span></h3> 
					</div>
					<div class="tbl-cell tbl-cell-action">
						
					</div>
				</div>
			</div>
		</div>
	</header>
	<div class="container-fluid">
		<div class="box-typical box-typical-padding">
				@yield('section-content')
		</div>	
	</div>

@endsection