@extends('layouts.superAdmin')

@section('pageName', 'About Page')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Hero Section -->
    <div class="bg-white rounded-xl shadow-md p-8 mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Prison Record Management System</h1>
        <p class="text-lg text-gray-600 leading-relaxed">
            A comprehensive digital solution designed to streamline and modernize prison administrative operations.
        </p>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Mission Section -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-bullseye text-blue-600 text-2xl"></i>
                </div>
                <h2 class="text-2xl font-semibold text-gray-800 ml-4">Our Mission</h2>
            </div>
            <p class="text-gray-600 leading-relaxed">
                To provide a secure, efficient, and user-friendly system that enhances the management of correctional
                facilities while ensuring accurate record-keeping and data integrity.
            </p>
        </div>

        <!-- Vision Section -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-eye text-green-600 text-2xl"></i>
                </div>
                <h2 class="text-2xl font-semibold text-gray-800 ml-4">Our Vision</h2>
            </div>
            <p class="text-gray-600 leading-relaxed">
                To revolutionize correctional facility management through digital transformation, promoting
                transparency, efficiency, and improved decision-making processes.
            </p>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-white rounded-xl shadow-md p-8 mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Key Features</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 bg-gray-50 rounded-lg">
                <div class="flex items-center mb-3">
                    <i class="fas fa-database text-indigo-600 text-xl mr-3"></i>
                    <h3 class="text-xl font-semibold text-gray-800">Secure Database</h3>
                </div>
                <p class="text-gray-600">Advanced data encryption and secure storage of sensitive information.</p>
            </div>

            <div class="p-6 bg-gray-50 rounded-lg">
                <div class="flex items-center mb-3">
                    <i class="fas fa-chart-line text-indigo-600 text-xl mr-3"></i>
                    <h3 class="text-xl font-semibold text-gray-800">Real-time Analytics</h3>
                </div>
                <p class="text-gray-600">Comprehensive reporting and analytics tools for informed decision-making.</p>
            </div>

            <div class="p-6 bg-gray-50 rounded-lg">
                <div class="flex items-center mb-3">
                    <i class="fas fa-users text-indigo-600 text-xl mr-3"></i>
                    <h3 class="text-xl font-semibold text-gray-800">User Management</h3>
                </div>
                <p class="text-gray-600">Role-based access control and comprehensive user management system.</p>
            </div>
        </div>
    </div>

    <!-- System Information -->
    <div class="bg-white rounded-xl shadow-md p-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">System Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="flex items-center">
                    <i class="fas fa-code text-gray-400 w-8"></i>
                    <span class="text-gray-600">Version: 1.0.0</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-calendar text-gray-400 w-8"></i>
                    <span class="text-gray-600">Last Updated: December 2024</span>
                </div>
            </div>
            <div class="space-y-4">
                <div class="flex items-center">
                    <i class="fas fa-shield-alt text-gray-400 w-8"></i>
                    <span class="text-gray-600">Security: ISO 27001 Certified</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-clock text-gray-400 w-8"></i>
                    <span class="text-gray-600">24/7 System Monitoring</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection