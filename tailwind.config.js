import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    // File-file yang dipindai Tailwind untuk mencari class yang dipakai.
    // Class yang tidak dipakai di file ini tidak ikut ke CSS akhir (supaya ringan).
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            // Font: sans untuk teks biasa, serif untuk judul & nama parfum
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['"Playfair Display"', ...defaultTheme.fontFamily.serif],
            },

            // Palet warna Lucky Store (diambil dari logo)
            colors: {
                onyx: '#0E0E0F',       // latar utama website pelanggan
                charcoal: {
                    DEFAULT: '#1C1C1E', // kartu / panel
                    light: '#26262A',   // latar gambar, input
                    line: '#3A3220',    // garis tepi bernuansa emas gelap
                },
                gold: {
                    DEFAULT: '#D99E1E', // warna logo: tombol utama, badge
                    light: '#F2C35B',   // harga, efek hover
                    dark: '#A87812',    // tombol saat ditekan
                    ink: '#1A1204',     // teks di atas latar emas
                },
                silver: '#C9C9CC',     // teks sekunder di latar gelap
                ivory: '#FAF6EC',      // teks utama di latar gelap
            },
        },
    },

    plugins: [forms],
};