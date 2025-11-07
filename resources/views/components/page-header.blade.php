<div class="card-header d-flex justify-content-between align-items-center">
    <h1 class="h4 mb-0">{{ $title }}</h1>

    @if ($buttonValue)
        <a href="{{ $route }}" class="btn btn-primary btn-sm">
            + Add {{ $buttonValue }}
        </a>
    @endif
</div>
