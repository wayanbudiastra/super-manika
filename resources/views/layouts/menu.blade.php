<ul class="nav nav-primary">
    <li class="nav-item active">
        <a data-toggle="collapse" href="{{url('Dashboard')}}" class="collapsed" aria-expanded="false">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>	
        </a>
        
    </li>
    <li class="nav-section">
        <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section">Components</h4>
    </li>
    <li class="nav-item">
        <a data-toggle="collapse" href="#base">
            <i class="fas fa-layer-group"></i>
            <p>Master Data</p>
            <span class="caret"></span>
        </a>
        <div class="collapse" id="base">
            @include('layouts.menu.masterdata')
        </div>
    </li>
    
    <li class="nav-item">
        <a data-toggle="collapse" href="#sidebarLayouts">
            <i class="fas fa-th-list"></i>
            <p>Registrasi</p>
            <span class="caret"></span>
        </a>
        <div class="collapse" id="sidebarLayouts">
            @include('layouts.menu.registrasi')
        </div>
    </li>
    <li class="nav-item">
        <a data-toggle="collapse" href="#forms">
            <i class="fas fa-pen-square"></i>
            <p>Inventory</p>
            <span class="caret"></span>
        </a>
        <div class="collapse" id="forms">
            @include('layouts.menu.inventory')
        </div>
    </li>
    <li class="nav-item">
        <a data-toggle="collapse" href="#tables">
            <i class="fas fa-table"></i>
            <p>Keuangan</p>
            <span class="caret"></span>
        </a>
        <div class="collapse" id="tables">
           @include('layouts.menu.keuangan')
        </div>
    </li>

    <li class="nav-item">
        <a data-toggle="collapse" href="#charts">
            <i class="far fa-chart-bar"></i>
            <p>Pembayaran</p>
            <span class="caret"></span>
        </a>
        <div class="collapse" id="charts">
           @include('layouts.menu.pembayaran')
        </div>
    </li>
    <!-- <li class="nav-item">
        <a href="widgets.html">
            <i class="fas fa-desktop"></i>
            <p>Widgets</p>
            <span class="badge badge-success">4</span>
        </a>
    </li> -->
    <li class="nav-item">
        <a data-toggle="collapse" href="#submenu">
            <i class="fas fa-bars"></i>
            <p>Report</p>
            <span class="caret"></span>
        </a>
        <div class="collapse" id="submenu">
            @include('layouts.menu.report')
        </div>
    </li>
    
</ul>