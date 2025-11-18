<section id="destinations" class="py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">Popular Destinations</h2>

        <div class="row g-4">
            @foreach($destinations as $destination)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">

                        <img src="{{ asset($destination->image) }}" class="card-img-top">

                        <div class="card-body">
                            <h5 class="card-title">{{ $destination->name }}</h5>
                            <p class="text-muted small">{{ $destination->country }}</p>

                            <p class="card-text">
                                {{ Str::limit(strip_tags($destination->description), 100) }}
                            </p>

                            <a href="{{ route('packages.index', $destination->id) }}" class="btn btn-primary">
                                View Packages
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
