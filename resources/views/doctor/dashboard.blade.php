@extends('layouts.admin')

@section('title', 'Doctor Dashboard')

@section('content')
<div class="flex flex-col">
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-neutral-800 dark:border-neutral-700">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-neutral-200">
      Welcome, {{ auth()->user()->username ?? 'Doctor' }}
    </h1>
    <br>
    <h3 class="text-xl font-semibold text-gray-600 dark:text-neutral-400">
      ({{ auth()->user()->role ?? 'dokter' }})
    </h3>
    <hr class="my-6 border-gray-200 dark:border-neutral-700">
    <p class="text-gray-500 dark:text-neutral-500">
      Access your patients, schedules, and medical records from here.
    </p>
  </div>
</div>
@endsection
