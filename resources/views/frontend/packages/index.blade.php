<x-master title="View-packages">

<div class="container py-5">
    <h2 class="mb-4">{{ $destination->name }} Packages</h2>

    <div class="row">
        @foreach($packages as $package)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">

                    @if($package->images->count())
                        <img src="{{ asset('storage/' . $package->images->first()->image) }}"
                             class="card-img-top" height="200">
                    @else
                        <img src="/default.jpg" class="card-img-top" height="200">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $package->title }}</h5>

                        <p class="text-muted">{!! ($package->description) !!}</p>

                        <a href="{{ route('packages.show', $package->id) }}"
                           class="btn btn-primary">
                            View Details
                        </a>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>
</x-master>

