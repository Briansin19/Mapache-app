@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-header">
      <h3 class="page__heading">Habitaciones</h3>
  </div>
      <div class="section-body">
          <div class="row">
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">
                          @can('crear-habitaciones')
                              <a class="btn btn-warning" href="{{ route('habitaciones.create') }}">Nuevo</a>
                          @endcan

                          <table class="table table-striped mt-2">
                              <thead style="background-color:#6777ef">
                                  <th style="display: none;">ID</th>
                                  <th style="color:#fff;">Nombre</th>
                                  <th style="color:#fff;">Descripción</th>
                                  <th style="color:#fff;">Edificio</th>
                                  <th style="color:#fff;">Tipo de Habitación</th>
                                  <th style="color:#fff;">Acciones</th>
                              </thead>
                              <tbody>
                                @foreach ($habitaciones as $habitacion)
                                  <tr>
                                    <td style="display: none;">{{ $habitacion->id }}</td>
                                    <td>{{ $habitacion->nombre }}</td>
                                    <td>{{ $habitacion->descripcion }}</td>
                                    <td>{{ $habitacion->edificio->nombre }}</td>
                                    <td>{{ $habitacion->tipoHabitacion->nombre }}</td>
                                    <td>
                                      @can('editar-habitaciones')
                                          <a class="btn btn-info" href="{{ route('habitaciones.edit', $habitacion->id) }}">Editar</a>
                                      @endcan

                                      @can('borrar-habitaciones')
                                          {!! Form::open(['method' => 'DELETE', 'route' => ['habitaciones.destroy', $habitacion->id], 'style' => 'display:inline']) !!}
                                              {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                          {!! Form::close() !!}
                                      @endcan
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                            <!-- Centramos la paginacion a la derecha -->
                          <div class="pagination justify-content-end">
                            {!! $habitaciones->links() !!}
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </section>
@endsection