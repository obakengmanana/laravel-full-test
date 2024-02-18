<!-- As a heading -->
<nav class="navbar shadow">
    <div class="container-fluid">
        <a class="navbar-brand mb-0 h1" href="#">
            <img src="{{ Vite::asset('resources/assets/brave.png') }}" alt="Brave Logo" />
        </a>

        <!-- Search bar component -->
        <form id="searchForm" action="{{ route('search') }}" method="GET" class="d-flex">
            <input type="text" id="searchInput" name="query" class="form-control me-2 typeahead" placeholder="SEARCH MOVIES">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
</nav>
