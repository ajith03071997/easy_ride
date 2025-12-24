<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Easy Ride - Vendor')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-bg: #1e1b4b;
            --sidebar-hover: #312e81;
            --sidebar-active: #6366f1;
            --sidebar-text: #a5b4fc;
            --sidebar-text-active: #ffffff;
            --accent-color: #818cf8;
            --header-bg: #0f0d2e;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            overflow-x: hidden;
        }
        
        html {
            overflow-x: hidden;
        }
        
        .sidebar {
            height: 100vh;
            background: linear-gradient(180deg, var(--header-bg) 0%, var(--sidebar-bg) 100%);
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 250px;
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        .sidebar-brand {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }
        
        .sidebar-brand h4 {
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
        }
        
        .sidebar-brand .brand-icon {
            background: linear-gradient(135deg, var(--accent-color) 0%, #4f46e5 100%);
            padding: 8px 12px;
            border-radius: 10px;
            margin-right: 10px;
            display: inline-block;
        }
        
        .sidebar .nav-link {
            color: var(--sidebar-text);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 3px 12px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }
        
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 12px;
            font-size: 1rem;
        }
        
        .sidebar .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: var(--sidebar-text-active);
            transform: translateX(3px);
        }
        
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--sidebar-active) 0%, #4f46e5 100%);
            color: var(--sidebar-text-active);
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }
        
        .sidebar-section {
            color: var(--accent-color);
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            padding: 15px 20px 8px;
            margin-top: 10px;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 25px 30px;
            min-height: 100vh;
            overflow-x: hidden;
            max-width: calc(100vw - 250px);
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            padding: 1rem 1.25rem;
            border-radius: 12px 12px 0 0 !important;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--accent-color) 0%, #6366f1 100%);
            border: none;
            padding: 10px 20px;
            font-weight: 600;
            border-radius: 8px;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
        }
        
        .logout-btn {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #ef4444 !important;
            margin-top: 20px;
        }
        
        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444 !important;
        }
        
        .table {
            font-size: 0.9rem;
        }
        
        .table th {
            font-weight: 600;
            color: #475569;
            border-bottom-width: 2px;
        }
        
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .card-body {
            overflow-x: auto;
        }
        
        .badge {
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 6px;
        }
        
        .page-header {
            margin-bottom: 25px;
        }
        
        .page-header h2 {
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        
        .stat-card {
            border-radius: 12px;
            padding: 1.5rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        
        .stat-card.indigo { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); }
        .stat-card.emerald { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .stat-card.amber { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .stat-card.rose { background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%); }
        
        @media (max-width: 992px) {
            .sidebar {
                width: 100%;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="sidebar">
                <div class="sidebar-brand text-center">
                    <h4>
                        <span class="brand-icon"><i class="fas fa-building"></i></span>
                        Easy Ride
                    </h4>
                    <small class="text-muted" style="font-size: 0.75rem; color: var(--sidebar-text) !important;">Vendor Portal</small>
                </div>
                
                <nav class="nav flex-column pb-4">
                    <a class="nav-link {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}" href="{{ route('vendor.dashboard') }}">
                        <i class="fas fa-th-large"></i> Dashboard
                    </a>

                    <div class="sidebar-section">Trip Management</div>

                    <a class="nav-link {{ request()->routeIs('vendor.trips.*') ? 'active' : '' }}" href="{{ route('vendor.trips.index') }}">
                        <i class="fas fa-taxi"></i> Trip Booking
                    </a>

                    <a class="nav-link {{ request()->routeIs('vendor.routes.*') ? 'active' : '' }}" href="{{ route('vendor.routes.index') }}">
                        <i class="fas fa-map-marked-alt"></i> Employee Routes
                    </a>

                    <div class="sidebar-section">Finance</div>

                    <a class="nav-link {{ request()->routeIs('vendor.billing.*') ? 'active' : '' }}" href="{{ route('vendor.billing.index') }}">
                        <i class="fas fa-file-invoice-dollar"></i> Billing & Expenses
                    </a>

                    <div class="sidebar-section">Communication</div>

                    <a class="nav-link {{ request()->routeIs('vendor.notifications.*') ? 'active' : '' }}" href="{{ route('vendor.notifications.index') }}">
                        <i class="fas fa-bell"></i> Notifications
                    </a>

                    <a class="nav-link {{ request()->routeIs('vendor.support-tickets.*') ? 'active' : '' }}" href="{{ route('vendor.support-tickets.index') }}">
                        <i class="fas fa-headset"></i> Support
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="px-3 mt-4">
                        @csrf
                        <button type="submit" class="nav-link logout-btn w-100 text-center">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </nav>
            </div>
            
            <div class="main-content">
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
                
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'desc']]
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>
