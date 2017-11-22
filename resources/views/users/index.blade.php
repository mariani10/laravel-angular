@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

        	{{ session()->has('status') }}

        	<a href="{{ url('usuarios/create') }}">Nuevo User</a>

            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>



                <table class="table table-bordered">
                	<thead>
                		<tr> 
                			<th>Email</th> 
                			<th>Último Login</th> 
                			<th>Grupo</th> 
                		</tr> 
                	</thead> 

                	<tbody> 
                		@foreach($users AS $user)
                		<tr> 
		                    <td>{{ $user->email }}</td>
		                    <td>{{ $user->ultimo_login->created_at or 'Aún no ingresó' }}</td>
		                    <td>{{ $user->acl_grupos()->pluck('nombre')->implode(' ') }}</td>
						</tr> 
						@endforeach
					</tbody>
				</table>
            </div>
        </div>
    </div>
</div>
@endsection
