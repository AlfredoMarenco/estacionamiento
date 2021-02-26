<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $impresoras = $this->getPrinter();
        $configurations = Configuration::find(1);
        return view('configurations.index', compact('configurations','impresoras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $configurations = Configuration::findOrFail($id);
        //dd($configurations);
        $configurations->printer = $request->printer;
        $configurations->company = $request->company;
        $configurations->price_hours = $request->price_hours;
        $configurations->quarter1 = $request->quarter1;
        $configurations->quarter2 = $request->quarter2;
        $configurations->quarter3 = $request->quarter3;
        $configurations->quarter4 = $request->quarter4;
        $configurations->rules = $request->rules;

        $configurations->update();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getPrinter()
    {
        $ruta_powershell = 'c:\Windows\System32\WindowsPowerShell\v1.0\powershell.exe'; #Necesitamos el powershell
        $opciones_para_ejecutar_comando = "-c"; #Ejecutamos el powershell y necesitamos el "-c" para decirle que ejecutaremos un comando
        $espacio = " "; #ayudante para concatenar
        $comillas = '"'; #ayudante para concatenar
        $comando = 'get-WmiObject -class Win32_printer |ft shared, name'; #Comando de powershell para obtener lista de impresoras
        $delimitador = "True"; #Queremos solamente aquellas en donde la línea comienza con "True"
        $lista_de_impresoras = array(); #Aquí pondremos las impresoras

        exec(
            $ruta_powershell
                . $espacio
                . $opciones_para_ejecutar_comando
                . $espacio
                . $comillas
                . $comando
                . $comillas,
            $resultado,
            $codigo_salida
        );
        if ($codigo_salida === 0) {
            if (is_array($resultado)) {
                #Omitir los primeros 3 datos del arreglo, pues son el encabezado
                for ($x = 3; $x < count($resultado); $x++) {
                    $impresora = trim($resultado[$x]);
                    # Ignorar los espacios en blanco o líneas vacías
                    if (strlen($impresora) > 0) {
                        # Comprobar si comienzan con "True", para ello usamos el delimitador declarado arriba
                        //if (strpos($impresora, $delimitador) === 0) {
                            #Limpiar el nombre
                            $nombre_limpio = substr($impresora, strlen($delimitador) + 1, strlen($impresora) - strlen($delimitador) + 1);
                            #Finalmente agregarla al array
                            array_push($lista_de_impresoras,
                            [
                            'name' =>  $nombre_limpio
                            ]);
                        //}
                    }
                }
            }
            echo "<pre>";
            //dd($lista_de_impresoras);
            echo "</pre>";
            return $lista_de_impresoras;
        } else {
            echo "Error al ejecutar el comando.";
        }
    }
}
