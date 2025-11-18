<x-master title="view packages">
<div class="container py-5">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('packages.index', $package->destination_id) }}">
                    {{ $package->destination->name }} Packages
                </a>
            </li>
            <li class="breadcrumb-item active">{{ $package->title }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-7">

            {{-- Image Slider --}}
            @if($package->images->count())
                <div id="packageSlider" class="carousel slide mb-4">
                    <div class="carousel-inner">
                        @foreach($package->images as $index => $img)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $img->image) }}"
                                     class="d-block w-100 rounded"
                                     style="max-height: 380px; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
<button class="carousel-control-prev" type="button" data-bs-target="#packageSlider" data-bs-slide="prev">
    <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
</button>

<button class="carousel-control-next" type="button" data-bs-target="#packageSlider" data-bs-slide="next">
    <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
</button>

                </div>
            @else
                <img src="/default.jpg" class="w-100 rounded mb-4">
            @endif

        </div>

        <div class="col-md-5">

            <h2 class="mb-3">{{ $package->title }}</h2>

            <p class="text-muted mb-3">
                {{ $package->destination->name }} •
                {{ $package->category->name ?? 'Package' }}
            </p>

            <h5 class="fw-bold">Overview</h5>
            <p>{!! ($package->overview) !!}</p>

            <hr>

            <h5 class="fw-bold">Inclusions</h5>
            @if($package->inclusions)
                <ul>
                    @foreach($package->inclusions as $inc)
                        <li>{{ $inc }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">No inclusions added.</p>
            @endif

            <div class="mt-4">
                <a href="#enquiry" class="btn btn-primary px-4 py-2">Enquire Now</a>
            </div>

        </div>
    </div>

    <hr class="my-5">

    {{-- Itinerary --}}
    <div class="mb-5">
        <h3 class="mb-3">Itinerary</h3>
        <div class="border rounded p-3 bg-light">
            {!! $package->itinerary !!}
        </div>
    </div>

    {{-- T&C --}}
    <div class="mb-5">
        <h3 class="mb-3">Terms & Conditions</h3>
        <div class="border rounded p-3 bg-light">
            {!! $package->terms_and_conditions !!}
        </div>
    </div>

    {{-- Enquiry Section --}}
    <!-- <div id="enquiry" class="p-4 bg-white shadow rounded">
        <h4 class="mb-3">Send an Enquiry</h4>

        <form>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <input type="text" class="form-control" placeholder="Your Name">
                </div>
                <div class="col-md-6 mb-3">
                    <input type="email" class="form-control" placeholder="Your Email">
                </div>
            </div>

            <div class="mb-3">
                <textarea class="form-control" rows="4" placeholder="Your Message"></textarea>
            </div>

            <button class="btn btn-success px-4">Submit</button>
        </form>
    </div> -->

</div>
</x-master>
