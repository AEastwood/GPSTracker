<div id="myAssetsTools" class="dropdown">

    <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" title="View/Search My Assets" class="p-0 mr-2 btn">
        <span class="icon-wrapper">
            <span class="icon-wrapper-bg"></span>
            <i class="fas fa-car"></i>

        </span>
    </button>

    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-358px, 46px, 0px); top: 0px; left: 0px; will-change: transform;">

        <div class="dropdown-menu-header">
            <div class="dropdown-menu-header-inner bg-midnight-bloom">
                <div class="menu-header-image" style="background-image: url('{{ asset('/imgs/architect/dropdown-header/abstract2.jpg') }}');">
                </div>
                <div class="menu-header-content text-white">
                    <h5 class="menu-header-title noselect">My Assets</h5>
                </div>
            </div>
        </div>

        <div class="grid-menu grid-menu-xl grid-menu-3col">
            <ul class="todo-list-wrapper list-group list-group-flush">
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">

                            <div id="search-wrapper-box" class="pb-2 pt-2">
                                <div class="search-wrapper active">
                                <div class="input-holder pull-right">
                                    <input type="text" class="search-input" id="assetSearchBox" maxlength="30" placeholder="Make, model etc." autocomplete="off">
                                    <button class="search-icon" id="assetSearchButton"><span></span></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </li>
            </ul>
            <div class="scroll-area-sm">
                <div class="scrollbar-container ps--active-y ps">
                    <ul class="todo-list-wrapper list-group list-group-flush" id="searchAssetsList">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>