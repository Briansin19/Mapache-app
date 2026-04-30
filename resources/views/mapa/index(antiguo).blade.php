@extends('layouts.app')

@section('content')
    <section class="section">
        {{-- <div class="section-header">
            <h3 class="page__heading text-center">Mapa del Campus - Tecnológico de Chetumal</h3>
        </div> --}}
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-3">
                    <!-- Campo de búsqueda -->
                    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar aulas, talleres, oficinas, edificios...">
                    
                    <!-- Aquí es donde se mostrará el menú de edificios -->
                    <div class="list-group" id="buildingList">
                        @foreach($edificios as $edificio)
                            <a href="#" class="list-group-item list-group-item-action" onclick="focusOnBuilding({{ $edificio->latitud }}, {{ $edificio->longitud }}, '{{ $edificio->nombre }}', '{{ $edificio->descripcion }}')">
                                {{ $edificio->nombre }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Mapa</h3>
                            <!-- Aquí es donde se mostrará el mapa de Leaflet -->
                            <div id="mapid" style="height: 600px;"></div>
                            <!-- Botón para abrir el modal con las indicaciones -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#instructionsModal" id="instructionsButton" style="display: none;">
                                Ver indicaciones
                            </button>

                            <!-- Sección condicional para verificar el permiso -->
                            @can('ver-ubicacion-maestros')
                                <div class="alert alert-success mt-3">
                                    Tienes permiso para ver la ubicación de los maestros.
                                </div>
                            @else
                                <div class="alert alert-danger mt-3">
                                    No tienes permiso para ver la ubicación de los maestros.
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
                    <h5 class="modal-title" id="instructionsModalLabel">Indicaciones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="instructions">
                    <!-- Aquí es donde se mostrarán las indicaciones -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_js')
    <!-- Aquí puedes incluir JS específico de la página -->
    <script>
        // Crear una variable global con las coordenadas de los edificios
        var edificios = @json($edificios);

        // Definir los límites del Tecnológico de Chetumal
        var bounds = [
            [18.520, -88.305], // Noroeste
            [18.517, -88.299]  // Sureste
        ];

        var mymap = L.map('mapid', {
            maxZoom: 25,
            maxBounds: bounds, // Establecer los límites del mapa
            maxBoundsViscosity: 1.0 // Hacer que el mapa se adhiera a los límites
        }).setView([18.518600449854645, -88.30217242054088], 17);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 30,
            attribution: 'Map data © <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
        }).addTo(mymap);

        // Crear un icono personalizado utilizando Font Awesome
        var customIcon = L.divIcon({
            className: 'custom-icon',
            html: '<i class="fas fa-building"></i>', // Cambia 'fa-building' al nombre de la clase del icono que prefieras
            iconSize: [20, 20] // Ajusta el tamaño del icono según sea necesario
        });

        // Agregar un marcador para cada edificio
        for (var i = 0; i < edificios.length; i++) {
            L.marker([edificios[i].latitud, edificios[i].longitud], {icon: customIcon})
                .bindPopup('<b>' + edificios[i].nombre + '</b><br>' + edificios[i].descripcion)
                .addTo(mymap);
        }

        var waypoints = [];

        var markerGroup = L.layerGroup().addTo(mymap); // Grupo para almacenar los marcadores

        mymap.on('click', function(e) {
            if (waypoints.length < 2) {
                waypoints.push(e.latlng);
                L.marker(e.latlng).addTo(markerGroup); // Agrega un marcador al grupo de marcadores
            } else {
                waypoints.shift();
                waypoints.push(e.latlng);
                markerGroup.clearLayers(); // Limpia los marcadores existentes
                waypoints.forEach(function(waypoint) {
                    L.marker(waypoint).addTo(markerGroup); // Agrega los marcadores actualizados al grupo de marcadores
                });
            }

            if (waypoints.length === 2) {
                var request = new XMLHttpRequest();
                var url = 'https://api.openrouteservice.org/v2/directions/wheelchair?api_key=5b3ce3597851110001cf6248dda04588db7d4f51ab965532e2f67166&start=' + waypoints[0].lng + ',' + waypoints[0].lat + '&end=' + waypoints[1].lng + ',' + waypoints[1].lat + '&language=es';

                request.open('GET', url, true);

                request.setRequestHeader('Accept', 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8');

                request.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        var data = JSON.parse(this.responseText);
                        var route = data.features[0].geometry.coordinates;
                        var routeLine = L.polyline(route.map(function(coord) { return [coord[1], coord[0]]; }), {color: 'blue'}).addTo(mymap);
                        mymap.fitBounds(routeLine.getBounds(), {
                            padding: [50, 50] // Ajusta estos números según tus necesidades
                        });

                        // Extraer las indicaciones paso a paso
                        var instructions = data.features[0].properties.segments[0].steps.map(function(step) {
                            return step.instruction;
                        });

                        // Mostrar las indicaciones en el modal
                        var instructionsElement = document.getElementById('instructions');
                        instructionsElement.innerHTML = instructions.join('<br>');

                        // Mostrar el botón de indicaciones
                        document.getElementById('instructionsButton').style.display = 'block';
                    }
                };

                request.send();
            }
        });

        document.getElementById('instructionsModal').addEventListener('hidden.bs.modal', function (e) {
            let modalBackdrops = document.getElementsByClassName('modal-backdrop');
            for(let i = 0; i < modalBackdrops.length; i++) {
                modalBackdrops[i].style.display = 'none';
            }
        });

        // Función para centrar el mapa en un edificio específico
        window.focusOnBuilding = function(lat, lng, nombre, descripcion) {
            mymap.setView([lat, lng], 18);
            L.popup()
                .setLatLng([lat, lng])
                .setContent('<b>' + nombre + '</b><br>' + descripcion)
                .openOn(mymap);
        };

        // Filtrar los resultados en tiempo real
        document.getElementById('searchInput').addEventListener('input', function() {
            var filter = this.value.toLowerCase();
            var items = document.querySelectorAll('#buildingList .list-group-item');
            items.forEach(function(item) {
                if (item.textContent.toLowerCase().includes(filter)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
@endsection