<div class="header-btn-lg pr-0">
    <div class="widget-content p-0">
        <div class="widget-content-wrapper">
            <div class="widget-content-left">
                <div id="navbarAppMenu" class="dropdown">

                    <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="p-0 mr-2 btn">
                        <span class="icon-wrapper">
                            <span class="icon-wrapper-bg"></span>
                            <i class="fas fa-th noSelect"></i>
                        </span>
                    </button>

                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-358px, 46px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-midnight-bloom">
                                <div class="menu-header-image" style="background-image: url('{{ asset('/imgs/architect/dropdown-header/abstract2.jpg') }}');">
                                </div>
                                <div class="menu-header-content text-white">
                                    <h5 class="menu-header-title noselect">Navigation</h5>
                                </div>
                            </div>
                        </div>
                        <div class="grid-menu grid-menu-xl grid-menu-3col">
                            <div class="no-gutters row">
                                <div class="col-sm-6 col-xl-4">
                                    <button onclick="window.location.href = '/home';" class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                        <i
                                            class="fas fa-home icon-gradient bg-asteroid btn-icon-wrapper btn-icon-lg mb-3"></i>
                                        Home
                                    </button>
                                </div>
                                <div class="col-sm-6 col-xl-4">
                                    <button onclick="window.location.href = '/map';" class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                        <i
                                            class="fas fa-map-marked-alt icon-gradient bg-asteroid btn-icon-wrapper btn-icon-lg mb-3"></i>
                                        Tracker
                                    </button>
                                </div>
                                <div class="col-sm-6 col-xl-4">
                                    <button onclick="window.location.href = '/mot';" class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                        <i
                                            class="fas fa-car-alt icon-gradient bg-asteroid btn-icon-wrapper btn-icon-lg mb-3"></i>
                                        @auth
                                        @if(Auth::user()->mot_enabled)
                                        My MOT Centre
                                        @else
                                        Book an MOT
                                        @endif
                                        @endauth
                                    </button>
                                </div>
                                <div class="col-sm-6 col-xl-4">
                                    <button onclick="window.location.href = '/assets';" class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                        <i
                                            class="fas fa-dolly icon-gradient bg-asteroid btn-icon-wrapper btn-icon-lg mb-3"></i>
                                        Assets
                                    </button>
                                </div>
                                <div class="col-sm-6 col-xl-4">
                                    <button onclick="window.location.href = '/statistics';" class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                        <i
                                            class="fas fa-chart-line icon-gradient bg-asteroid btn-icon-wrapper btn-icon-lg mb-3"></i>
                                        Statistics
                                    </button>
                                </div>
                                <div class="col-sm-6 col-xl-4">
                                    <button onclick="window.location.href = '/invoices';" class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                        <i
                                            class="fas fa-pound-sign icon-gradient bg-asteroid btn-icon-wrapper btn-icon-lg mb-3"></i>
                                        Invoices
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>