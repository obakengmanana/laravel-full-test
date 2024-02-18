
<nav class="navbar shadow">
    <div class="container-fluid">
        <form id="searchForm" action="{{ route('search') }}" method="GET">
            <input type="text" id="searchInput" name="query" class="form-control" placeholder="Search...">
        </form>
    </div>
</nav>
