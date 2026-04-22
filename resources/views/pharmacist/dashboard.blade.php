@extends('layouts.admin')

@section('title', 'Pharmacist Dashboard')

@section('content')
<div class="flex flex-col">
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-neutral-800 dark:border-neutral-700">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-neutral-200">
      Welcome, {{ auth()->user()->username ?? 'Pharmacist' }}
    </h1>
    <br>
    <h3 class="text-xl font-semibold text-gray-600 dark:text-neutral-400">
      ({{ auth()->user()->role ?? 'apoteker' }})
    </h3>
    <hr class="my-6 border-gray-200 dark:border-neutral-700">
    <p class="text-gray-500 dark:text-neutral-500">
      Manage inventory, prescriptions, and medicine distribution.
    </p>
  </div>
</div>
@endsection
