@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-header">
      <h3 class="page__heading">Horarios del Personal</h3>
  </div>
      <div class="section-body">
          <div class="row">
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">
                          <!-- Botón global para agregar un nuevo horario -->
                          @can('crear-horarios')
                              <a class="btn btn-primary mb-2" href="{{ route('horarios_personal.create') }}">Nuevo Horario</a>
                          @endcan

                          <!-- Formulario de búsqueda -->
                          <form action="{{ route('horarios_personal.index') }}" method="GET" class="form-inline my-2 my-lg-0 float-right">
                              <input class="form-control mr-sm-2" type="search" name="search" placeholder="Buscar por nombre" aria-label="Buscar" value="{{ request()->input('search') }}">
                              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                          </form>

                          @foreach ($horarios as $personalId => $horariosPersonal)
                              <h4>{{ $horariosPersonal->first()->personal->nombre }}</h4>
                              @can('crear-horarios')
                                  <a class="btn btn-warning mb-2" href="{{ route('horarios_personal.create', ['personal_id' => $personalId]) }}">Agregar Día</a>
                              @endcan
                              <table class="table table-striped mt-2">
                                  <thead style="background-color:#6777ef">
                                      <th style="color:#fff;">Día de la Semana</th>
                                      <th style="color:#fff;">Hora de Inicio</th>
                                      <th style="color:#fff;">Hora de Fin</th>
                                      <th style="color:#fff;">Habitación</th>
                                      <th style="color:#fff;">Acciones</th>
                                  </thead>
                                  <tbody>
                                    @foreach ($horariosPersonal as $horario)
                                      <tr>
                                        <td>{{ $horario->dia_semana }}</td>
                                        <td>{{ $horario->hora_inicio }}</td>
                                        <td>{{ $horario->hora_fin }}</td>
                                        <td>{{ $horario->habitacion->nombre }}</td>
                                        <td>
                                          @can('editar-horarios')
                                              <a class="btn btn-info" href="{{ route('horarios_personal.edit', $horario->id) }}">Editar</a>
                                          @endcan

                                          @can('borrar-horarios')
                                              {!! Form::open(['method' => 'DELETE', 'route' => ['horarios_personal.destroy', $horario->id], 'style' => 'display:inline']) !!}
                                                  {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                              {!! Form::close() !!}
                                          @endcan
                                        </td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                          @endforeach
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </section>
@endsection