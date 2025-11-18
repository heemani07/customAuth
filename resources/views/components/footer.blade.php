<footer class="bg-dark text-white py-4">
    <div class="container">
        <div class="row">

            <div class="col-md-4">
                <h5>Top Destinations</h5>
                <ul class="list-unstyled">
                    @foreach($destinations->take(4) as $dest)
                        <li>
                            <a href="{{ route('destinations.show', $dest->id) }}"
                               class="text-white text-decoration-none">
                                {{ $dest->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-8 text-end">
                <p class="mb-0">&copy; {{ date('Y') }} Travel Explorer. All rights reserved.</p>
            </div>

        </div>
    </div>
</footer>
