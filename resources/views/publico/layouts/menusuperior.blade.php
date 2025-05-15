<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('morador.feed') }}">PIGC</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('morador.feed') ? 'active' : '' }}" href="{{ route('morador.feed') }}">Feed</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('morador.votacao') ? 'active' : '' }}" href="{{ route('morador.votacao') }}">Votação</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('morador.ocorrencia.index') ? 'active' : '' }}" href="{{ route('morador.ocorrencia.index') }}"> Minhas Ocorrências</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('morador.perfil') ? 'active' : '' }}" href="{{ route('morador.perfil') }}">Perfil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<style>
/* Ensure navbar has a fixed, solid background */
.navbar {
    background-color: #f8f9fa !important; /* Matches Bootstrap's bg-light */
}

/* Ensure collapsed menu has the same fixed background on mobile */
.navbar-collapse {
    background-color: #f8f9fa; /* Solid background for collapsed menu */
}

/* Non-hovered, non-selected nav items */
.navbar-light .navbar-nav .nav-link {
    color: #333333; /* Dark gray for visibility */
}

/* Hovered nav items */
.navbar-light .navbar-nav .nav-link:hover {
    color: #007bff; /* Blue for hover */
    background-color: #e9ecef; /* Light gray for hover */
}

/* Active/selected nav items */
.navbar-light .navbar-nav .nav-link.active {
    color: #0056b3; /* Darker blue for active */
    font-weight: bold; /* Bold for emphasis */
    background-color: #e9ecef; /* Light gray for active */
}

/* Media query for collapsed menu on smaller screens */
@media (max-width: 991px) {
    .navbar-collapse {
        padding: 10px; /* Optional padding for collapsed menu */
    }
    .navbar-nav .nav-link {
        padding: 10px 15px; /* Spacing for nav items in collapsed menu */
    }
}
</style>