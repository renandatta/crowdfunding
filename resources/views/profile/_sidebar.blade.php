<nav class="account-bar">
    <ul>
        <li class="{{ $menu_active == 'profile' ? 'active' : '' }}"><a href="{{ route('profile') }}">Profil</a></li>
        <li class="{{ $menu_active == 'donation' ? 'active' : '' }}"><a href="{{ route('donation_history') }}">Riwayat Donasi</a></li>
        <li class="{{ $menu_active == 'discussion' ? 'active' : '' }}"><a href="{{ route('discussion_history') }}">Riwayat Diskusi</a></li>
    </ul>
</nav>
