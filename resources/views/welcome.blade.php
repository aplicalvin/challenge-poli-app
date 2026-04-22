@extends('layouts.guest')

@section('title', 'Welcome to Poli App - Smart Healthcare Management')

@section('content')
<!-- Hero Section -->
<div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-24">
  <div class="grid md:grid-cols-2 gap-4 md:gap-8 xl:gap-20 items-center">
    <div>
      <h1 class="block text-3xl font-bold text-gray-800 sm:text-4xl lg:text-6xl lg:leading-tight dark:text-white">
        Smart Healthcare Management with <span class="text-blue-600">Poli App</span>
      </h1>
      <p class="mt-3 text-lg text-gray-800 dark:text-neutral-400">
        Empowering clinics and patients with seamless digital experiences. Manage appointments, prescriptions, and medical records in one unified platform.
      </p>

      <!-- Buttons -->
      <div class="mt-7 grid gap-3 w-full sm:inline-flex">
        <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" href="/login">
          Get started
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </a>
        <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" href="#">
          Contact sales team
        </a>
      </div>
      <!-- End Buttons -->
    </div>

    <div class="relative ms-4">
      <img class="w-full rounded-md shadow-xl" src="https://images.unsplash.com/photo-1576091160550-2173dad99901?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80" alt="Healthcare Image">
      
      <!-- SVG Element -->
      <div class="absolute inset-0 -z-[1] bg-gradient-to-tr from-gray-200 via-white to-white size-full rounded-md dark:from-neutral-800 dark:via-neutral-900 dark:to-neutral-900"></div>
    </div>
  </div>
</div>
<!-- End Hero -->

<!-- Features section -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Card -->
    <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
      <div class="h-52 flex flex-col justify-center items-center bg-blue-600 rounded-t-xl">
        <svg class="size-12 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
      </div>
      <div class="p-4 md:p-6">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white">
          Easy Appointment
        </h3>
        <p class="mt-3 text-gray-500 dark:text-neutral-500">
          Patients can book appointments with their preferred doctors and polyclinics in just a few clicks.
        </p>
      </div>
    </div>
    <!-- End Card -->

    <!-- Card -->
    <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
      <div class="h-52 flex flex-col justify-center items-center bg-teal-500 rounded-t-xl">
        <svg class="size-12 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      </div>
      <div class="p-4 md:p-6">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white">
          Doctor & Staff Portal
        </h3>
        <p class="mt-3 text-gray-500 dark:text-neutral-500">
          Dedicated dashboards for doctors, pharmacists, and cashiers to manage patient care efficiently.
        </p>
      </div>
    </div>
    <!-- End Card -->

    <!-- Card -->
    <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
      <div class="h-52 flex flex-col justify-center items-center bg-amber-500 rounded-t-xl">
        <svg class="size-12 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
      </div>
      <div class="p-4 md:p-6">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white">
          Digital Prescriptions
        </h3>
        <p class="mt-3 text-gray-500 dark:text-neutral-500">
          Seamless pharmacy integration for instant prescription fulfillment and inventory tracking.
        </p>
      </div>
    </div>
    <!-- End Card -->
  </div>
</div>
<!-- End Features -->

<!-- Stats -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
  <div class="grid gap-6 grid-cols-2 sm:grid-cols-4 lg:grid-cols-4">
    <div>
      <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Active Polys</h4>
      <p class="mt-2 sm:mt-3 text-4xl sm:text-6xl font-bold text-blue-600">10+</p>
      <p class="mt-1 text-gray-500 dark:text-neutral-500">Available services</p>
    </div>
    <div>
      <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Doctors</h4>
      <p class="mt-2 sm:mt-3 text-4xl sm:text-6xl font-bold text-blue-600">50+</p>
      <p class="mt-1 text-gray-500 dark:text-neutral-500">Medical specialists</p>
    </div>
    <div>
      <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Patients</h4>
      <p class="mt-2 sm:mt-3 text-4xl sm:text-6xl font-bold text-blue-600">2k+</p>
      <p class="mt-1 text-gray-500 dark:text-neutral-500">Happy users</p>
    </div>
    <div>
      <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Uptime</h4>
      <p class="mt-2 sm:mt-3 text-4xl sm:text-6xl font-bold text-blue-600">99.9%</p>
      <p class="mt-1 text-gray-500 dark:text-neutral-500">Reliable platform</p>
    </div>
  </div>
</div>
<!-- End Stats -->

<!-- CTA -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
  <div class="bg-blue-600 rounded-xl p-8 md:p-12 lg:p-16 text-center">
    <h2 class="text-3xl font-bold text-white md:text-4xl">Ready to transform your clinic?</h2>
    <p class="mt-4 text-blue-100 text-lg">Join hundreds of healthcare providers already using Poli App.</p>
    <div class="mt-8">
      <a class="py-3 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-white text-blue-600 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" href="/login">
        Get started for free
      </a>
    </div>
  </div>
</div>
<!-- End CTA -->
@endsection