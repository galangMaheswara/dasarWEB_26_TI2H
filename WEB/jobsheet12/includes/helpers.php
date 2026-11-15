<?php
// Jobsheet 11: fungsi bantu untuk mencegah XSS.
// Semua data dari database / $_GET / $_POST yang dicetak ke HTML
// wajib dibungkus e() supaya karakter < > & " ' berubah jadi entity.
function e($value)
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}