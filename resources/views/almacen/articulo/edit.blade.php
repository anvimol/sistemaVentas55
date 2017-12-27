@extends ('layouts.admin')
@section ('content')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Articulo: {{ $articulo->name }}</h3>
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

	{!!Form::model($articulo,['method'=>'PATCH','route'=>['articulo.update',$articulo->id],'files'=>'true'])!!}
    
    <div class="row">
    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    		<div class="form-group">
            	<label for="name">Nombre</label>
            	<input type="text" name="name" required value="{{$articulo->name}}" class="form-control">
            </div>
    	</div>
    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    		<div class="form-group">
				<label for="category_id">Categoría</label>
				<select name="category_id" class="form-control">
					@foreach ($categorias as $cat)
						@if ($cat->id == $articulo->category_id)
						<option value="{{$cat->id}}" selected>{{$cat->name}}</option>
						@else
						<option value="{{$cat->id}}">{{$cat->name}}</option>
						@endif
					@endforeach
				</select>
    		</div>
    	</div>
    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    		<div class="form-group">
            	<label for="codigo">Código</label>
            	<input type="text" name="code" required value="{{$articulo->code}}" class="form-control">
            </div>
    	</div>
    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    		<div class="form-group">
            	<label for="stock">Stock</label>
            	<input type="text" name="stock" required value="{{$articulo->stock}}" class="form-control">
            </div>
    	</div>
    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    		<div class="form-group">
            	<label for="description">Descripción</label>
            	<input type="text" name="description" value="{{$articulo->description}}" class="form-control" placeholder="Descripción del articulo">
            </div>
    	</div>
    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    		<div class="form-group">
            	<label for="image">Imagen</label>
            	<input type="file" name="image" class="form-control">
            	@if ($articulo->image != "")
					<img src="{{asset('images/articles/'.$articulo->image)}}" height="300px" width="350px">
                @else
                    <h3>No hay imagenes disponibles para este articulo</h3>
            	@endif
            </div>
    	</div>
    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    		<div class="form-group">
            	<button class="btn btn-primary" type="submit">Modificar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
    	</div>
    </div>
	{!!Form::close()!!}		

@endsection