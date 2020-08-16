@extends('_base')

@section('title', 'Résultats du Bilan')

@section('breadcrumb')
    <li class="breadcrumb-item active">Résultats du Bilan</li>
@endsection

@section('content')
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-table'></i> Résultats du Bilan
        </h1>


        <a href="{{ route_to('summary.index') }}" class="btn btn-primary">Filtrer de nouveau
        </a>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Panel
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                                data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="panel-tag">
                            <p>
                                Les différents filtres appliqués sont :
                            <ul>
                                @forelse($filterData as $filter => $value)
                                    <li class="text-capitalize"><b>{{ $filter }}</b> : {{ $value }}</li>
                                @empty
                                    <li class="text-uppercase">AUCUN FILTRE appliqué</li>
                                @endforelse
                            </ul>
                            </p>
                        </div>

                        <!-- datatable start -->
                        <table id="dt-basic-" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                            <tr>
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Prénoms</th>
                                <th>total Consommations</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($consommations as $conso)
                                <tr>
                                    <td>{{ $conso->matriculeInphb }}</td>
                                    <td>{{ $conso->nom }}</td>
                                    <td>{{ $conso->prenoms }}</td>
                                    <td>{{ $conso->totalConso }} FCFA</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Prénoms</th>
                                <th>total Consommations</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- datatable end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after-js')
    {!! script_tag('js/qrcode.min.js') !!}

    <script>
        $(document).ready(function () {
            var options = {};

            // initialize datatable
            $('#dt-basic-').dataTable(
                {
                    responsive: true,
                    lengthChange: false,
                    dom:
                        "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        /*{
                            extend:    'colvis',
                            text:      'Column Visibility',
                            titleAttr: 'Col visibility',
                            className: 'mr-sm-3'
                        },*/
                        {
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            titleAttr: 'Generate PDF',
                            className: 'btn-outline-danger btn-sm mr-1',
                            ...options

                        },
                        {
                            extend: 'excelHtml5',
                            text: 'Excel',
                            titleAttr: 'Generate Excel',
                            className: 'btn-outline-success btn-sm mr-1',
                            ...options

                        },
                        {
                            extend: 'csvHtml5',
                            text: 'CSV',
                            titleAttr: 'Generate CSV',
                            className: 'btn-outline-primary btn-sm mr-1',
                            ...options

                        },
                        {
                            extend: 'copyHtml5',
                            text: 'Copier',
                            titleAttr: 'Copy to clipboard',
                            className: 'btn-outline-primary btn-sm mr-1',
                            ...options

                        },
                        {
                            extend: 'print',
                            text: 'Imprimer',
                            titleAttr: 'Print Table',
                            className: 'btn-outline-primary btn-sm',
                            ...options
                        }
                    ]
                });

        });
    </script>
@endsection