<?php

if (! function_exists('rupiah')) {
    /**
     * Format angka ke Rupiah tanpa desimal.
     * rupiah(50000)  → "Rp 50.000"
     */
    function rupiah(int|float|string|null $amount): string
    {
        return 'Rp ' . number_format((float) $amount, 0, ',', '.');
    }
}