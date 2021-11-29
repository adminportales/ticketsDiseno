<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TicketUploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function uploadItems(Request $request)
    {
        $imagen = $request->file('file');
        $nombreImagen = time() . ' ' . str_replace(',', ' ', $imagen->getClientOriginalName());
        $imagen->move(public_path('storage/items'), $nombreImagen);
        return response()->json(['correcto' => $nombreImagen]);
    }

    public function deleteItem(Request $request)
    {
        if ($request->ajax()) {
            $imagen = $request->get('imagen');
            if (File::exists('storage/items/' . $imagen)) {
                File::delete('storage/items/' . $imagen);
            }
            return response(['mensaje' => 'Imagen Eliminada', 'imagen' => $imagen], 200);
        }
    }

    public function uploadProducts(Request $request)
    {
        $imagen = $request->file('file');
        $nombreImagen = time() . ' ' . str_replace(',', ' ', $imagen->getClientOriginalName());
        $imagen->move(public_path('storage/products'), $nombreImagen);
        return response()->json(['correcto' => $nombreImagen]);
    }

    public function deleteProduct(Request $request)
    {
        if ($request->ajax()) {
            $imagen = $request->get('imagen');

            if (File::exists('storage/products/' . $imagen)) {
                File::delete('storage/products/' . $imagen);
            }
            return response(['mensaje' => 'Imagen Eliminada', 'imagen' => $imagen], 200);
        }
    }

    public function uploadLogos(Request $request)
    {
        $imagen = $request->file('file');
        $nombreImagen = time() . ' ' . str_replace(',', ' ', $imagen->getClientOriginalName());
        $imagen->move(public_path('storage/logos'), $nombreImagen);
        return response()->json(['correcto' => $nombreImagen]);
    }

    public function deleteLogo(Request $request)
    {
        if ($request->ajax()) {
            $imagen = $request->get('imagen');

            if (File::exists('storage/logos/' . $imagen)) {
                File::delete('storage/logos/' . $imagen);
            }
            return response(['mensaje' => 'Imagen Eliminada', 'imagen' => $imagen], 200);
        }
    }
}
