@extends('layouts.app')

@section('title', 'Settings - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-cog"></i> Settings</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">System Settings</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="currency" class="form-label">Default Currency</label>
                        <select class="form-select @error('currency') is-invalid @enderror"
                                id="currency"
                                name="currency" required>
                            <option value="">Select Currency</option>
                            <option value="EGP" {{ old('currency', $settings['currency'] ?? '') == 'EGP' ? 'selected' : '' }}>EGP (Egyptian Pound)</option>
                            <option value="USD" {{ old('currency', $settings['currency'] ?? '') == 'USD' ? 'selected' : '' }}>USD (US Dollar)</option>
                            <option value="EUR" {{ old('currency', $settings['currency'] ?? '') == 'EUR' ? 'selected' : '' }}>EUR (Euro)</option>
                        </select>
                        @error('currency')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="business_name" class="form-label">Business Name</label>
                        <input type="text"
                               class="form-control @error('business_name') is-invalid @enderror"
                               id="business_name"
                               name="business_name"
                               value="{{ old('business_name', $settings['business_name'] ?? '') }}">
                        @error('business_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="business_address" class="form-label">Business Address</label>
                        <textarea class="form-control @error('business_address') is-invalid @enderror"
                                  id="business_address"
                                  name="business_address"
                                  rows="3">{{ old('business_address', $settings['business_address'] ?? '') }}</textarea>
                        @error('business_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="business_phone" class="form-label">Business Phone</label>
                        <input type="text"
                               class="form-control @error('business_phone') is-invalid @enderror"
                               id="business_phone"
                               name="business_phone"
                               value="{{ old('business_phone', $settings['business_phone'] ?? '') }}">
                        @error('business_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="business_email" class="form-label">Business Email</label>
                        <input type="email"
                               class="form-control @error('business_email') is-invalid @enderror"
                               id="business_email"
                               name="business_email"
                               value="{{ old('business_email', $settings['business_email'] ?? '') }}">
                        @error('business_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="default_session_duration" class="form-label">Default Session Duration (minutes)</label>
                                <input type="number"
                                       class="form-control @error('default_session_duration') is-invalid @enderror"
                                       id="default_session_duration"
                                       name="default_session_duration"
                                       min="1"
                                       value="{{ old('default_session_duration', $settings['default_session_duration'] ?? '') }}">
                                @error('default_session_duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="auto_close_sessions" class="form-label">Auto Close Sessions</label>
                                <select class="form-select @error('auto_close_sessions') is-invalid @enderror"
                                        id="auto_close_sessions"
                                        name="auto_close_sessions">
                                    <option value="0" {{ old('auto_close_sessions', $settings['auto_close_sessions'] ?? '') == '0' ? 'selected' : '' }}>Disabled</option>
                                    <option value="1" {{ old('auto_close_sessions', $settings['auto_close_sessions'] ?? '') == '1' ? 'selected' : '' }}>Enabled</option>
                                </select>
                                @error('auto_close_sessions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Settings
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="location.reload()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">System Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Laravel Version:</strong> {{ app()->version() }}</p>
                <p><strong>PHP Version:</strong> {{ PHP_VERSION }}</p>
                <p><strong>Database:</strong> MySQL</p>
                <p><strong>Environment:</strong> {{ app()->environment() }}</p>
                <p><strong>Debug Mode:</strong>
                    @if(config('app.debug'))
                        <span class="badge bg-warning">Enabled</span>
                    @else
                        <span class="badge bg-success">Disabled</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('daily-sessions.create') }}" class="btn btn-success">
                        <i class="fas fa-play"></i> Start New Session
                    </a>
                    <a href="{{ route('reports.index') }}" class="btn btn-info">
                        <i class="fas fa-chart-bar"></i> View Reports
                    </a>
                    <a href="{{ route('users.index') }}" class="btn btn-warning">
                        <i class="fas fa-users"></i> Manage Users
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
