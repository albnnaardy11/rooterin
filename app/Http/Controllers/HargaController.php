<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;

class HargaController extends Controller
{
    public function index()
    {
        SEOTools::setTitle('Daftar Biaya & Harga Jasa Saluran Mampet 2026 - RooterIN');
        SEOTools::setDescription('Cek daftar biaya resmi jasa saluran mampet, wastafel cuci piring tersumbat, toilet mampet, cuci toren air bersih, dan instalasi pipa plumbing. Garansi 30 hari.');
        SEOTools::opengraph()->setUrl(url('/harga'));
        SEOTools::setCanonical(url('/harga'));

        $services = Service::where('is_active', true)->get();
        return view('harga', compact('services'));
    }
}
