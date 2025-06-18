@extends('layouts.main')

@section('title', 'Create New User - Rijschool Vierkante Wielen')

@section('content')
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">Create New User</h2>
        <a href="{{ route('accounts.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all">
            <i class="fas fa-arrow-left mr-2"></i>Back to Users
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <form method="POST" action="{{ route('accounts.store') }}">
                @csrf

                <!-- Form errors -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Two column form layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column - Personal Information -->
                    <div>
                        <h3 class="font-semibold text-lg text-navy-700 mb-4">Personal Information</h3>

                        <!-- First Name -->
                        <div class="mb-4">
                            <label for="firstname" class="block text-sm font-medium text-gray-700 mb-1">First Name*</label>
                            <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5"
                                required>
                        </div>

                        <!-- Infix -->
                        <div class="mb-4">
                            <label for="infix" class="block text-sm font-medium text-gray-700 mb-1">Infix</label>
                            <input type="text" id="infix" name="infix" value="{{ old('infix') }}"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5">
                        </div>

                        <!-- Last Name -->
                        <div class="mb-4">
                            <label for="lastname" class="block text-sm font-medium text-gray-700 mb-1">Last Name*</label>
                            <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5"
                                required>
                        </div>

                        <!-- Birthdate -->
                        <div class="mb-4">
                            <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-1">Birth Date*</label>
                            <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5"
                                required>
                        </div>

                        <!-- Role Selection -->
                        <div class="mb-4">
                            <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">Role*</label>
                            <select id="role_id" name="role_id"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5"
                                required>
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Set is_active to true by default with hidden field -->
                        <input type="hidden" name="is_active" value="1">
                    </div>

                    <!-- Right Column - Account Credentials -->
                    <div>
                        <h3 class="font-semibold text-lg text-navy-700 mb-4">Account Credentials</h3>

                        <!-- Username -->
                        <div class="mb-4">
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username*</label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5"
                                required>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                Address*</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5"
                                required>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password*</label>
                            <input type="password" id="password" name="password"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5"
                                required>
                            <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
                        </div>

                        <!-- Password Confirmation -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm
                                Password*</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5"
                                required>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 pt-5 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('accounts.index') }}"
                            class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy-500">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-navy-600 hover:bg-navy-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy-500">
                            Create User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Client-side form validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('password_confirmation');

            form.addEventListener('submit', function(e) {
                if (password.value !== passwordConfirm.value) {
                    e.preventDefault();
                    alert('Passwords do not match');
                    passwordConfirm.focus();
                }
            });
        });
    </script>
@endsection
