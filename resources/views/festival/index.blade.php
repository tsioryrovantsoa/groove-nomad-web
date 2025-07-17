@extends('layouts.app')

@section('title', 'Festival')

@section('content')
    <div class="row">
        @foreach ($festivals as $festival)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="event__item">
                    <div class="event__item__pic set-bg"
                        data-setbg="https://picsum.photos/seed/festival{{ $festival->id }}/600/400">
                        <div class="tag-date">
                            <span>{{ \Carbon\Carbon::parse($festival->startDate)->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="event__item__text">
                        <h4>{{ $festival->name }}</h4>
                        <p>
                            <i class="fa fa-map-marker"></i> {{ $festival->location }},
                            {{ $festival->region }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $festivals->links() }}
    </div>
@endsection
