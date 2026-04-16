<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="p-8">
    <h1 class="text-3xl font-bold underline text-blue-600">
        Hello world! Tailwind is working!
    </h1>

    <!-- Test button with Preline class -->
    <div>
        <!-- Button Group -->
        <div class="inline-flex flex-wrap gap-2">
            <button type="button"
                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-line-8 text-foreground hover:border-primary-hover hover:text-primary-hover focus:outline-hidden focus:border-primary-focus focus:text-primary-focus disabled:opacity-50 disabled:pointer-events-none">
                Button
            </button>
            <button type="button"
                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-line-5 text-muted-foreground-1 hover:border-line-8 hover:text-foreground focus:outline-hidden focus:border-line-8 focus:text-foreground disabled:opacity-50 disabled:pointer-events-none">
                Button
            </button>
            <button type="button"
                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-teal-500 text-teal-500 hover:border-teal-400 hover:text-teal-400 focus:outline-hidden focus:border-teal-400 focus:text-teal-400 disabled:opacity-50 disabled:pointer-events-none">
                Button
            </button>
            <button type="button"
                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-primary text-primary hover:border-primary-hover hover:text-primary-hover focus:outline-hidden focus:border-primary-focus focus:text-primary-focus disabled:opacity-50 disabled:pointer-events-none">
                Button
            </button>
            <button type="button"
                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-red-500 text-red-500 hover:border-red-400 hover:text-red-400 focus:outline-hidden focus:border-red-400 focus:text-red-400 disabled:opacity-50 disabled:pointer-events-none">
                Button
            </button>
            <button type="button"
                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-yellow-500 text-yellow-500 hover:border-yellow-400 focus:outline-hidden focus:border-yellow-400 focus:text-yellow-400 disabled:opacity-50 disabled:pointer-events-none">
                Button
            </button>
            <button type="button"
                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-line-inverse text-foreground-inverse hover:border-line-inverse/70 hover:text-foreground-inverse/70 focus:outline-hidden focus:border-line-inverse/70 focus:text-foreground-inverse/70 disabled:opacity-50 disabled:pointer-events-none">
                Button
            </button>
        </div>
        <!-- End Button Group -->
    </div>
    <div>
        <ol class="flex items-center whitespace-nowrap ">
            <li class="inline-flex items-center">
                <a class="flex items-center text-sm text-muted-foreground-1 hover:text-primary-focus focus:outline-hidden focus:text-primary-focus"
                    href="#">
                    Home
                </a>
                <svg class="shrink-0 mx-2 size-4 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </li>
            <li class="inline-flex items-center">
                <a class="flex items-center text-sm text-muted-foreground-1 hover:text-primary-focus focus:outline-hidden focus:text-primary-focus"
                    href="#">
                    App Center
                    <svg class="shrink-0 mx-2 size-4 text-muted-foreground" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </a>
            </li>
            <li class="inline-flex items-center text-sm font-semibold text-foreground truncate" aria-current="page">
                Application
            </li>
        </ol>
    </div>
</body>

</html>