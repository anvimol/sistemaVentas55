
@extends ('layouts.admin')
@section ('content')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Categoría: {{ $categoria->name }}</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			{!!Form::model($categoria,['method'=>'PATCH','route'=>['categoria.update',$categoria->id]])!!}
            <div class="form-group">
            	<label for="name">Nombre</label>
            	<input type="text" name="name" class="form-control" value="{{$categoria->name}}" placeholder="Nombre...">
            </div>
            <div class="form-group">
            	<label for="description">Descripción</label>
            	<input type="text" name="description" class="form-control" value="{{$categoria->description}}" placeholder="Descripción...">
            </div>
            <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>

			{!!Form::close()!!}		
            
		</div>
	</div>
@endsection