@extends ('layouts.admin')
@section ('content')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Articulo</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif
		</div>
	</div>

	{!!Form::open(array('url'=>'almacen/articulo','method'=>'POST','autocomplete'=>'off','files'=>'true'))!!}
    {{Form::token()}}
    <div class="row">
    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    		<div class="form-group">
            	<label for="name">Nombre</label>
            	<input type="text" name="name" required value="{{old('nombre')}}" class="form-control" placeholder="Nombre...">
            </div>
    	</div>
    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    		<div class="form-group">
				<label for="category_id">Categoría</label>
				<select name="category_id" class="form-control">
					@foreach ($categorias as $cat)
						<option value="{{$cat->id}}">{{$cat->name}}</option>
					@endforeach
				</select>
    		</div>
    	</div>
    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    		<div class="form-group">
            	<label for="code">Código</label>
            	<input type="text" name="code" required value="{{old('codigo')}}" class="form-control" placeholder="Código del articulo...">
            </div>
    	</div>
    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    		<div class="form-group">
            	<label for="stock">Stock</label>
            	<input type="text" name="stock" required value="{{old('stock')}}" class="form-control" placeholder="Stock del articulo">
            </div>
    	</div>
    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    		<div class="form-group">
            	<label for="description">Descripción</label>
            	<input type="text" name="description" value="{{old('descripcion')}}" class="form-control" placeholder="Descripción del articulo">
            </div>
    	</div>
    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    		<div class="form-group">
            	<label for="image">Imagen</label>
            	<input type="file" name="image" class="form-control">
            </div>
    	</div>
    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    		<div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
    	</div>
    </div>

	{!!Form::close()!!}		

@endsection