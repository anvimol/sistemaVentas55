@extends ('layouts.admin')
@section ('content')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Proveedor: {{ $persona->nombre }}</h3>
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

	{!!Form::model($persona,['method'=>'PATCH','route'=>['proveedor.update',$persona->id]])!!}
    {{Form::token()}}
    
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" required value="{{$persona->name}}" class="form-control" placeholder="Nombre...">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="direction">Direccion</label>
                <input type="text" name="direction" value="{{$persona->direction}}" class="form-control" placeholder="Direccion...">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="type_document">Documento</label>
                <select name="type_document" class="form-control">
                    @if ($persona->type_document == 'DNI')
                        <option value="DNI" selected>DNI</option>
                        <option value="RUC">RUC</option>
                        <option value="PAS">PAS</option>
                    @elseif ($persona->type_document == 'RUC')
                        <option value="DNI">DNI</option>
                        <option value="RUC" selected>RUC</option>
                        <option value="PAS">PAS</option>
                    @else
                        <option value="DNI">DNI</option>
                        <option value="RUC">RUC</option>
                        <option value="PAS" selected>PAS</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="num_document">Num. Documento</label>
                <input type="text" name="num_document" value="{{$persona->num_document}}" class="form-control" placeholder="Número de documento...">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="phone">Teléfono</label>
                <input type="text" name="phone" value="{{$persona->phone}}" class="form-control" placeholder="Teléfono...">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="{{$persona->email}}" class="form-control" placeholder="Email...">
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