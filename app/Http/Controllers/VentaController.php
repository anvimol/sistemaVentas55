<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\VentaFormRequest;
use App\Venta;
use App\DetalleVenta;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class VentaController extends Controller
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
            $ventas = DB::table('ventas as v')
            ->join('people as p','v.idcliente','=','p.id')
            ->join('detalle_ventas as dv','v.id','=','dv.idventas')
            ->select('v.id','v.fecha_hora','p.name','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
            ->where('v.num_comprobante','LIKE','%' . $query . '%')
            ->orderBy('v.id','desc')
            ->groupBy('v.id','v.fecha_hora','p.name','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
            ->paginate(7);
            return view('ventas.venta.index',["ventas"=>$ventas,"searchText"=>$query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $personas = DB::table('people')->where('type_person','=','Cliente')->get();
        $articulos = DB::table('articles as art')
        	->join('detalle_ingresos as di','art.id','=','di.idarticulo')
            ->select(DB::raw('CONCAT(art.code, " ", art.name) as articulo'),'art.id','art.stock',DB::raw('avg(di.precio_venta) as precio_promedio'))
            ->where('art.status','=','Activo')
            ->where('art.stock','>','0')
            ->groupBy('articulo','art.id','art.stock')
            ->get();
        return view("ventas.venta.create",['personas'=>$personas,'articulos'=>$articulos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VentaFormRequest $request)
    {
       try {
            DB::beginTransaction();
            $venta = new Venta;
            $venta->idcliente = $request->get('idcliente');
            $venta->tipo_comprobante = $request->get('tipo_comprobante');
            $venta->serie_comprobante = $request->get('serie_comprobante');
            $venta->num_comprobante = $request->get('num_comprobante');
            $venta->total_venta = $request->get('total_venta');

            $mytime = Carbon::now('Europe/Madrid');
            $venta->fecha_hora = $mytime->toDateTimeString();
            $venta->impuesto = '18';
            $venta->estado = 'A';
            $venta->save();

            $idarticulo = $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $descuento = $request->get('descuento');
            $precio_venta = $request->get('precio_venta');

            $cont = 0;

            while ($cont < count($idarticulo)) {
                $detalle = new DetalleVenta();
                $detalle->idventas = $venta->id;
                $detalle->idarticulo = $idarticulo[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->descuento = $descuento[$cont];
                $detalle->precio_venta = $precio_venta[$cont];
                $detalle->save();
                $cont = $cont + 1;
            }

            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollback();
        }

        return Redirect::to('ventas/venta');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $venta = DB::table('ventas as v')
            ->join('people as p','v.idcliente','=','p.id')
            ->join('detalle_ventas as dv','v.id','=','dv.idventas')
            ->select('v.id','v.fecha_hora','p.name','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
            ->where('v.id', '=', $id)
            ->first();

        $detalles = DB::table('detalle_ventas as d')
            ->join('articles as a','d.idarticulo','=','a.id')
            ->select('a.name as articulo','d.cantidad','d.descuento','d.precio_venta')
            ->where('d.idventas','=',$id)
            ->get();

        return view('ventas.venta.show',['venta'=>$venta,'detalles'=>$detalles]);
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
        $venta = Venta::findOrFail($id);
        $venta->estado = 'C';
        $venta->update();
        return Redirect::to('ventas/venta');
    }
}
