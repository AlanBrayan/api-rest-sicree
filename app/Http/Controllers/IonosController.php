<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ionos;

class IonosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $idEmpleado = $request->input('id_empleado');
    
        if (!$idEmpleado) {
            return response()->json(['error' => 'id_empleado es requerido'], 400);
        }
    
        return Ionos::where('id_empleado', $idEmpleado)->get();
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newIonos = new Ionos();
        $newIonos->email = $request->input('email');
        $newIonos->password = \Illuminate\Support\Facades\Hash::make($request->input('password'));
        
        // Asigna id_empleado directamente desde el request
        $newIonos->id_empleado = $request->input('id_empleado');
    
        $newIonos->api_token = \Illuminate\Support\Str::random(60);
    
        if ($request->hasFile('documento_pdf')) {
            $file = $request->file('documento_pdf');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('documents'), $fileName);
            $newIonos->documento_pdf = $fileName;
        }
    
        $newIonos->save();
    
        return response()->json($newIonos, 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Ionos $iono)
    {
        $ionos = $request->attributes->get('ionos');
        
        // Verifica si 'ionos' es un objeto antes de intentar acceder a id_empleado
        if (!$ionos || !isset($ionos->id_empleado)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        // Verifica si el id_empleado coincide
        if ($ionos->id_empleado !== $iono->id_empleado) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        return $iono;
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ionos $iono)
    {

        $ionos = $request->attributes->get('ionos');


        if ($ionos->id_empleado !== $iono->id_empleado) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }


        $validated = $request->validate([
            'email' => 'string|email|unique:email_ionos,email,' . $iono->id . ',id',
            'password' => 'nullable|string|min:6|confirmed',
            'documento_pdf' => 'nullable|mimes:pdf|max:2048',
        ]);


        if ($request->has('email')) {
            $iono->email = $validated['email'];
        }
        if ($request->has('password')) {
            $iono->password = Hash::make($validated['password']);
        }
        if ($request->hasFile('documento_pdf')) {
            $file = $request->file('documento_pdf');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('documents'), $fileName);
            $iono->documento_pdf = $fileName;
        }

        $iono->save();

        return $iono;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Ionos $iono)
    {

        $ionos = $request->attributes->get('ionos');


        if ($ionos->id_empleado !== $iono->id_empleado) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }


        $iono->delete();

        return response()->json(null, 204);
    }
}
