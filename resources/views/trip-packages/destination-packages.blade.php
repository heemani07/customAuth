<x-master title="trip-packages">
<section class="py-5">
    <div class="container">

        <h2 class="text-center fw-bold mb-4">
            Packages for {{ $destination->name }}
        </h2>

        @if($packages->count() == 0)
            <p class="text-center text-muted">No packages available for this destination.</p>
        @endif

        <div class="row g-4">
            @foreach($packages as $package)
                <div class="col-md-4">
                    <div class="card h-100 shadow border-0">

                        <!-- Package Image -->
                        <img src="{{ asset($package->image) }}"
                             class="card-img-top"
                             style="height: 220px; object-fit: cover;"
                             alt="{{ $package->title }}">

                        <div class="card-body">

                            <h5 class="card-title">{{ $package->title }}</h5>



                            <p class="card-text">
                                {!! $package->description !!}
                            </p>

                            <p class="fw-bold text-primary">
                                ₹{{ number_format($package->price) }}
                            </p>

                            <a href="{{ route('packages.show', $package->id) }}"
                               class="btn btn-outline-primary btn-sm">
                                View Details
                            </a>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
</x-master>
