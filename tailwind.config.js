import preline from 'preline/plugin';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/preline/dist/*.js",
  ],
  theme: {
    extend: {
      colors: {
        'primary': '#3b82f6',      // Blue
        'primary-foreground': '#ffffff',
        'secondary': '#64748b',     // Slate
        'secondary-foreground': '#ffffff',
        'success': '#22c55e',       // Green
        'success-foreground': '#ffffff',
        'danger': '#ef4444',        // Red
        'danger-foreground': '#ffffff',
        'warning': '#f59e0b',       // Amber
        'warning-foreground': '#ffffff',
        'info': '#06b6d4',          // Cyan
        'info-foreground': '#ffffff',
      }
    },
  },
  plugins: [
    preline,
  ],
}