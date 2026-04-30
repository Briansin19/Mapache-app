@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-header">
      <h3 class="page__heading">Crear Personal</h3>
  </div>
      <div class="section-body">
          <div class="row">
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">
                          {!! Form::open(['route' => 'personal.store', 'method' => 'POST']) !!}
                              <div class="form-group">
                                  <label for="nombre">Nombre</label>
                                  {!! Form::text('nombre', null, ['class' => 'form-control', 'required']) !!}
                              </div>
                              <div class="form-group">
                                  <label for="correo">Correo</label>
                                  {!! Form::email('correo', null, ['class' => 'form-control', 'required']) !!}
                              </div>
                              <div class="form-group">
                                  <label for="tipo">Tipo</label>
                                  {!! Form::select('tipo', ['Docente' => 'Docente', 'Administrativo' => 'Administrativo'], null, ['class' => 'form-control', 'required']) !!}
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