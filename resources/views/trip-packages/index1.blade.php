<x-master title="Trip Packages">
    <x-top-bar />

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold">Trip Packages</h2>
            <a href="{{ route('trip-packages.create') }}" class="btn btn-primary">
                + Add New Package
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($packages->count())
            <div class="row g-4">
                @foreach($packages as $package)
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 h-100">
                            {{-- Cover Image --}}
                            @php
                                $cover = $package->images->first()->image ?? 'default.jpg';
                            @endphp
                            <img src="{{ asset('storage/' . $cover) }}" class="card-img-top" alt="{{ $package->title }}" style="height: 220px; object-fit: cover; border-top-left-radius: .5rem; border-top-right-radius: .5rem;">

                            <div class="card-body d-flex flex-column">
                                {{-- Title --}}
                                <h5 class="card-title fw-semibold text-primary">{{ $package->title }}</h5>

                                {{-- Overview (short preview) --}}
                                <p class="card-text text-muted small mb-3">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($package->overview), 100, '...') }}
                                </p>

                                {{-- Destination + Category --}}
                                <p class="small text-secondary mb-3">
                                    <strong>Destination:</strong> {{ $package->destination->name ?? 'N/A' }}<br>
                                    <strong>Category:</strong> {{ $package->category->category_name ?? 'N/A' }}
                                </p>

                                <div class="mt-auto d-flex justify-content-between">
                                    {{-- Edit --}}
                                    <a href="{{ route('trip-packages.edit', $package->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>

                                    {{-- View --}}
                                    <a href="{{ route('trip-packages.show', $package->id) }}" class="btn btn-sm btn-outline-success">
                                        <i class="fa fa-eye"></i> View
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('trip-packages.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this package?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $packages->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5">
                <h5>No trip packages found.</h5>
                <a href="{{ route('trip-packages.create') }}" class="btn btn-primary mt-3">Add Your First Package</a>
            </div>
        @endif
    </div>
</x-master>
