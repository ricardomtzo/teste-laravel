<ul class="nav flex-column nav-pills pb-3 p-3 bg-dark text-white mb-3 " style="height: 100vh" data-bs-theme="dark" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link bg-grey {{ Request::is('dashboard') ? 'active' : '' }}" id="pills-home-tab" data-toggle="pill" href="/dashboard" role="tab" aria-controls="pills-home" aria-selected="true">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::is('users') ? 'active' : '' }}" id="pills-profile-tab" data-toggle="pill" href="/users" role="tab" aria-controls="pills-profile" aria-selected="false">Usuários</a>
    </li>
</ul>
<div class="tab-content" id="pills-tabContent">
</div>

