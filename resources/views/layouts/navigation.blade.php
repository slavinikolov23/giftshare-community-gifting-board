<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('items.index') }}">
            <i class="bi bi-gift-fill me-2"></i>GiftShare
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('items.index') ? 'active' : '' }}" href="{{ route('items.index') }}">
                        <i class="bi bi-list-ul me-1"></i>Всички обяви
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('items.mine') ? 'active' : '' }}" href="{{ route('items.mine') }}">
                        <i class="bi bi-person-lines-fill me-1"></i>Моите обяви
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('items.create') ? 'active' : '' }}" href="{{ route('items.create') }}">
                        <i class="bi bi-plus-circle me-1"></i>Създай обява
                    </a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-gear me-2"></i>Профил
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-2"></i>Изход
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
