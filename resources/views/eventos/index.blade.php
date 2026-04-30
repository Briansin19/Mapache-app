@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-header">
      <h3 class="page__heading">Eventos</h3>
  </div>
      <div class="section-body">
          <div class="row">
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">
                          @can('crear-eventos')
                              <a class="btn btn-warning" href="{{ route('eventos.create') }}">Nuevo</a>
                          @endcan

                          <table class="table table-striped mt-2">
                              <thead style="background-color:#6777ef">
                                  <th style="display: none;">ID</th>
                                  <th style="color:#fff;">Nombre</th>
                                  <th style="color:#fff;">Descripción</th>
                                  <th style="color:#fff;">Fecha de Inicio</th>
                                  <th style="color:#fff;">Fecha de Fin</th>
                                  <th style="color:#fff;">Habitación</th>
                                  <th style="color:#fff;">Acciones</th>
                              </thead>
                              <tbody>
                                @foreach ($eventos as $evento)
                                  <tr>
                                    <td style="display: none;">{{ $evento->id }}</td>
                                    <td>{{ $evento->nombre }}</td>
                                    <td>{{ $evento->descripcion }}</td>
                                    <td>{{ $evento->fecha_inicio }}</td>
                                    <td>{{ $evento->fecha_fin }}</td>
                                    <td>{{ $evento->habitacion->nombre }}</td>
                                    <td>
                                      @can('editar-eventos')
                                          <a class="btn btn-info" href="{{ route('eventos.edit', $evento->id) }}">Editar</a>
                                      @endcan

                                      @can('borrar-eventos')
                                          {!! Form::open(['method' => 'DELETE', 'route' => ['eventos.destroy', $evento->id], 'style' => 'display:inline']) !!}
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
                            {!! $eventos->links() !!}
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </section>
@endsection