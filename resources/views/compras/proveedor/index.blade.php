@extends ('layouts.admin')
@section ('content')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Proveedores <a href="proveedor/create"><button class="btn btn-success">Nuevo</button></a></h3>
		@include('compras.proveedor.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Id</th>
					<th>Nombre</th>
					<th>Tipo Doc.</th>
					<th>Num. Doc.</th>
					<th>Teléfono</th>
					<th>Email</th>
					<th>Opciones</th>
				</thead>
				@foreach ($personas as $per)
				<tr>
					<td>{{ $per->id }}</td>
					<td>{{ $per->name }}</td>
					<td>{{ $per->type_document }}</td>
					<td>{{ $per->num_document }}</td>
					<td>{{ $per->phone }}</td>
					<td>{{ $per->email }}</td>
					<td><a href="{{URL::action('ProviderController@edit',$per->id)}}"><button class="btn btn-info">Editar</button></a>
					<a href="" data-target="#modal-delete-{{$per->id}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
					</td>
				</tr>
				@include('compras.proveedor.modal')
				@endforeach
			</table>
		</div>
		{{ $personas->links() }} <!-- paginación -->
	</div>
</div>

@endsection