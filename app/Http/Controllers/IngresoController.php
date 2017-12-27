<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\IngresoFormRequest;
use App\Ingreso;
use App\DetalleIngreso;
use DB;

use Carbon\Carbon; //Para poder utilizar el formato fecha/hora de nuestra zona horaria
use Response;
use Illuminate\Support\Collection;

class IngresoController extends Controller
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
    public function index(Request $request)
    {
        if ($request)
        {
            $query=trim($request->get('searchText'));
            $ingresos = DB::table('ingresos as i')
            ->join('people as p','i.idproveedor','=','p.id')
            ->join('detalle_ingresos as di','i.id','=','di.idingreso')
            ->select('i.id','i.fecha_hora','p.name','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precio_compra) as total'))
            ->where('i.num_comprobante','LIKE','%' . $query . '%')
            ->orderBy('i.id','desc')
            ->groupBy('i.id','i.fecha_hora','p.name','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado')
            ->paginate(7);
            return view('compras.ingreso.index',["ingresos"=>$ingresos,"searchText"=>$query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $personas = DB::table('people')->where('type_person','=','Proveedor')->get();
        $articulos = DB::table('articles as art')
            ->select(DB::raw('CONCAT(art.code, " ", art.name) as articulo'),'art.id','art.status')
            ->where('art.status','=','Activo')
            ->get();
        return view("compras.ingreso.create",['personas'=>$personas,'articulos'=>$articulos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IngresoFormRequest $request)
    {
        try {
            DB::beginTransaction();
            $ingreso = new Ingreso;
            $ingreso->idproveedor = $request->get('idproveedor');
            $ingreso->tipo_comprobante = $request->get('tipo_comprobante');
            $ingreso->serie_comprobante = $request->get('serie_comprobante');
            $ingreso->num_comprobante = $request->get('num_comprobante');
            $mytime = Carbon::now('Europe/Madrid');
            $ingreso->fecha_hora = $mytime->toDateTimeString();
            $ingreso->impuesto = '18';
            $ingreso->estado = 'A';
            $ingreso->save();

            $idarticulo = $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $precio_compra = $request->get('precio_compra');
            $precio_venta = $request->get('precio_venta');

            $cont = 0;

            while ($cont < count($idarticulo)) {
                $detalle = new DetalleIngreso();
                $detalle->idingreso = $ingreso->id;
                $detalle->idarticulo = $idarticulo[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio_compra = $precio_compra[$cont];
                $detalle->precio_venta = $precio_venta[$cont];
                $detalle->save();
                $cont = $cont + 1;
            }

            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollback();
        }

        return Redirect::to('compras/ingreso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ingreso = DB::table('ingresos as i')
            ->join('people as p','i.idproveedor','=','p.id')
            ->join('detalle_ingresos as di','i.id','=','di.idingreso')
            ->select('i.id','i.fecha_hora','p.name','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precio_compra) as total'))
            ->where('i.id', '=', $id)
            ->groupBy('i.id','i.fecha_hora','p.name','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado')
            ->first();

        $detalles = DB::table('detalle_ingresos as d')
            ->join('articles as a','d.idarticulo','=','a.id')
            ->select('a.name as articulo','d.cantidad','d.precio_compra','d.precio_venta')
            ->where('d.idingreso','=',$id)
            ->get();

        return view('compras.ingreso.show',['ingreso'=>$ingreso,'detalles'=>$detalles]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->estado = 'C';
        $ingreso->update();
        return Redirect::to('compras/ingreso');
    }
}
