<?php

use App\User;

$notifications = User::find(Auth::user()->id)->notifications;
$notificationCount = $notifications->count();

?>

<div class="header-btn-lg pr-0">
    <div class="widget-content p-0">
        <div class="widget-content-wrapper">
            <div class="widget-content-left">

                <div class="btn-group">

                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                        @auth
                        <img width="42" class="rounded-circle" src="/imgs/userprofilepics/{{ Auth::user()->display_image }}" alt="">
                        @endauth
                        <i class="fa fa-angle-down ml-2 opacity-8"></i>
                    </a>

                    <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">

                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-dark">
                                <div class="menu-header-image " style="background-image: url('{{ asset('imgs/architect/dropdown-header/abstract2.jpg') }}');">
                                </div>
                                <div class="menu-header-content text-left">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">
                                                @auth
                                                <img width="42" class="rounded-circle" src="/imgs/userprofilepics/{{ Auth::user()->display_image }}" alt="">
                                                @endauth
                                            </div>
                                            <div class="widget-content-left">
                                                @auth

                                                <div class="widget-heading">
                                                    {{ ucwords(Auth::user()->name) }}
                                                </div>
                                                <div class="widget-subheading opacity-8">{{ Auth::user()->email }}</div>

                                                @endauth
                                            </div>
                                            <div class="widget-content-right mr-2">
                                                <form action="{{ route('logout') }}" method="post">
                                                    <button type="submit" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="mb-2 mr-2 btn btn-warning">Logout
                                                    </button>
                                                </form>
                                            </div>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="scroll-area-xs" style="height: 150px;">
                            <div class="scrollbar-container ps ps--active-y">
                                <ul class="nav flex-column">

                                    <li class="nav-item-header nav-item">My Account</li>
                                    <li class="nav-item">
                                        <a href="/shop" class="nav-link">Shop
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/notifications" class="nav-link">Notifications
                                            <div class="ml-auto badge @if($notificationCount < 1) badge-success @else badge-warning @endif">{{ $notificationCount }}</div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/logs" class="nav-link">Logs
                                        </a>
                                    </li>
                                </ul>
                            <div class="ps__rail-x" style="left: 0px; bottom: -90px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 90px; right: 0px; height: 150px;"><div class="ps__thumb-y" tabindex="0" style="top: 54px; height: 89px;"></div></div></div>
                        </div>

                        <div class="grid-menu grid-menu-2col">
                            <div class="no-gutters row">
                                <div class="col-sm-6">
                                    <form action="{{ route('profile') }}" method="get">
                                        <button type="submit" class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-info">
                                            <i class="fas fa-user-cog btn-icon-wrapper mb-2"></i>
                                            Account Settings
                                        </button>
                                    </form>
                                </div>
                                <div class="col-sm-6">
                                    <form action="" method="get">
                                        <button type="submit" class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-danger">
                                            <i class="fas fa-question btn-icon-wrapper mb-2"></i>
                                            <b>Support</b>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>

                        @if(Auth::user()->admin)
                        <ul class="nav flex-column">
                            <li class="nav-item-divider nav-item"></li>
                            <li class="nav-item-btn text-center nav-item">
                                <button class="btn-block btn btn-danger btn-sm" onclick="window.location.href='/admin/home'">Administration Panel</button>
                            </li>
                        </ul>
                        @endif

                    </div>
                </div>
            </div>
            <div class="widget-content-left ml-3 header-user-info ">
                <div class="widget-heading ">
                    @auth
                    {{ ucwords(Auth::user()->name) }}
                    @endauth
                </div>
                @auth
                <div class="widget-subheading">
                @if(Auth::user()->admin)
                    <span class="badge badge-warning">Administrator</span>
                @else
                    <div class="widget-subheading opacity-8">{{ Auth::user()->email }}</div>
                @endif
                </div>
                @endauth
            </div>
        </div>
    </div>
</div>