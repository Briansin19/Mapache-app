@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-header">
      <h3 class="page__heading">Edificios</h3>
  </div>
      <div class="section-body">
          <div class="row">
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">
                          @can('crear-edificio')
                              <a class="btn btn-warning" href="{{ route('edificios.create') }}">Nuevo</a>
                          @endcan

                          <table class="table table-striped mt-2">
                              <thead style="background-color:#6777ef">
                                  <th style="display: none;">ID</th>
                                  <th style="color:#fff;">Nombre</th>
                                  <th style="color:#fff;">Descripción</th>
                                  <th style="color:#fff;">Latitud</th>
                                  <th style="color:#fff;">Longitud</th>
                                  <th style="color:#fff;">Acciones</th>
                              </thead>
                              <tbody>
                                @foreach ($edificios as $edificio)
                                  <tr>
                                    <td style="display: none;">{{ $edificio->id }}</td>
                                    <td>{{ $edificio->nombre }}</td>
                                    <td>{{ $edificio->descripcion }}</td>
                                    <td>{{ $edificio->latitud }}</td>
                                    <td>{{ $edificio->longitud }}</td>
                                    <td>
                                      @can('editar-edificio')
                                          <a class="btn btn-info" href="{{ route('edificios.edit', $edificio->id) }}">Editar</a>
                                      @endcan

                                      @can('borrar-edificio')
                                          {!! Form::open(['method' => 'DELETE', 'route' => ['edificios.destroy', $edificio->id], 'style' => 'display:inline']) !!}
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
                            {!! $edificios->links() !!}
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </section>
@endsection