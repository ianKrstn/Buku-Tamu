<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tamu;
use App\Models\Kategori;
use App\Models\TamuKategori;

class MainController extends Controller
{
    public function index(){
        $tamus=Tamu::get();
        $kategoris=Kategori::get();
        return view('main', compact('tamus', 'kategoris'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email:dns',
            'timestamp' => 'required',
            'comment' => 'required'
        ]);

        $tamu = Tamu::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'timestamp' => $request['timestamp'],
            'comment' => $request['comment']
        ]);
        
        if ($request->has('kategori')) {
            foreach ($request['kategori'] as $kategoriNumber) {
                TamuKategori::create([
                    'tamus_number' => $tamu->number,
                    'kategoris_number' => (int) $kategoriNumber
                ]);
            }
        }

        return redirect('/')->with('status', 'Guest Information Has Been Saved Successfully!');
    }

    public function update(Request $request, Tamu $tamu){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email:dns',
            'timestamp' => 'required',
            'comment' => 'required'
        ]);
        
        $tamu->name = $request['name'];
        $tamu->email = $request['email'];
        $tamu->timestamp = $request['timestamp'];
        $tamu->comment = $request['comment'];
        $tamu->save();
        
        TamuKategori::where('tamus_number', $tamu->number)->delete();

        if ($request->has('kategori')) {
            foreach ($request['kategori'] as $kategoriNumber) {
                BarangKategori::create([
                    'tamus_number' => $tamu->number,
                    'kategoris_number' => (int) $kategoriNumber
                ]);
            }
        }

        return redirect('/')->with('status', 'Guest Information Has Been Successfully Updated!');
    }

    public function destroy(Tamu $tamu){
        TamuKategori::where('tamus_number', $tamu->number)->delete();
        $tamu->delete();

        return redirect('/')->with('status', 'Guest Information Has Been Successfully Deleted!');
    }
}
