<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArticuloFormRequest;
use App\Article;
use App\Category;
use DB;

class ArticleController extends Controller
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
            $articulos=DB::table('articles as a')
            ->join('categories as c','a.category_id','=','c.id')
            ->select('a.id','a.name','a.code','a.stock','c.name as categoria','a.description','a.image','a.status')
            ->where('a.name','LIKE','%'.$query.'%')
            ->orwhere('a.code','LIKE','%'.$query.'%')
            ->orderBy('a.id','desc')
            ->paginate(7);
            return view('almacen.articulo.index',["articulos"=>$articulos,"searchText"=>$query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = DB::table('categories')->where('condition','=','1')->get();
        return view("almacen.articulo.create",["categorias"=>$categorias]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticuloFormRequest $request)
    {
        $articulo = new Article;
        $articulo->category_id = $request->category_id;
        $articulo->code = $request->code;
        $articulo->name = $request->name;
        $articulo->stock = $request->stock;
        $articulo->description = $request->description;
        $articulo->status = 'Activo';

        $file = $request->file('image');
        $path = public_path() . '/images/articles';
        $fileName = uniqid() . $file->getClientOriginalName();
        $moved = $file->move($path, $fileName);
        $articulo->image = $fileName;

        $articulo->save();
        
        return redirect('almacen/articulo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("almacen.articulo.show",["articulo"=>Article::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $articulo = Article::findOrFail($id);
        $categorias = DB::table('categories')->where('condition','=','1')->get();
        return view("almacen.articulo.edit",["articulo"=>$articulo, "categorias"=>$categorias]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticuloFormRequest $request, $id)
    {
        $articulo = Article::findOrFail($id);
        $articulo->category_id = $request->category_id;
        $articulo->code = $request->code;
        $articulo->name = $request->name;
        $articulo->stock = $request->stock;
        $articulo->description = $request->description;

        if (empty($request->file('image'))) {
            $articulo->image = $articulo->image;
        }
        else {
            unlink(public_path() . '/images/articles/' . $articulo->image);
            $file = $request->file('image');
            $path = public_path() . '/images/articles';
            $fileName = uniqid() . $file->getClientOriginalName();
            $moved = $file->move($path, $fileName);
            $articulo->image = $fileName;
        } 
        
        $articulo->save();
        
        return redirect('almacen/articulo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $articulo = Article::findOrFail($id);
        $articulo->status='Inactivo';
        $articulo->update();
        return redirect('almacen/articulo');
    }
}
