<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="p-8">

    <h1 class="text-3xl font-bold underline mb-6">
        Hello world!
    </h1>

    <!-- Actual Preline Alerts -->
    <div class="flex flex-col gap-y-4">
        <!-- Primary Alert -->
        <div class="bg-blue-100 border border-blue-200 text-sm text-blue-800 rounded-lg p-4" role="alert">
            <span class="font-bold">Primary</span> alert! You should check in on some of those fields below.
        </div>

        <!-- Success Alert -->
        <div class="bg-green-100 border border-green-200 text-sm text-green-800 rounded-lg p-4" role="alert">
            <span class="font-bold">Success</span> alert! You should check in on some of those fields below.
        </div>

        <!-- Danger Alert -->
        <div class="bg-red-100 border border-red-200 text-sm text-red-800 rounded-lg p-4" role="alert">
            <span class="font-bold">Danger</span> alert! You should check in on some of those fields below.
        </div>

        <!-- Warning Alert -->
        <div class="bg-yellow-100 border border-yellow-200 text-sm text-yellow-800 rounded-lg p-4" role="alert">
            <span class="font-bold">Warning</span> alert! You should check in on some of those fields below.
        </div>

        <!-- With Dismiss Button -->
        <div class="bg-teal-100 border border-teal-200 text-sm text-teal-800 rounded-lg p-4" role="alert">
            <span class="font-bold">Dismissible</span> alert!
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-teal-100 text-teal-500 rounded-lg focus:ring-2 focus:ring-teal-400 p-1.5 hover:bg-teal-200 inline-flex items-center justify-center h-8 w-8"
                data-hs-remove-element=".alert">
                <span class="sr-only">Dismiss</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    </div>

</body>

</html>