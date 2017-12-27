<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryFormRequest;
use DB;

class CategoryController extends Controller
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
            $query = trim($request->get('searchText'));
            $categorias = DB::table('categories')->where('name','LIKE','%' . $query . '%')
            ->where('condition','=','1')
            ->orderBy('id','desc')
            ->paginate(7);
            return view('almacen.categoria.index', ["categorias" => $categorias, "searchText" => $query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("almacen.categoria.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryFormRequest $request)
    {
        $categoria = new Category;
        $categoria->name = $request->get('name');
        $categoria->description = $request->get('description');
        $categoria->condition = '1';
        $categoria->save();
        return redirect('almacen/categoria');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("almacen.categoria.show",["categoria"=>Category::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view("almacen.categoria.edit",["categoria"=>Category::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryFormRequest $request, $id)
    {
        $categoria = Category::findOrFail($id);
        $categoria->name = $request->get('name');
        $categoria->description = $request->get('description');
        $categoria->update();
        return redirect('almacen/categoria');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = Category::findOrFail($id);
        $categoria->condition = '0';
        $categoria->update();
        return redirect('almacen/categoria');
    }
}
