
<div class="d-flex flex-column flex-shrink-0 p-3 bg-light">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
    <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
    <span class="fs-4">Sidebar</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <!-- bikin session biar tahu mana yg active -->
    <li class="nav-item">
        <a href="{{route('user_show', ['user'=>Auth::user()->id])}}" class="nav-link link-dark active" aria-current="page">
        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
        Profile
        </a>
    </li>
    <li>
        <a href="{{route('user_friend', ['user'=>Auth::user()->id])}}" class="nav-link link-dark">
        <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
        Friends
        </a>
    </li>
    <li>
        <a href="{{route('user_transaction', ['user'=>Auth::user()->id])}}" class="nav-link link-dark">
        <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
        Transaction History
        </a>
    </li>
    </ul>
</div>
