import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                darkBackground: "#161D31", // Main background
                darkSurface: "#283046", // Sidebar & navbar
                darkCard: "#2F3349", // Cards or containers
                darkText: "#B4B7BD", // Primary text
                darkBorder: "#3B4253", // Borders
                darkPrimary: "#7367F0", // Main accent
                darkPrimaryHover: "#6D5BDE", // Hover accent
                darkSecondary: "#82868B",
                darkSuccess: "#28C76F",
                darkWarning: "#FF9F43",
                darkDanger: "#EA5455",
                darkSidebarHover: "#3B4B68", // Hover for sidebar items
            },
        },
    },
    plugins: [],
};
