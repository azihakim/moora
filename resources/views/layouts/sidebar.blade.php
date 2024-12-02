<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard.index') }}">
		<div class="sidebar-brand-text mx-3">Moora</sup></div>
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	@if (auth()->user()->role == 'HRD')
		<li class="nav-item ">
			<a class="nav-link" href="{{ route('dashboard.index') }}">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Dashboard</span></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="{{ route('users.index') }}">
				<i class="fas fa-fw fa-user"></i>
				<span>Pegawai</span></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="{{ route('kriteria.index') }}">
				<i class="fas fa-fw fa-cog"></i>
				<span>Kriteria</span></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="{{ route('sub_kriteria.index') }}">
				<i class="fas fa-fw fa-cogs"></i>
				<span>Sub Kriteria</span></a>
		</li>

		{{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('alternatif.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Alternatif</span></a>
        </li> --}}

		{{-- <li class="nav-item">
			<a class="nav-link" href="{{ route('penilaian.index') }}">
				<i class="fas fa-fw fa-clipboard-list"></i>
				<span>Penilaian</span></a>
		</li> --}}
		<li class="nav-item">
			<a class="nav-link" href="{{ route('penilaianPerbulan.index') }}">
				<i class="fas fa-fw fa-clipboard-list"></i>
				<span>Penilaian</span></a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="{{ route('perhitungan.index') }}">
				<i class="fas fa-fw fa-calculator"></i>
				<span>Hasil Perhitungan</span></a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="{{ route('rangking.index') }}">
				<i class="fas fa-fw fa-trophy"></i>
				<span>Rangking</span></a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="{{ route('rekap.index') }}">
				<i class="fas fa-fw fa-edit"></i>
				<span>Rekap Penilaian</span></a>
		</li>
	@endif

	@if (auth()->user()->role == 'Pegawai')
		<li class="nav-item">
			<a class="nav-link" href="{{ route('perhitungan.index') }}">
				<i class="fas fa-fw fa-calculator"></i>
				<span>Hasil Perhitungan</span></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="{{ route('rangking.index') }}">
				<i class="fas fa-fw fa-trophy"></i>
				<span>Rangking</span></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="{{ route('rekap.index') }}">
				<i class="fas fa-fw fa-edit"></i>
				<span>Rekap Penilaian</span></a>
		</li>
	@endif

	@if (auth()->user()->role == 'Direktur')
		<li class="nav-item ">
			<a class="nav-link" href="{{ route('dashboard.index') }}">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Dashboard</span></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="{{ route('perhitungan.index') }}">
				<i class="fas fa-fw fa-calculator"></i>
				<span>Hasil Perhitungan</span></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="{{ route('rangking.index') }}">
				<i class="fas fa-fw fa-trophy"></i>
				<span>Rangking</span></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="{{ route('rekap.index') }}">
				<i class="fas fa-fw fa-edit"></i>
				<span>Rekap Penilaian</span></a>
		</li>
	@endif

	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>

</ul>
