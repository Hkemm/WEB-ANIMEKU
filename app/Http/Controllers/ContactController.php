<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // 1. Cek apakah inputan user sudah benar
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // 2. Simpan ke Database
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        // 3. Beritahu JavaScript kalau sukses
        return response()->json(['success' => 'Pesan berhasil dikirim!']);
    }
}