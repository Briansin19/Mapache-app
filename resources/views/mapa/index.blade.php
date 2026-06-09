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
                <!-- Búsqueda unificada -->
                <div class="card">
                    <div class="card-header">
                        <h4>Buscar</h4>
                    </div>
                    <div class="card-body">
                        <input type="text" id="searchInput" class="form-control mb-2" placeholder="Edificio, aula, baños...">
                        <div id="searchResults" class="list-group" style="max-height:220px; overflow-y:auto;"></div>
                        <small id="searchHint" class="text-muted" style="display:none;">Haz clic en un resultado para trazar la ruta</small>
                    </div>
                </div>

                <!-- Slider de eventos -->
                <div class="card mt-3">
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
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Maestros</h4>
                    </div>
                    <div class="card-body">
                        <input type="text" id="searchTeacherInput" class="form-control mb-2" placeholder="Buscar maestro...">
                        <div id="teacherList" class="list-group" style="max-height:200px; overflow-y:auto;">
                            @foreach($maestros as $maestro)
                                <a class="list-group-item list-group-item-action teacher-item" href="#" data-id="{{ $maestro->id }}">
                                    {{ $maestro->nombre }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endcan
            </div>

            <!-- Mapa -->
            <div class="col-12 col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h3 class="mb-0">Mapa Escolar</h3>
                            <div>
                                <span id="gpsStatus" class="badge badge-secondary">GPS desactivado</span>
                                <button class="btn btn-sm btn-outline-primary ml-2" id="btnGps">
                                    <i class="fas fa-location-arrow"></i> Usar mi ubicación
                                </button>
                                <button class="btn btn-sm btn-outline-danger ml-1" id="btnClearRoute" style="display:none;">
                                    <i class="fas fa-times"></i> Limpiar ruta
                                </button>
                            </div>
                        </div>
                        <div id="mapid" style="height: 600px;"></div>
                        <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#instructionsModal" id="instructionsButton" style="display:none;">
                            Ver indicaciones
                        </button>
                        @can('ver-ubicacion-maestros')
                        <div id="teacherSchedule" class="mt-4" style="display:none;">
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

<!-- Modal indicaciones -->
<div class="modal fade" id="instructionsModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Indicaciones</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
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
    // ── Datos ──────────────────────────────────────────────────────────────────
    const edificios = @json($edificios);

    const campusBounds = [
        [18.519674937812518, -88.30409709819621],
        [18.517076825710703, -88.30076175711055]
    ];

    // ── Mapa ───────────────────────────────────────────────────────────────────
    const mymap = L.map('mapid', {
        maxZoom: 22,
        minZoom: 18,
        maxBounds: campusBounds,
        maxBoundsViscosity: 1.0,
        bounceAtZoomLimits: false
    }).setView([18.518600449854645, -88.30217242054088], 18);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 22,
        maxNativeZoom: 19,
        attribution: 'Map data © <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
    }).addTo(mymap);

    // ── Iconos ─────────────────────────────────────────────────────────────────
    const iconNormal = L.divIcon({
        className: 'custom-icon',
        html: '<i class="fas fa-building"></i>',
        iconSize: [20, 20]
    });

    const iconResaltado = L.divIcon({
        className: 'custom-icon-highlight',
        html: '<i class="fas fa-building" style="color:#e74c3c; font-size:20px;"></i>',
        iconSize: [24, 24]
    });

    const iconUsuario = L.divIcon({
        className: '',
        html: '<i class="fas fa-street-view" style="color:#2980b9; font-size:22px;"></i>',
        iconSize: [22, 22]
    });

    // ── Marcadores de edificios ────────────────────────────────────────────────
    const edificioMarkers = {};

    edificios.forEach(function(edificio) {
        const marker = L.marker([edificio.latitud, edificio.longitud], { icon: iconNormal })
            .bindPopup('<b>' + edificio.nombre + '</b><br>' + (edificio.descripcion || '').replace(/\n/g, '<br>'))
            .addTo(mymap);
        edificioMarkers[edificio.id] = marker;
    });

    // ── Estado de ruta ─────────────────────────────────────────────────────────
    let currentRouteLine = null;
    let originMarker = null;       // marcador "Tu ubicación"
    let destMarker = null;         // marcador "Destino"
    let originLatLng = null;
    let destLatLng = null;
    let usingGps = false;

    // ── GPS ────────────────────────────────────────────────────────────────────
    function isInsideCampus(lat, lng) {
        const sw = campusBounds[1], ne = campusBounds[0];
        return lat >= sw[0] && lat <= ne[0] && lng >= sw[1] && lng <= ne[1];
    }

    document.getElementById('btnGps').addEventListener('click', function() {
        if (!navigator.geolocation) {
            alert('Tu navegador no soporta geolocalización.');
            return;
        }
        navigator.geolocation.getCurrentPosition(function(pos) {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;

            setOrigin(L.latLng(lat, lng), true);

            if (isInsideCampus(lat, lng)) {
                mymap.setView([lat, lng], 19);
            } else {
                alert('Estás fuera del campus. Tu posición GPS se usará como origen; ahora haz clic en el mapa (o busca un edificio) para marcar el destino.');
            }
        }, function() {
            alert('No se pudo obtener tu ubicación. Haz clic en el mapa para marcar el origen.');
        });
    });

    // Origen ("Tu ubicación")
    function setOrigin(latlng, fromGps) {
        originLatLng = latlng;
        usingGps = fromGps;

        if (originMarker) mymap.removeLayer(originMarker);
        originMarker = L.marker(latlng, { icon: iconUsuario })
            .bindPopup(fromGps ? 'Tu ubicación (GPS)' : 'Tu ubicación')
            .addTo(mymap);
        originMarker.on('click', function(ev) {
            L.DomEvent.stopPropagation(ev);
            clearRoute();
        });

        const statusEl = document.getElementById('gpsStatus');
        statusEl.textContent = fromGps ? 'GPS activo' : 'Origen marcado';
        statusEl.className = fromGps ? 'badge badge-success' : 'badge badge-info';

        // Si ya hay destino, recalcular ruta
        if (destLatLng) fetchRoute(originLatLng, destLatLng);
    }

    // Destino
    function setDestination(latlng) {
        destLatLng = latlng;

        if (destMarker) mymap.removeLayer(destMarker);
        destMarker = L.marker(latlng)
            .bindPopup('Destino')
            .addTo(mymap);
        destMarker.on('click', function(ev) {
            L.DomEvent.stopPropagation(ev);
            if (destMarker) { mymap.removeLayer(destMarker); destMarker = null; }
            destLatLng = null;
            removeRouteLine();
        });

        if (originLatLng) fetchRoute(originLatLng, destLatLng);
    }

    // Clic en el mapa: 1er clic = origen, 2do clic = destino, 3ro = reinicia
    mymap.on('click', function(e) {
        if (!originLatLng) {
            setOrigin(e.latlng, false);
        } else if (!destLatLng) {
            setDestination(e.latlng);
        } else {
            // Reiniciar y empezar de nuevo con este punto como origen
            clearRoute();
            setOrigin(e.latlng, false);
        }
    });

    // ── Ruta ───────────────────────────────────────────────────────────────────
    function fetchRoute(start, end) {
        const url = 'https://api.openrouteservice.org/v2/directions/wheelchair?api_key={{ $orsApiKey }}'
            + '&start=' + start.lng + ',' + start.lat
            + '&end=' + end.lng + ',' + end.lat
            + '&language=es';

        fetch(url)
            .then(function(r) {
                if (!r.ok) throw new Error('Error al obtener la ruta');
                return r.json();
            })
            .then(function(data) {
                const route = data.features[0].geometry.coordinates.map(function(c) { return [c[1], c[0]]; });

                if (currentRouteLine) mymap.removeLayer(currentRouteLine);
                currentRouteLine = L.polyline(route, { color: '#2980b9', weight: 4 }).addTo(mymap);
                mymap.fitBounds(currentRouteLine.getBounds(), { padding: [50, 50], maxZoom: 19 });

                const instructions = data.features[0].properties.segments[0].steps
                    .map(function(s) { return s.instruction; }).join('<br>');
                document.getElementById('instructions').innerHTML = instructions;
                document.getElementById('instructionsButton').style.display = 'block';
                document.getElementById('btnClearRoute').style.display = 'inline-block';
            })
            .catch(function(err) { console.error('Error ruta:', err); });
    }

    function routeToBuilding(edificio) {
        // El edificio buscado se vuelve el destino
        setDestination(L.latLng(edificio.latitud, edificio.longitud));
        edificioMarkers[edificio.id].openPopup();

        if (!originLatLng) {
            alert('Edificio marcado como destino. Activa el GPS o haz clic en el mapa para marcar tu ubicación de origen.');
        }
    }

    function removeRouteLine() {
        if (currentRouteLine) { mymap.removeLayer(currentRouteLine); currentRouteLine = null; }
        document.getElementById('instructionsButton').style.display = 'none';
        document.getElementById('instructions').innerHTML = '';
    }

    function clearRoute() {
        removeRouteLine();
        if (originMarker) { mymap.removeLayer(originMarker); originMarker = null; }
        if (destMarker) { mymap.removeLayer(destMarker); destMarker = null; }
        originLatLng = null;
        destLatLng = null;
        usingGps = false;
        document.getElementById('btnClearRoute').style.display = 'none';
        const statusEl = document.getElementById('gpsStatus');
        statusEl.textContent = 'GPS desactivado';
        statusEl.className = 'badge badge-secondary';
    }

    // Botón limpiar ruta
    document.getElementById('btnClearRoute').addEventListener('click', clearRoute);

    // ── Búsqueda unificada ─────────────────────────────────────────────────────
    // Resetear todos los marcadores al color normal
    function resetMarkers() {
        edificios.forEach(function(e) {
            edificioMarkers[e.id].setIcon(iconNormal);
        });
    }

    document.getElementById('searchInput').addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        const resultsEl = document.getElementById('searchResults');
        const hintEl = document.getElementById('searchHint');
        resultsEl.innerHTML = '';
        resetMarkers();

        if (query.length < 2) {
            hintEl.style.display = 'none';
            return;
        }

        const matches = edificios.filter(function(e) {
            return e.nombre.toLowerCase().includes(query) ||
                   (e.descripcion && e.descripcion.toLowerCase().includes(query));
        });

        if (matches.length === 0) {
            resultsEl.innerHTML = '<div class="list-group-item text-muted">Sin resultados</div>';
            hintEl.style.display = 'none';
            return;
        }

        matches.forEach(function(e) {
            // Resaltar marcador en el mapa
            edificioMarkers[e.id].setIcon(iconResaltado);

            // Agregar resultado en la lista
            const item = document.createElement('a');
            item.href = '#';
            item.className = 'list-group-item list-group-item-action py-1';
            item.innerHTML = '<strong>' + e.nombre + '</strong>';
            item.addEventListener('click', function(ev) {
                ev.preventDefault();
                mymap.setView([e.latitud, e.longitud], 20);
                edificioMarkers[e.id].openPopup();
                routeToBuilding(e);
            });
            resultsEl.appendChild(item);
        });

        hintEl.style.display = 'block';

        // Si hay varios resultados, ajustar vista para verlos todos
        if (matches.length > 1) {
            const group = matches.map(function(e) { return [e.latitud, e.longitud]; });
            mymap.fitBounds(group, { padding: [40, 40], maxZoom: 20 });
        } else {
            mymap.setView([matches[0].latitud, matches[0].longitud], 20);
        }
    });

    // ── Búsqueda de maestros ───────────────────────────────────────────────────
    var teacherSearchInput = document.getElementById('searchTeacherInput');
    if (teacherSearchInput) {
        teacherSearchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('.teacher-item').forEach(function(item) {
                item.style.display = item.textContent.toLowerCase().includes(filter) ? '' : 'none';
            });
        });

        document.querySelectorAll('.teacher-item').forEach(function(item) {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                showTeacherSchedule(this.dataset.id);
            });
        });
    }

    function showTeacherSchedule(maestroId) {
        fetch('/api/maestros/' + maestroId + '/horarios')
            .then(function(r) { return r.json(); })
            .then(function(data) {
                const content = document.getElementById('scheduleContent');
                content.innerHTML = '';
                data.forEach(function(h) {
                    const div = document.createElement('div');
                    div.innerHTML = '<p><strong>Día:</strong> ' + h.dia_semana + '</p>'
                        + '<p><strong>Hora inicio:</strong> ' + h.hora_inicio + '</p>'
                        + '<p><strong>Hora fin:</strong> ' + h.hora_fin + '</p>'
                        + '<p><strong>Habitación:</strong> ' + h.habitacion.nombre + '</p><hr>';
                    content.appendChild(div);
                });
                document.getElementById('teacherSchedule').style.display = 'block';
            })
            .catch(function(err) { console.error(err); });
    }

    // ── Slider de eventos ──────────────────────────────────────────────────────
    $(document).ready(function() {
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
