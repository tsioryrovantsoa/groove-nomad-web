@extends('layouts.app')

@section('title', 'Toutes les demandes de devis')

@section('content')
    {{-- 🎵 Préférences utilisateur --}}
    @if($userPreferences)
        <div class="col-lg-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="fa fa-music mr-2"></i>Mes Préférences
                    </h5>
                </div>
                
                <div class="card-body p-3">
                    <div class="row">
                        {{-- Genres musicaux --}}
                        @if($userPreferences->musicGenres->count() > 0)
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-headphones text-primary mr-2"></i>
                                    <h6 class="mb-0 text-muted">Genres Musicaux</h6>
                                </div>
                                <div class="tags-container">
                                    @foreach($userPreferences->musicGenres as $genre)
                                        <span class="tag tag-music">{{ $genre->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Goûts culturels --}}
                        @if($userPreferences->culturalTastes->count() > 0)
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-globe text-secondary mr-2"></i>
                                    <h6 class="mb-0 text-muted">Goûts Culturels</h6>
                                </div>
                                <div class="tags-container">
                                    @foreach($userPreferences->culturalTastes as $taste)
                                        <span class="tag tag-culture">{{ $taste->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Phobies --}}
                        @if($userPreferences->phobias->count() > 0)
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-exclamation-triangle text-warning mr-2"></i>
                                    <h6 class="mb-0 text-muted">Phobies</h6>
                                </div>
                                <div class="tags-container">
                                    @foreach($userPreferences->phobias as $phobia)
                                        <span class="tag tag-phobia">{{ $phobia->description }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Allergies --}}
                        @if($userPreferences->allergies->count() > 0)
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-exclamation-circle text-danger mr-2"></i>
                                    <h6 class="mb-0 text-muted">Allergies</h6>
                                </div>
                                <div class="tags-container">
                                    @foreach($userPreferences->allergies as $allergy)
                                        <span class="tag tag-allergy">{{ $allergy->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Liste des demandes --}}
    <livewire:request-list />
@endsection
