<style>

  .m-header span {
    color: #6C63FF;
  }

  .lumora {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .logo_lumora {
    width: 40px;
    height: 40px;
  }

  .judul {
    margin-top: 10px;
  }

</style>

<div>
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
          <div class="m-header">
            <a href="../dashboard/index.html" class="b-brand text-primary">
              <!-- ========   Change your logo from here   ============ -->
              <span class="lumora">
                <img src="{{ asset('storage/logo.jpg') }}" alt="Foto_logo" class="logo_lumora">
                <h3 class="judul">LumoraVote</h3>
              </span>
          </a>
          </div>
          <div class="navbar-content">
            <ul class="pc-navbar">
                <x-sidebar.links title="Dashboard" icon="ti ti-dashboard" route="home" />
                @if(Auth::check() && Auth::user()->role->role_name == 'admin')
                  <x-sidebar.links title="Data Users" icon="ti ti-user" route="users.index" />
                  <x-sidebar.links title="Data Kandidat" icon="ti ti-users" route="kandidat.index" />
                  <x-sidebar.links title="Voting" icon="ti ti-check" route="voting.index" />
                @else 
                  <x-sidebar.links title="Data Kandidat" icon="ti ti-users" route="kandidat.index" />
                  <x-sidebar.links title="Data Profile" icon="ti ti-user" route="profile.index" />
                @endif
                {{-- @if (Auth::user()->role->role_name == 'user')
                  <x-sidebar.links title="Data Kandidat" icon="ti ti-users" route="kandidat.index" />
                  <x-sidebar.links title="Voting" icon="ti ti-check" route="voting.index" />
                @endif --}}
            </ul>
          </div>
        </div>
    </nav>
</div>