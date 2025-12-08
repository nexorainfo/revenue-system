<div class="left-side-menu">
    <div class="h-100" data-simplebar>
        <div id="sidebar-menu">
            <x-logged-in-user-component/>
            <ul id="side-menu">

                    @includeIf('admin.layouts.sidebar')

            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
