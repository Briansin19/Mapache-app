@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Mapa del Campus - Tecnológico de Chetumal</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <!-- Barra lateral -->
            <div class="col-12 col-md-3">
                <!-- Menú de navegación -->
                <div class="card">
                    <div class="card-header">
                        <h4>Navegación</h4>
                    </div>
                    <div class="card-body">
                        <!-- Campo de búsqueda -->
                        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar edificios...">
                        <!-- Menú desplegable de edificios -->
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="buildingDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Seleccionar Edificio
                            </button>
                            <div class="dropdown-menu" aria-labelledby="buildingDropdown" id="buildingList">
                                @foreach($edificios as $edificio)
                                    <a class="dropdown-item" href="#" onclick="focusOnBuilding({{ $edificio->latitud }}, {{ $edificio->longitud }}, '{{ $edificio->nombre }}', {{ json_encode($edificio->descripcion) }})">
                                        {{ $edificio->nombre }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slider de eventos -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Eventos</h4>
                    </div>
                    <div class="card-body">
                        <div class="event-slider">
                            @foreach($eventos as $evento)
                                <div>
                                    <h6>{{ $evento->nombre }}</h6>
                                    <p>{{ $evento->descripcion }}</p>
                                    <p><strong>Inicio:</strong> {{ $evento->fecha_inicio }}</p>
                                    <p><strong>Fin:</strong> {{ $evento->fecha_fin }}</p>
                                    <p><strong>Habitación:</strong> {{ $evento->habitacion ? $evento->habitacion->nombre : 'Sin habitación' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Lista de maestros -->
                @can('ver-ubicacion-maestros')
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Maestros</h4>
                    </div>
                    <div class="card-body">
                        <!-- Campo de búsqueda de maestros -->
                        <input type="text" id="searchTeacherInput" class="form-control mb-3" placeholder="Buscar maestros...">
                        <!-- Menú desplegable de maestros -->
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="teacherDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Seleccionar Maestro
                            </button>
                            <div class="dropdown-menu" aria-labelledby="teacherDropdown" id="teacherList">
                                @foreach($maestros as $maestro)
                                    <a class="dropdown-item" href="#" onclick="showTeacherSchedule({{ $maestro->id }})">
                                        {{ $maestro->nombre }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
            </div>
            <!-- Mapa -->
            <div class="col-12 col-md-9">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center">Mapa Escolar</h3>
                        <div id="mapid" style="height: 600px;"></div>
                        <!-- Botón de indicaciones -->
                        <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#instructionsModal" id="instructionsButton" style="display: none;">
                            Ver indicaciones
                        </button>
                        <!-- Horarios del maestro -->
                        @can('ver-ubicacion-maestros')
                        <div id="teacherSchedule" class="mt-4" style="display: none;">
                            <h4>Horario del Maestro</h4>
                            <div id="scheduleContent"></div>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal con las indicaciones -->
<div class="modal fade" id="instructionsModal" tabindex="-1" role="dialog" aria-labelledby="instructionsModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Indicaciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="instructions"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_js')
<script>
    // Datos de edificios
    const edificios = @json($edificios);

    // Límites del mapa
    const bounds = [
        [18.519674937812518, -88.30409709819621], // Punto noreste
        [18.517076825710703, -88.30076175711055]  // Punto suroeste
    ];

    // Inicialización del mapa
    const mymap = L.map('mapid', {
        maxZoom: 22,
        minZoom: 18,
        maxBounds: bounds,
        maxBoundsViscosity: 1.0,
        bounceAtZoomLimits: false
    }).setView([18.518600449854645, -88.30217242054088], 18);

    // Capa base de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 22,
        maxNativeZoom: 19,
        attribution: 'Map data © <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
    }).addTo(mymap);

    // Icono personalizado para edificios
    const customIcon = L.divIcon({
        className: 'custom-icon',
        html: '<i class="fas fa-building"></i>',
        iconSize: [20, 20]
    });

    // Añadir marcadores para edificios
    edificios.forEach(edificio => {
        L.marker([edificio.latitud, edificio.longitud], { icon: customIcon })
            .bindPopup(`<b>${edificio.nombre}</b><br>${edificio.descripcion}`)
            .addTo(mymap);
    });

    // Grupo de marcadores para rutas
    const markerGroup = L.layerGroup().addTo(mymap);
    const waypoints = [];
    const markers = [];

    // Escuchar clics en el mapa para definir ruta
    mymap.on('click', e => {
        if (waypoints.length < 2) {
            waypoints.push(e.latlng);
            
            const marker = L.marker(e.latlng).addTo(markerGroup);
            markers.push(marker);

            marker.on('click', function(ev) {
                L.DomEvent.stopPropagation(ev); // Evita que el clic se propague al mapa
                const idx = markers.indexOf(marker);
                if (idx !== -1) {
                    waypoints.splice(idx, 1);
                    markers.splice(idx, 1);
                    markerGroup.removeLayer(marker);

                    // Borrar la ruta si ya no hay 2 puntos
                    if (currentRouteLine) {
                        mymap.removeLayer(currentRouteLine);
                        currentRouteLine = null;
                    }

                    document.getElementById('instructionsButton').style.display = 'none';
                }
            });

        } else {
            waypoints.shift();
            const oldMarker = markers.shift();
            markerGroup.removeLayer(oldMarker);

            waypoints.push(e.latlng);
            const marker = L.marker(e.latlng).addTo(markerGroup);
            markers.push(marker);

        marker.on('click', function(ev) {
            L.DomEvent.stopPropagation(ev);
            const idx = markers.indexOf(marker);
            if (idx !== -1) {
                waypoints.splice(idx, 1);
                markers.splice(idx, 1);
                markerGroup.removeLayer(marker);

                if (currentRouteLine) {
                    mymap.removeLayer(currentRouteLine);
                    currentRouteLine = null;
                }

                document.getElementById('instructionsButton').style.display = 'none';
            }
        });
    }

        if (waypoints.length === 2) fetchRoute(waypoints);
    });

    // Función para obtener y mostrar ruta

    let currentRouteLine = null;

    function fetchRoute(waypoints) {
        const [start, end] = waypoints;
        const url = `https://api.openrouteservice.org/v2/directions/wheelchair?api_key=5b3ce3597851110001cf6248dda04588db7d4f51ab965532e2f67166&start=${start.lng},${start.lat}&end=${end.lng},${end.lat}&language=es`;

        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error('Error al obtener la ruta');
                return response.json();
            })
            .then(data => {
                const route = data.features[0].geometry.coordinates.map(coord => [coord[1], coord[0]]);
                
                if (currentRouteLine) {

                mymap.removeLayer(currentRouteLine);

                }

                currentRouteLine = L.polyline(route, { color: 'blue' }).addTo(mymap);
                mymap.fitBounds(currentRouteLine.getBounds(), {
                     padding: [50, 50],
                     maxZoom: 19
                });

                // Mostrar indicaciones
                const instructions = data.features[0].properties.segments[0].steps.map(step => step.instruction).join('<br>');
                document.getElementById('instructions').innerHTML = instructions;
                document.getElementById('instructionsButton').style.display = 'block';
            })
            .catch(error => console.error('Error:', error));
    }

    // Función para enfocar el mapa en un edificio específico
    function focusOnBuilding(lat, lng, nombre, descripcion) {
        mymap.setView([lat, lng], 18);
        L.popup()
            .setLatLng([lat, lng])
            .setContent(`<b>${nombre}</b><br>${descripcion}`)
            .openOn(mymap);
    }

    // Filtrar los resultados en tiempo real
    document.getElementById('searchInput').addEventListener('input', function() {
        var filter = this.value.toLowerCase();
        var items = document.querySelectorAll('#buildingList .dropdown-item');
        items.forEach(function(item) {
            if (item.textContent.toLowerCase().includes(filter)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Filtrar los maestros en tiempo real
    document.getElementById('searchTeacherInput').addEventListener('input', function() {
        var filter = this.value.toLowerCase();
        var items = document.querySelectorAll('#teacherList .dropdown-item');
        items.forEach(function(item) {
            if (item.textContent.toLowerCase().includes(filter)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Mostrar el horario del maestro seleccionado
    function showTeacherSchedule(maestroId) {
        fetch(`/api/maestros/${maestroId}/horarios`)
            .then(response => response.json())
            .then(data => {
                const scheduleContent = document.getElementById('scheduleContent');
                scheduleContent.innerHTML = '';

                data.forEach(horario => {
                    const horarioElement = document.createElement('div');
                    horarioElement.innerHTML = `
                        <p><strong>Día:</strong> ${horario.dia_semana}</p>
                        <p><strong>Hora de Inicio:</strong> ${horario.hora_inicio}</p>
                        <p><strong>Hora de Fin:</strong> ${horario.hora_fin}</p>
                        <p><strong>Habitación:</strong> ${horario.habitacion.nombre}</p>
                    `;
                    scheduleContent.appendChild(horarioElement);
                });

                document.getElementById('teacherSchedule').style.display = 'block';
            })
            .catch(error => console.error('Error:', error));
    }

    // Inicializar el slider de eventos
    $(document).ready(function(){
        $('.event-slider').slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            adaptiveHeight: true
        });
    });
</script>
@endsection