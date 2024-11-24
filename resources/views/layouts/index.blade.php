<!DOCTYPE html>
<html lang="en">

<head>
	@include('layouts.head')
	@yield('styles')
</head>

<body id="page-top">

	<div id="wrapper">
		@include('layouts.sidebar')
		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content">
				@include('layouts.topbar')
				@yield('content')
			</div>
			@include('layouts.footer')
		</div>
	</div>

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	@include('layouts.scripts')
	@stack('scripts')
	@yield('scripts')
</body>

</html>
