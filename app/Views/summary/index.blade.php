@extends('_base')

@section('title', 'Bilan des consommations')

@section('breadcrumb')
    <li class="breadcrumb-item active">Bilan des consommations</li>
@endsection

@section('content')
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-table'></i> Bilan des consommations des étudiants
        </h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Filtres
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
                    <div class="panel-content p-5">
                        <div class="panel-tag">
                            <p>
                                Choisissez les différents filtres, puis cliquez sur le bouton <b>Filtrer</b>
                            </p>
                        </div>
                        <!-- datatable start -->
                        <form action="{{ route_to('summary.show') }}">
                            <div class="form-row mb-2">
                                <div class="col-md-6">
                                    <div class="form-group"><label for="annee" class="form-label">Année
                                            Académique</label><select
                                                name="annee"
                                                id="annee"
                                                class="select2 form-control">
                                            @foreach($annees as $annee)
                                                <option value="{{ $annee->idAnneeAcademique }}">{{ $annee->anneeacademique }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label for="trimestre"
                                                                   class="form-label">Trimestre</label><select
                                                name="trimestre"
                                                id="trimestre"
                                                class="select2 form-control">
                                            @foreach($trimestres as $trimestre)
                                                <option value="{{ $trimestre->idTrimestre }}">{{ $trimestre->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-6">
                                    <div class="form-group"><label for="ecole" class="form-label">Ecole</label><select
                                                name="ecole"
                                                id="ecole"
                                                class="select2 form-control">
                                            @foreach($schools as $school)
                                                <option value="{{ $school->idEcole }}">{{ $school->ecole }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label for="filiere"
                                                                   class="form-label">Filière</label><select
                                                name="filiere"
                                                id="filiere"
                                                class="select2 form-control">
                                            @foreach($filieres as $fil)
                                                <option value="{{ $fil->idFiliere }}">{{ $fil->filiere  }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-6">
                                    <div class="form-group"><label for="specialite"
                                                                   class="form-label">Spécialité</label><select
                                                name="specialite"
                                                id="specialite"
                                                class="select2 form-control">
                                            @foreach($specialites as $spe)
                                                <option value="{{ $spe->idSpecialite }}">{{ $spe->specialite  }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label for="niveau" class="form-label">Niveau</label><select
                                                name="niveau"
                                                id="niveau"
                                                class="select2 form-control">
                                            @foreach($niveaux as $niv)
                                                <option value="{{ $niv->idNiveau }}">{{ $niv->niveau  }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-6">
                                    <div class="form-group"><label for="cycle" class="form-label">Cycle</label><select
                                                name="cycle"
                                                id="cycle"
                                                class="select2 form-control">
                                            @foreach($cycles as $cy)
                                                <option value="{{ $cy->idCycle }}">{{ $cy->cycle  }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label for="nationalite"
                                                                   class="form-label">Nationalité</label><select
                                                name="nationalite"
                                                id="nationalite"
                                                class="select2 form-control">
                                            @foreach($nationalites as $na)
                                                <option value="{{ $na->idPays }}">{{ $na->nationalite  }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button class="btn-primary btn">
                                Filtrer
                            </button>
                        </form>
                        <!-- datatable end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection