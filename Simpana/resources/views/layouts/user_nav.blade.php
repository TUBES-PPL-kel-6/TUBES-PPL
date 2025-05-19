<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('user.pinjaman.*') ? 'active' : '' }}" href="{{ route('user.pinjaman.index') }}">
        <i class="fas fa-money-bill-wave"></i>
        <span>Pinjaman</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('user.riwayat-pinjaman.*') ? 'active' : '' }}" href="{{ route('user.riwayat-pinjaman.index') }}">
        <i class="fas fa-history"></i>
        <span>Riwayat Pinjaman</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('user.riwayat-simpanan.*') ? 'active' : '' }}" href="{{ route('user.riwayat-simpanan.index') }}">
        <i class="fas fa-history"></i>
        <span>Riwayat Simpanan</span>
    </a>
</li> 