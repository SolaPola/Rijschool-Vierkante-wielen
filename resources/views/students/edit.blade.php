@extends('layouts.main')

@section('title', 'Edit Student - Rijschool Vierkante Wielen')

@section('content')
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">Edit Student</h2>
        <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all">
            <i class="fas fa-arrow-left mr-2"></i>Back to Students
        </a>
    </div>

    <!-- Alerts -->
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md">
            <div class="flex">
                <div class="flex-shrink-0"><i class="fas fa-check-circle text-green-500"></i></div>
                <div class="ml-3"><p class="font-medium">{{ session('success') }}</p></div>
            </div>
        </div>
    @endif
    
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-md">
            <div class="flex">
                <div class="flex-shrink-0"><i class="fas fa-exclamation-circle text-red-500"></i></div>
                <div class="ml-3"><p class="font-medium">{{ session('error') }}</p></div>
            </div>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
            <h3 class="font-medium text-navy-800">Student Information</h3>
        </div>
        
        <div class="p-6">
            <form method="POST" action="{{ route('students.update', $student->id) }}" id="edit-form">
                @csrf
                @method('PUT')
                
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
                        <h3 class="font-semibold text-lg text-navy-700 mb-4">Personal Details</h3>
                        
                        @if($student->user)
                            <!-- First Name -->
                            <div class="mb-4">
                                <label for="firstname" class="block text-sm font-medium text-gray-700 mb-1">First Name*</label>
                                <input type="text" id="firstname" name="firstname" value="{{ old('firstname', $student->user->firstname) }}" 
                                      class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5"
                                      required>
                            </div>
                            
                            <!-- Infix -->
                            <div class="mb-4">
                                <label for="infix" class="block text-sm font-medium text-gray-700 mb-1">Infix</label>
                                <input type="text" id="infix" name="infix" value="{{ old('infix', $student->user->infix) }}" 
                                      class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5"
                                      placeholder="e.g., van, de, der">
                            </div>
                            
                            <!-- Last Name -->
                            <div class="mb-4">
                                <label for="lastname" class="block text-sm font-medium text-gray-700 mb-1">Last Name*</label>
                                <input type="text" id="lastname" name="lastname" value="{{ old('lastname', $student->user->lastname) }}" 
                                      class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5"
                                      required>
                            </div>
                            
                            <!-- Birthdate -->
                            <div class="mb-4">
                                <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-1">Birth Date*</label>
                                <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate', $student->user->birthdate ? date('Y-m-d', strtotime($student->user->birthdate)) : '') }}"
                                      class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5"
                                      required>
                            </div>
                            
                            <!-- Relation Number -->
                            <div class="mb-4">
                                <label for="relation_number" class="block text-sm font-medium text-gray-700 mb-1">Relation Number</label>
                                <input type="text" id="relation_number" name="relation_number" value="{{ old('relation_number', $student->relation_number) }}"
                                      class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5">
                            </div>
                            
                            <!-- Active Status -->
                            <div class="mb-4 flex items-center">
                                <input type="checkbox" id="isactive" name="isactive" value="1" 
                                      class="w-4 h-4 text-navy-600 bg-gray-100 rounded border-gray-300 focus:ring-navy-500"
                                      {{ old('isactive', $student->isactive) ? 'checked' : '' }}>
                                <label for="isactive" class="ml-2 text-sm font-medium text-gray-700">Active Student</label>
                            </div>
                        @else
                            <div class="p-4 bg-red-50 text-red-700 rounded-md">
                                <p>Error: User information not found for this student.</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Right Column - Contact Information -->
                    <div>
                        <h3 class="font-semibold text-lg text-navy-700 mb-4">Contact Information</h3>
                        
                        @if($student->user)
                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address*</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $student->user->email) }}"
                                      class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5"
                                      required>
                            </div>
                            
                            <!-- Phone -->
                            <div class="mb-4">
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $student->user->phone ?? '') }}"
                                      class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5"
                                      placeholder="e.g., 06-12345678">
                            </div>
                            
                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <input type="password" id="password" name="password"
                                      class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5">
                                <p class="mt-1 text-xs text-gray-500">Leave blank to keep current password</p>
                            </div>
                            
                            <!-- Password Confirmation -->
                            <div class="mb-4">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                      class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 pt-5 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('students.index') }}"
                           class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy-500">
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-navy-600 hover:bg-navy-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy-500">
                            <i class="fas fa-save mr-2"></i> Update Student
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Success Popup -->
    <div id="success-popup" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>
            
            <!-- Modal panel -->
            <div class="relative bg-white rounded-lg max-w-md w-full mx-auto shadow-lg">
                <div class="p-6">
                    <div class="mb-4 text-center">
                        <i class="fas fa-check-circle text-green-500 text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2 text-center" id="success-message">
                        Student updated successfully
                    </h3>
                    <div class="flex justify-center mt-4">
                        <button id="close-success" class="px-4 py-2 bg-navy-600 text-white rounded hover:bg-navy-700">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editForm = document.getElementById('edit-form');
        const password = document.getElementById('password');
        const passwordConfirm = document.getElementById('password_confirmation');
        const successPopup = document.getElementById('success-popup');
        const closeSuccessBtn = document.getElementById('close-success');
        
        // Form validation
        editForm.addEventListener('submit', function(e) {
            // Only validate password if it's provided
            if (password.value) {
                if (password.value !== passwordConfirm.value) {
                    e.preventDefault();
                    alert('Passwords do not match');
                    passwordConfirm.focus();
                    return;
                }
            }

            // Optional: AJAX submission
            e.preventDefault();
            
            const formData = new FormData(this);
            const action = this.action;
            
            fetch(action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    successPopup.classList.remove('hidden');
                    
                    // Auto-redirect after a brief pause - changed to instructors.students route
                    setTimeout(() => {
                        window.location.href = "{{ route('instructors.students') }}";
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Error updating student');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating student. Please try again.');
            });
        });
        
        // Close popup when OK button is clicked - changed to instructors.students route
        closeSuccessBtn.addEventListener('click', function() {
            successPopup.classList.add('hidden');
            window.location.href = "{{ route('instructors.students') }}";
        });
        
        // Close popup when ESC key is pressed
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !successPopup.classList.contains('hidden')) {
                successPopup.classList.add('hidden');
                window.location.href = "{{ route('instructors.students') }}";
            }
        });
        
        // Close popup when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === successPopup) {
                successPopup.classList.add('hidden');
                window.location.href = "{{ route('instructors.students') }}";
            }
        });
    });
</script>
@endsection
