@extends('layouts.app')

@section('title', ' - Login')

@php
    $hide_navbar = true;
@endphp

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-body p-4">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <p class="mb-1">Don't have an account? <a href="{{ route('register') }}">Register as Student</a></p>
                </div>

                <hr class="my-3">
                
                <div class="text-center">
                    <small class="text-muted">Demo Credentials:</small>
                    <div class="mt-2">
                        <small class="text-muted">Admin: admin@g-sched.test / password</small><br>
                        <small class="text-muted">Guidance: guidance@g-sched.test / password</small><br>
                        <small class="text-muted">Student: student@g-sched.test / password</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
