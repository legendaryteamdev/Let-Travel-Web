@extends($route.'.main')
@section ('section-css')
	@yield ('tab-css')
@endsection

@section ('section-js')
	@yield ('tab-js')
@endsection

@section ('section-content')
		
			
	<section class="tabs-section">
		<div class="tabs-section-nav tabs-section-nav-icons">
			<div class="tbl">
				<ul class="nav" role="tablist">
					<li class="nav-item">
						
						<a class="nav-link @yield ('tab-active-edit')" onclick="window.location.href='{{ route($route.'.edit') }}'" href="#" role="tab" data-toggle="tab">
							<span class="nav-link-in">
								<i class="fa fa-user"></i> My Account
							</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link @yield ('tab-active-password')" onclick="window.location.href='{{ route($route.'.edit-password') }}' " href="#" role="tab" data-toggle="tab">
							<span class="nav-link-in">
								<i class="fa fa-key"></i> Change Password
							</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link @yield ('tab-active-logs')" onclick="window.location.href='{{ route($route.'.logs') }}' " href="#" role="tab" data-toggle="tab">
							<span class="nav-link-in">
								<i class="glyphicon glyphicon-stats"></i> Logged History
							</span>
						</a>
					</li>
					
				</ul>
			</div>
		</div><!--.tabs-section-nav-->

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active">
				<div id="tab-content-cnt" class="container-fluid">
					@yield ('tab-content')
				</div>
			</div>
		</div><!--.tab-content-->
	</section><!--.tabs-section-->
				
	


@endsection