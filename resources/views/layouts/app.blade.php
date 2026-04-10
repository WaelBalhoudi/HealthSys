




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HealthSys')</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    @stack('styles')
</head>

<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        <!-- SIDEBAR -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

            <!-- LOGO -->
            <div class="app-brand demo my-3 px-3">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    Health<span>Sys</span>
                </a>
                <a id="mobile-menu-btn" class="menu-link text-large ms-auto d-block d-xl-none">
                    <i class="fa-solid fa-chevron-left fa-sm align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
            @auth
                {{-- ================= CHEF_MEDECINE ================= --}}
                @if(auth()->user()->role == 'chef_medecine')
                    <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-chart-line"></i>
                            <div>Dashboard</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.doctors.index') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-user-doctor"></i>
                            <div>Médecins</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.patients.*') ? 'active' : '' }}">
                        <a href="#" class="menu-link">
                            <i class="menu-icon fa-solid fa-user-injured"></i>
                            <div>Patients</div>
                        </a>
                    </li>
                    <li class="menu-item ">
                        <a href="#" class="menu-link">
                            <i class="menu-icon fa-solid fa-calendar-check"></i>
                            <div>Rendez-vous</div>
                        </a>
                    </li>
                    <li class="menu-item" >
                        <a href="{{ route('admin.specialites.index') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-stethoscope"></i>
                            <div>Spécialités</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.departements.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.departements.index') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-building-columns"></i>
                            <div>Départements</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.secretaries.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.secretaries.index') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-user-tie"></i>
                            <div>Secrétaires</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                        <a href="{{ route('admin.reports') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-chart-bar"></i>
                            <div>Rapports</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('settings*') ? 'active' : '' }}">
                        <a href="#" class="menu-link">
                            <i class="menu-icon fa-solid fa-gear"></i>
                            <div>Paramètres</div>
                        </a>
                    </li>

                {{-- ================= DOCTOR ================= --}}
                            @elseif(auth()->user()->role == 'doctor')
                    <li class="menu-item">
                        <a href="{{ url('/doctor/dashboard') }}" class="menu-link {{ request()->is('doctor/dashboard') ? 'active' : '' }}">
                            <i class="menu-icon fa-solid fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ url('/doctor/waiting-room') }}" class="menu-link {{ request()->is('doctor/waiting-room*') ? 'active' : '' }}">
                            <i class="menu-icon fa-solid fa-clock"></i>
                            <span>Salle d'attente</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ url('/doctor/consultations') }}" class="menu-link {{ request()->is('doctor/consultations*') ? 'active' : '' }}">
                            <i class="menu-icon fa-solid fa-stethoscope"></i>
                            <span>Consultations</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ url('/doctor/history') }}" class="menu-link {{ request()->is('doctor/history*') ? 'active' : '' }}">
                            <i class="menu-icon fa-solid fa-history"></i>
                            <span>Historique</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ url('/doctor/patients') }}" class="menu-link {{ request()->is('doctor/patients*') ? 'active' : '' }}">
                            <i class="menu-icon fa-solid fa-user-injured"></i>
                            <span>Mes Patients</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ url('/doctor/establish-document') }}" class="menu-link {{ request()->is('doctor/establish-document*') ? 'active' : '' }}">
                            <i class="menu-icon fas fa-file-alt"></i>
                            <span>Établir un document</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ url('/doctor/notifications') }}" class="menu-link {{ request()->is('doctor/notifications*') ? 'active' : '' }}">
                            <i class="menu-icon fas fa-bell"></i>
                            <span>Notifications</span>
                        </a>
                    </li>

                {{-- ================= SECRETAIRE ================= --}}
                 @elseif(auth()->user()->role == 'secretaire')
                    <li class="menu-item">
                        <a href="{{ url('/secretaire/dashboard') }}" class="menu-link {{ request()->is('secretaire/dashboard') ? 'active' : '' }}">
                            <i class="menu-icon fa-solid fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ url('/secretaire/appointments') }}" class="menu-link {{ request()->is('secretaire/appointments*') ? 'active' : '' }}">
                            <i class="menu-icon fa-solid fa-calendar-check"></i>
                            <span>Rendez-vous</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ url('/secretaire/patients') }}" class="menu-link {{ request()->is('secretaire/patients*') ? 'active' : '' }}">
                            <i class="menu-icon fa-solid fa-users"></i>
                            <span>Patients</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ url('/secretaire/comptabilite') }}" class="menu-link {{ request()->is('secretaire/comptabilite') ? 'active' : '' }}">
                            <i class="menu-icon fa-solid fa-chart-line"></i>
                            <span>Comptabilité</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ url('/secretaire/documents') }}" class="menu-link {{ request()->is('secretaire/documents') ? 'active' : '' }}">
                            <i class="menu-icon fa-solid fa-file-alt"></i>
                            <span>Documents</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ url('/secretaire/waiting-room') }}" class="menu-link {{ request()->is('secretaire/waiting-room*') ? 'active' : '' }}">
                            <i class="menu-icon fa-solid fa-clock"></i>
                            <span>Salle d'attente</span>
                        </a>
                    </li>

                {{-- ================= PATIENT ================= --}}
                @elseif(auth()->user()->role == 'patient')
                    <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-house"></i>
                            <div>Accueil</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('patient.appointments*') ? 'active' : '' }}">
                        <a href="{{ route('patient.appointments') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-calendar-check"></i>
                            <div>Mes rendez-vous</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('patient.medical-record*') ? 'active' : '' }}">
                        <a href="{{ route('patient.medical-record') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-notes-medical"></i>
                            <div>Dossier médical</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('patient.prescriptions*') ? 'active' : '' }}">
                        <a href="{{ route('patient.prescriptions') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-prescription"></i>
                            <div>Ordonnances</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('patient.invoices*') ? 'active' : '' }}">
                        <a href="{{ route('patient.invoices') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-file-invoice-dollar"></i>
                            <div>Factures</div>
                        </a>
                    </li>
                    
          @endif

                {{-- ================= ACCOUNT / LOGOUT ================= --}}
                <li class="menu-header small text-uppercase mt-4">
                    <span class="menu-header-text">Compte</span>
                </li>
                <li class="menu-item {{ request()->routeIs('profile*') ? 'active' : '' }}" >
                    <a href="{{ route('profile.edit') }}" class="menu-link ">
                        <i class="menu-icon fa-solid fa-user"></i>
                        <div>Mon Profil</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link text-danger" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="menu-icon fa-solid fa-right-from-bracket"></i>
                        <div>Déconnexion</div>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @endauth
            </ul>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="layout-page">

            <!-- NAVBAR -->
            <nav class="layout-navbar navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme">

                <!-- Mobile Toggle -->
                <div class="layout-menu-toggle navbar-nav d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4">
                        <i class="fas fa-bars"></i>
                    </a>
                </div>

                <!-- Search -->
                <div class="navbar-nav align-items-center">
                    <div class="nav-item d-flex align-items-center">
                        <i class="fas fa-search fs-6"></i>
                        <input type="text" class="form-control border-0 shadow-none"
                               placeholder="Rechercher..." style="width: 180px;"/>
                    </div>
                </div>

                 <!-- Right Side -->
                <ul class="navbar-nav flex-row align-items-center ms-auto">

                    <!-- Notifications -->
                    <li class="nav-item notification-icon me-3">
                        <a class="nav-link position-relative" href="#">
                            <i class="fas fa-bell fa-lg"></i>
                            <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle" >3</span>
                        </a>
                    </li>




                    <!-- User Dropdown -->
                    <li class="nav-item dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle hide-arrow" href="#" data-bs-toggle="dropdown">
                            <div class="avatar avatar-online">
                                <img 
                                    src="{{ auth()->user()->avatar && file_exists(storage_path('app/public/' . auth()->user()->avatar)) 
                                        ? asset('storage/' . auth()->user()->avatar) 
                                        : asset('assets/img/avatars/user.png') }}"
                                    class="w-px-40 rounded-circle"
                                    alt="Avatar">
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="px-3 py-2">
                                <strong>{{ auth()->user()->name ?? 'Admin' }}</strong><br>
                                <small>{{ auth()->user()->email ?? 'admin@healthsys.com' }}</small>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Paramètres</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-right-from-bracket me-2"></i>Déconnexion
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <!-- PAGE CONTENT -->
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <ul class="mb-0 small">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Dynamic Content -->
                    <h2 class="mb-1">@yield('title', 'Dashboard')</h2>
                    <p class="text-muted mb-4">@yield('page-title', '')</p>
                    @yield('content')

                </div>

                <!-- FOOTER -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl d-flex justify-content-between py-2 flex-wrap">
                        <div>© {{ date('Y') }} HealthSys — Plateforme de Gestion Médicale</div>
                        <div>
                            <a href="#" class="footer-link me-3">Confidentialité</a>
                            <a href="#" class="footer-link">Support</a>
                            <a href="#" class="footer-link">Conditions</a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <div class="layout-overlay"></div>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
@stack('scripts')
</body>
</html>