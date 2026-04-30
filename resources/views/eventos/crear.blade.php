@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-header">
      <h3 class="page__heading">Crear Evento</h3>
  </div>
      <div class="section-body">
          <div class="row">
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">
                          {!! Form::open(['route' => 'eventos.store', 'method' => 'POST']) !!}
                              <div class="form-group">
                                  <label for="nombre">Nombre</label>
                                  {!! Form::text('nombre', null, ['class' => 'form-control', 'required']) !!}
                              </div>
                              <div class="form-group">
                                  <label for="descripcion">Descripción</label>
                                  {!! Form::textarea('descripcion', null, ['class' => 'form-control']) !!}
                              </div>
                              <div class="form-group">
                                  <label for="fecha_inicio">Fecha de Inicio</label>
                                  {!! Form::datetimeLocal('fecha_inicio', null, ['class' => 'form-control', 'required']) !!}
                              </div>
                              <div class="form-group">
                                  <label for="fecha_fin">Fecha de Fin</label>
                                  {!! Form::datetimeLocal('fecha_fin', null, ['class' => 'form-control', 'required']) !!}
                              </div>
                              <div class="form-group">
                                  <label for="habitacion_id">Habitación</label>
                                  {!! Form::select('habitacion_id', $habitaciones, null, ['class' => 'form-control', 'required']) !!}
                              </div>
                              <button type="submit" class="btn btn-primary">Guardar</button>
                          {!! Form::close() !!}
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </section>
@endsection