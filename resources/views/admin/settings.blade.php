{{-- resources/views/admin/settings.blade.php --}}
@extends('admin.layout')

@section('title', 'Settings - SUMACC Admin')
@section('page-title', 'Profile Settings')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded-lg shadow p-6">
    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 border border-green-200 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 px-4 py-3 bg-red-100 border border-red-200 text-red-800 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
            <input
                type="text"
                name="first_name"
                id="first_name"
                value="{{ old('first_name', $admin->first_name) }}"
                required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
        </div>

        <div>
            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input
                type="text"
                name="last_name"
                id="last_name"
                value="{{ old('last_name', $admin->last_name) }}"
                required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                value="{{ old('email', $admin->email) }}"
                required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">New Password <span class="text-gray-500">(leave blank to keep current)</span></label>
            <input
                type="password"
                name="password"
                id="password"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
        </div>

        <div class="pt-6 border-t border-gray-200">
            <button
                type="submit"
                class="w-full inline-flex justify-center py-2 px-4 bg-blue-600 text-white font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection