<div id="toast-container" class="fixed bottom-5 end-5 space-y-3 z-[100]"></div>

<template id="toast-template">
  <div class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert">
    <div class="flex p-4">
      <div class="shrink-0" id="toast-icon-container">
        <!-- Icons injected via JS -->
      </div>
      <div class="ms-3">
        <p class="text-sm text-gray-700 dark:text-neutral-400" id="toast-message">
          <!-- Message injected via JS -->
        </p>
      </div>
    </div>
  </div>
</template>
