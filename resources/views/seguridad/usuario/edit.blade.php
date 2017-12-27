
@extends ('layouts.admin')
@section ('content')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Usuario: {{ $usuario->name }}</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			{!!Form::model($usuario,['method'=>'PATCH','route'=>['usuario.update',$usuario->id]])!!}
            <div class="form-group">
            	<label for="name">Nombre</label>
            	<input type="text" name="name" class="form-control" value="{{$usuario->name}}" placeholder="Nombre...">
            </div>
            <div class="form-group">
            	<label for="email">Email</label>
            	<input type="text" name="email" class="form-control" value="{{$usuario->email}}" placeholder="Descripción...">
            </div>
            <div class="form-group">
            	<label for="password">Password</label>
            	<input type="password" name="password" class="form-control" placeholder="Password...">
            </div>
            <div class="form-group">
            	<label for="email">Email</label>
            	<input type="password" name="password_confirmation" class="form-control" placeholder="Descripción...">
            </div>
            <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>

			{!!Form::close()!!}		
            
		</div>
	</div>
@endsection