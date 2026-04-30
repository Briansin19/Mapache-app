@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-header">
      <h3 class="page__heading">Personal</h3>
  </div>
      <div class="section-body">
          <div class="row">
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">
                          @can('crear-personal')
                              <a class="btn btn-warning" href="{{ route('personal.create') }}">Nuevo</a>
                          @endcan

                          <table class="table table-striped mt-2">
                              <thead style="background-color:#6777ef">
                                  <th style="display: none;">ID</th>
                                  <th style="color:#fff;">Nombre</th>
                                  <th style="color:#fff;">Correo</th>
                                  <th style="color:#fff;">Tipo</th>
                                  <th style="color:#fff;">Acciones</th>
                              </thead>
                              <tbody>
                                @foreach ($personal as $persona)
                                  <tr>
                                    <td style="display: none;">{{ $persona->id }}</td>
                                    <td>{{ $persona->nombre }}</td>
                                    <td>{{ $persona->correo }}</td>
                                    <td>{{ $persona->tipo }}</td>
                                    <td>
                                      @can('editar-personal')
                                          <a class="btn btn-info" href="{{ route('personal.edit', $persona->id) }}">Editar</a>
                                      @endcan

                                      @can('borrar-personal')
                                          {!! Form::open(['method' => 'DELETE', 'route' => ['personal.destroy', $persona->id], 'style' => 'display:inline']) !!}
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
                            {!! $personal->links() !!}
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </section>
@endsection