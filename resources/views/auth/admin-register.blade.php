<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Register | Site Sync Attendance System</title>

     <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <div style="display: flex; justify-content: center;">
                <img src="{{asset('logo.png')}}" width="80" height="80" alt="">
            </div>
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Site Sync | Admin Login</h2>

            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('admin.register') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Organization Name</label>
                    <input type="text" name="name" id="name" required
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                        value="{{ old('name') }}">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                        value="{{ old('email') }}">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Register
                </button>

                <div class="mt-4 text-center">
                    <a href="{{ route('admin.login') }}" class="text-sm text-gray-600 hover:text-gray-800">
                        Already have an account? <span style="text-decoration: underline;">Login</span>
                    </a>
                </div>
            </form>



        </div>
    </div>
</body>

</html>