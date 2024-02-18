@if ($movie)

    <div class="card movie">
        <img src="{{ $movie->poster_image }}" class="card-img-top" alt="Movie poster for {{ $movie->title }}">
        <div class="card-body">
            <h3 class="card-title">{{ $movie->title }}</h3>
            <p class="card-text">{{ $movie->description }}</p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Year: {{ $movie->year }}</li>
            <li class="list-group-item">Director: {{ $movie->director_name }}</li>
        </ul>

        <div class="card-footer">
            <p class="card-text">Rating: {{ $movie->rating }}</p>
        </div>
    </div>

@endif
