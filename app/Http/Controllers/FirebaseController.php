<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebaseController extends Controller
{
    public function index()
    {
        try {
            // 1. Hubungkan ke database Firestore
            $firestore = Firebase::firestore();
            $db = $firestore->database();

            // 2. Ambil semua data pengguna
            $usersRef = $db->collection('anggota');
            $documents = $usersRef->documents();

            $users = [];
            foreach ($documents as $document) {
                if ($document->exists()) {
                    $users[] = $document->data();
                }
            }

            // 3. Tampilkan data sebagai JSON (rapi dan mudah dibaca)
            return view('Tes', compact('users'));

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
