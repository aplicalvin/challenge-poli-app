import './bootstrap';
import 'preline';

// Initialize Preline when DOM is fully loaded
document.addEventListener('DOMContentLoaded', function () {
  // Initialize all Preline components
  if (window.HSStaticMethods) {
    window.HSStaticMethods.autoInit();
    console.log('Preline initialized via HSStaticMethods');
  }

  // Initialize overlays specifically
  if (window.HSOverlay) {
    window.HSOverlay.autoInit();
    console.log('HSOverlay initialized');
  }

  console.log('Preline initialization complete');
});

console.log('app.js loaded - Preline imported');