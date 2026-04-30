@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-header">
      <h3 class="page__heading">Editar Horario</h3>
  </div>
      <div class="section-body">
          <div class="row">
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">
                          {!! Form::model($horario, ['route' => ['horarios_personal.update', $horario->id], 'method' => 'PUT']) !!}
                              <div class="form-group">
                                  <label for="personal_id">Personal</label>
                                  {!! Form::select('personal_id', $personal, null, ['class' => 'form-control', 'required']) !!}
                              </div>
                              <div class="form-group">
                                  <label for="dia_semana">Día de la Semana</label>
                                  {!! Form::select('dia_semana', ['Lunes' => 'Lunes', 'Martes' => 'Martes', 'Miércoles' => 'Miércoles', 'Jueves' => 'Jueves', 'Viernes' => 'Viernes', 'Sábado' => 'Sábado', 'Domingo' => 'Domingo'], null, ['class' => 'form-control', 'required']) !!}
                              </div>
                              <div class="form-group">
                                  <label for="hora_inicio">Hora de Inicio</label>
                                  {!! Form::time('hora_inicio', null, ['class' => 'form-control', 'required']) !!}
                              </div>
                              <div class="form-group">
                                  <label for="hora_fin">Hora de Fin</label>
                                  {!! Form::time('hora_fin', null, ['class' => 'form-control', 'required']) !!}
                              </div>
                              <div class="form-group">
                                  <label for="habitacion_id">Habitación</label>
                                  {!! Form::select('habitacion_id', $habitaciones, null, ['class' => 'form-control', 'required']) !!}
                              </div>
                              <button type="submit" class="btn btn-primary">Actualizar</button>
                          {!! Form::close() !!}
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </section>
@endsection