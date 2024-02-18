@php /** @var \Illuminate\Pagination\LengthAwarePaginator $movies**/ @endphp

<div class="container">
    <h1 class="mt-5 mb-3">Movies</h1>
    <div class="card-list row mb-3">
        @foreach($movies as $movie)
            <div class="col col-md-3 mb-3">
                @include('components.movie', $movie)
            </div>
        @endforeach
    </div>
    <div class="pagination row mb-5">
        {{ $movies->onEachSide(2)->links() }}
    </div>
</div>
