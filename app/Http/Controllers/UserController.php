<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        $inputs["password"] = Hash::make(trim($request->password));
        $e = User::create($inputs);
        return response()->json([
            'data'=>$e,
            'mensaje'=>'Registrado con éxito.'
        ]);    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $e = User::find($id);
        if (isset($e)){
            return response()->json([
                'data'=>$e,
                'mensaje'=>'Encontrado con éxito.',
            ]);
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>'No esxiste.' ,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $e = User::find($id);

        if(isset($e)){
            $e->name = $request->name;
            $e->email = $request->email;
            $e->password = Hash::make($request->password);
            if ($e->save()){      
                return response()->json([
                    'data'=>$e,
                    'mensaje'=>'Actualizado con éxito.',
                ]);
            }else{
                return response()->json([
                    'error'=>true,
                    'mensaje'=>'No se se pudo actualizar.' ,
                ]);
            }
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>'No esxiste.' ,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $e = User::find($id);
        if (isset($e)){
            $res=User::destroy($id);
            if ($res){
                return response()->json([
                    // 'data'=>$e,
                    'mensaje'=>'Eliminado con éxito.',
                ], 201);
            }else{
                return response()->json([
                    'error'=>true,
                    'mensaje'=>'Error al eliminar el usuario.' ,
                ]);
            }
            
        }else{
            return response()->json([
                'data'=>$e,
                'mensaje'=>'No existe el usuario.',
            ]);
        }
    }
}
