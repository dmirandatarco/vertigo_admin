<nav class="sidebar">
  <div class="sidebar-header">
    <a href="/" class="sidebar-brand">
      <img  style="height: 2.8rem;" src="{{asset('img/logo.png')}}" alt="logo">
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item nav-category">Menu</li>
      <li class="nav-item {{ active_class(['dashboard']) }}">
        @can('dashboard')
        <a href="{{ url('dashboard') }}" class="nav-link">
          <i class="link-icon" data-feather="activity"></i>
          <span class="link-title">Dashboard</span>
        </a>
        @endcan
      </li>
      
      @if( Gate::check('categoria.index') || Gate::check('ubicacion.index') || Gate::check('proveedor.index') )
      <li class="nav-item {{ active_class(['mantenimientoweb/*']) }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#mantenimientoweb" role="button" aria-expanded="{{ is_active_route(['mantenimientoweb/*']) }}" aria-controls="mantenimientoweb">
          <i class="link-icon mdi mdi-cash-multiple" ></i>
          <span class="link-title">Mantenimiento Web</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['mantenimientoweb/*']) }}" id="mantenimientoweb">
          <ul class="nav sub-menu">

          @can('categoria.index')
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/categoria') }}" class="nav-link {{ active_class(['mantenimientoweb/categoria']) }}">Categorias</a>
            </li>
            @endcan
            @can('ubicacion.index')
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/ubicacion') }}" class="nav-link {{ active_class(['mantenimientoweb/ubicacion']) }}">Ubicaciones</a>
            </li>
            @endcan
            @can('tour.index')
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/tour') }}" class="nav-link {{ active_class(['mantenimientoweb/tour','mantenimientoweb/tour/*']) }}">Tours</a>
            </li>
            @endcan
            @can('whatsapp.index')
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/whatsapp') }}" class="nav-link {{ active_class(['mantenimientoweb/whatsapp','mantenimientoweb/whatsapp/*']) }}">Whatsapp</a>
            </li>
            @endcan
            @can('language.index')
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/idioma') }}" class="nav-link {{ active_class(['mantenimientoweb/idioma','mantenimientoweb/idioma/*']) }}">Idiomas</a>
            </li>
            @endcan
            @can('comentario.index')
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/comentario') }}" class="nav-link {{ active_class(['mantenimientoweb/comentario','mantenimientoweb/comentario/*']) }}">Comentarios</a>
            </li>
            @endcan
            @can('paqueteweb.index')
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/paquete') }}" class="nav-link {{ active_class(['mantenimientoweb/paquete','mantenimientoweb/paquete/*']) }}">Paquete</a>
            </li>
            @endcan
            @can('menu.index')
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/menu') }}" class="nav-link {{ active_class(['mantenimientoweb/menu','mantenimientoweb/menu/*']) }}">Menus</a>
            </li>
            @endcan
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/cabecera') }}" class="nav-link {{ active_class(['mantenimientoweb/cabecera','mantenimientoweb/cabecera/*']) }}">Cabecera</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/nosotros/') }}" class="nav-link {{ active_class(['mantenimientoweb/nosotros','mantenimientoweb/nosotros/*']) }}">Nosotros</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/certificados/') }}" class="nav-link {{ active_class(['mantenimientoweb/certificados','mantenimientoweb/certificados/*']) }}">Certificados</a>
            </li>
            @can('blog.index')
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/blog') }}" class="nav-link {{ active_class(['mantenimientoweb/blog']) }}">Blog</a>
            </li>
            @endcan
          </ul>
        </div>
      </li>
      @endif
     
    </ul>
  </div>
</nav>
