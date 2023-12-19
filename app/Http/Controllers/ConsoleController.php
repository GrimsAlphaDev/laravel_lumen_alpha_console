<?php

namespace App\Http\Controllers;

use App\Models\Console;
use Illuminate\Http\Request;

class ConsoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consoles = Console::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Data console berhasil ditampilkan',
            'data' => $consoles
        ], 200);
    }

    public function searchConsole(Request $request)
    {
        $consoles = Console::where('name', 'like', '%' . $request->keyword . '%')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Data console berhasil ditampilkan',
            'data' => $consoles
        ], 200);
    }

    public function getConsole($id)
    {
        $console = Console::find($id);
        if ($console) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data console berhasil ditampilkan',
                'data' => $console
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data console tidak ditemukan',
            ], 404);
        }
    }
}
