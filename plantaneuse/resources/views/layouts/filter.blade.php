<div class="offcanvas offcanvas-start" style="font-size: 1.25rem;" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h1 class="offcanvas-title" id="offcanvasExampleLabel">Filtre</h1>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">

                <form action="{{ route('filter.exec') }}" method="post">
                    @csrf
                    <ul class="list-unstyled ps-0">

                        <!-- Type de plante -->
                        <li class="mb-1">
                            
                            <button type="button" type="button"
                                class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                                data-bs-target="#type-plante-collapse" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                </svg>
                                Type de plante
                            </button>

                            <div class="collapse" id="type-plante-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    @foreach ($types_plantes as $type_plante)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="type_de_plante[]"
                                                value="{{ $type_plante }}">
                                            <label class="form-check-label">{{ $type_plante }}</label>
                                        </div>
                                    @endforeach
                                </ul>
                            </div>
                        </li>

                        <!-- Niveau d'entretien -->
                        <li class="mb-1">
                            <button type="button" class="btn btn-toggle align-items-center rounded collapsed"
                                data-bs-toggle="collapse" data-bs-target="#niveau-entretien-collapse"
                                aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                </svg>
                                Niveau d'entretien
                            </button>
                            <div class="collapse" id="niveau-entretien-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    @foreach ($niveaux_entretien as $niveau_entretien)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="niveau_entretien[]"
                                                value="{{ $niveau_entretien }}">
                                            <label class="form-check-label">{{ $niveau_entretien }}</label>
                                        </div>
                                    @endforeach
                                </ul>
                            </div>
                        </li>

                        <!-- Taille -->
                        <li class="mb-1">
                            <button type="button" class="btn btn-toggle align-items-center rounded collapsed"
                                data-bs-toggle="collapse" data-bs-target="#taille-collapse" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                </svg>
                                Taille
                            </button>
                            <div class="collapse" id="taille-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    @foreach ($tailles as $taille)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="taille[]"
                                                value="{{ $taille }}">
                                            <label class="form-check-label">{{ $taille }}</label>
                                        </div>
                                    @endforeach
                                </ul>
                            </div>
                        </li>

                        <!-- Besoin en lumière -->
                        <li class="mb-1">
                            <button type="button" class="btn btn-toggle align-items-center rounded collapsed"
                                data-bs-toggle="collapse" data-bs-target="#besoin-lumiere-collapse"
                                aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                </svg>
                                Besoin en lumière
                            </button>
                            <div class="collapse" id="besoin-lumiere-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    @foreach ($besoins_lumiere as $besoin_lumiere)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="besoin_lumiere[]"
                                                value="{{ $besoin_lumiere }}">
                                            <label class="form-check-label">{{ $besoin_lumiere }}</label>
                                        </div>
                                    @endforeach
                                </ul>
                            </div>
                        </li>

                        <!-- Couleur -->
                        <li class="mb-1">
                            <button type="button" class="btn btn-toggle align-items-center rounded collapsed"
                                data-bs-toggle="collapse" data-bs-target="#couleur-collapse" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                </svg>
                                Couleur
                            </button>
                            <div class="collapse" id="couleur-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    @foreach ($couleurs as $couleur)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="couleur[]"
                                                value="{{ $couleur }}">
                                            <label class="form-check-label">{{ $couleur }}</label>
                                        </div>
                                    @endforeach
                                </ul>
                            </div>
                        </li>

                        <!-- Saisonnalité -->
                        <li class="mb-1">
                            <button type="button" class="btn btn-toggle align-items-center rounded collapsed"
                                data-bs-toggle="collapse" data-bs-target="#saisonnalite-collapse"
                                aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                </svg>
                                Saisonnalité
                            </button>
                            <div class="collapse" id="saisonnalite-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    @foreach ($saisonnalites as $saisonnalite)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="saisonnalite[]"
                                                value="{{ $saisonnalite }}">
                                            <label class="form-check-label">{{ $saisonnalite }}</label>
                                        </div>
                                    @endforeach
                                </ul>
                            </div>
                        </li>

                        <!-- Origine -->
                        <li class="mb-1">
                            <button type="button" class="btn btn-toggle align-items-center rounded collapsed position-relative"
                                data-bs-toggle="collapse" data-bs-target="#origine-collapse" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down"
                                    viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                </svg>
                                Origine
                            </button>
                            <div class="collapse" id="origine-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    @foreach ($origines as $origine)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="origine[]" value="{{ $origine }}">
                                            <label class="form-check-label">{{ $origine }}</label>
                                        </div>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        
                        

                        <!-- Prix -->
                        <li class="mb-1">
                            <button type="button" class="btn btn-toggle align-items-center rounded collapsed"
                                data-bs-toggle="collapse" data-bs-target="#prix-collapse" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                </svg>
                                Prix
                            </button>
                            <div class="collapse" id="prix-collapse">
                                <div>
                                    <div>
                                        <label for="prix_min">Prix minimum :</label>
                                        <input type="text" name="prix_min" id="prix_min" value="{{ $prix_min }}" min="{{ $prix_min }}"><br>
                                        <label for="prix_max">Prix maximum :</label>
                                        <input type="text" name="prix_max" id="prix_max"
                                            value="{{ $prix_max }}" min="{{ $prix_max }}">

                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <button type="submit" class="option-btn">Appliquer Filtrer</button>
                </form>
            </div>
        </div>