<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driving Packages - Rijschool Vierkante Wielen</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'navy': '#172554',
                        'yellow': '#FACC15',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        
        .bg-navy-600 {
            background-color: #1e40af;
        }

        .bg-navy-700 {
            background-color: #1e3a8a;
        }

        .text-navy-800 {
            color: #1e3570;
        }

        .hover\:bg-navy-700:hover {
            background-color: #1e3a8a;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-navy text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <span class="text-yellow font-bold text-xl">Driving School Square Wheels</span>
                    </div>
                </div>
                <div class="hidden md:flex items-center justify-between space-x-4">
                    <div class="flex items-baseline space-x-4">
                        <a href="/"
                            class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-navy-800">Home</a>
                        <a href="#"
                            class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-navy-800">Services</a>
                        <a href="#"
                            class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-navy-800">Prices</a>
                        <a href="#"
                            class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-navy-800">About Us</a>
                        <a href="#"
                            class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-navy-800">Contact</a>
                    </div>
                    <div class="ml-4 flex items-center space-x-2">
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-navy bg-yellow hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-navy bg-yellow hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                Login
                            </a>
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white border-yellow hover:bg-navy-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                Sign Up
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-navy-800 mb-8 text-center">Choose Your Perfect Driving Package</h2>
        
        <div class="max-w-5xl mx-auto">
            <p class="text-gray-700 text-center mb-10">
                At Rijschool Vierkante Wielen, we offer tailored driving packages to fit your needs and budget. 
                Our experienced instructors will guide you through every step of your driving journey.
            </p>
            
            <div class="grid md:grid-cols-3 gap-8">
                @forelse ($packages as $package)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-transform hover:scale-105">
                        <div class="bg-navy-600 text-white py-4 px-6">
                            <h3 class="text-xl font-bold">{{ $package->type }}</h3>
                        </div>
                        <div class="p-6">
                            <div class="mb-4">
                                <p class="text-3xl font-bold text-navy-800">€{{ number_format($package->price_per_lesson * $package->number_of_lessons, 2) }}</p>
                                <p class="text-gray-600 text-sm">€{{ number_format($package->price_per_lesson, 2) }} per lesson</p>
                            </div>
                            
                            <div class="mb-6">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-car-side text-navy-800 mr-2"></i>
                                    <p><span class="font-bold">{{ $package->number_of_lessons }}</span> Driving Lessons</p>
                                </div>
                                
                                @if($package->type == 'Package3')
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-certificate text-navy-800 mr-2"></i>
                                        <p>Practical Exam Included</p>
                                    </div>
                                @endif
                                
                                @if($package->type == 'Package2' || $package->type == 'Package3')
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-book text-navy-800 mr-2"></i>
                                        <p>Theory Material Included</p>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="mt-auto">
                                <a href="#" class="block w-full bg-yellow hover:bg-yellow-400 text-navy font-medium py-2 px-4 rounded-md text-center">
                                    Choose This Package
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-10">
                        <p class="text-gray-500 text-lg">No packages currently available.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-12 bg-gray-100 rounded-lg p-6">
                <h3 class="text-xl font-bold text-navy-800 mb-4">Why Choose Us?</h3>
                <div class="grid md:grid-cols-3 gap-4">
                    <div class="flex items-start">
                        <div class="bg-navy-600 text-white p-2 rounded-full mr-3">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <h4 class="font-bold">Experienced Instructors</h4>
                            <p class="text-sm text-gray-600">Learn from certified professionals</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="bg-navy-600 text-white p-2 rounded-full mr-3">
                            <i class="fas fa-car"></i>
                        </div>
                        <div>
                            <h4 class="font-bold">Modern Vehicles</h4>
                            <p class="text-sm text-gray-600">Train with up-to-date cars</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="bg-navy-600 text-white p-2 rounded-full mr-3">
                            <i class="fas fa-award"></i>
                        </div>
                        <div>
                            <h4 class="font-bold">High Pass Rates</h4>
                            <p class="text-sm text-gray-600">Our students succeed</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-10 text-center">
                <p class="text-gray-600 mb-4">Not sure which package is right for you?</p>
                <a href="#" class="inline-block bg-navy-600 hover:bg-navy-700 text-white font-medium py-2 px-6 rounded-md">
                    Contact Us for Advice
                </a>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-navy-700 text-white mt-12 py-8">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <p>© 2025 Rijschool Vierkante Wielen. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>