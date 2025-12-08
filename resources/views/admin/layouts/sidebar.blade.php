<li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
    <a href="{{ route('admin.dashboard') }}">
        <i class="fa fa-home"></i>
        <span> गृहपृष्ठ </span>
    </a>
</li>
@can('invoice_access')
    <li class="{{request()->routeIs('admin.revenue.invoice.*') ? 'active' : ''}}">
        <a href="{{route('admin.revenue.invoice.index')}}">
            <i class="fa fa-money-bill"></i>
            <span>रसिद</span>
        </a>
    </li>
@endcan
<li class="{{request()->is('admin/revenue/report*') ? 'active' : ''}}">
    <a href="#sidebarRevenueReport"
       {{request()->is('admin/revenue/report*') ? 'aria-expanded=true' : ''}}
       data-bs-toggle="collapse">
        <i class="fa fa-clipboard-list"></i>
        <span>रिपोर्ट</span>
        <span class="menu-arrow">
            <i class="fas fa-angle-right"></i>
        </span>
    </a>
    <div class="collapse {{request()->is('admin/revenue/report*') ? 'show' : ''}}"
         id="sidebarRevenueReport">
        <ul class="nav-second-level">
            <li class="{{request()->is('admin/revenue/report') ? 'active' : ''}}">
                <a href="{{route('admin.revenue.report.index')}}">
                    <span>बिलहरु</span>
                </a>
            </li>
            <li class="{{request()->is('admin/revenue/report/invoice') ? 'active' : ''}}">
                <a href="{{route('admin.revenue.report.invoice')}}">
                    <span>वडा अनुसार रसिद</span>
                </a>
            </li>
            <li class="{{request()->is('admin/revenue/report/word-wise-invoice') ? 'active' : ''}}">
                <a href="{{route('admin.revenue.report.word-wise-invoice')}}">
                    <span>वडा अनुसार राजस्व</span>
                </a>
            </li>
            <li class="{{request()->is('admin/revenue/report/tax-payer') ? 'active' : ''}}">
                <a href="{{route('admin.revenue.report.tax-payer')}}">
                    <span>करदाताको प्रकार</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li
    class="{{ request()->is('admin/generalSetting*') || request()->is('admin/generalSetting*') ? 'active' : '' }}">
    <a href="#generalSetting"
       {{ request()->is('admin/generalSetting*') || request()->is('admin/generalSetting*') ? 'aria-expanded=true' : '' }}
       data-bs-toggle="collapse">
        <i class="fa fa-cog"></i>
        <span>सामान्य सेटिङ </span>
        <span class="menu-arrow"><i class="fas fa-angle-right"></i></span>
    </a>
    <div class="collapse {{ request()->is('admin/generalSetting*') || request()->is('admin/generalSetting*') ? 'show' : '' }}"
         id="generalSetting">
        <ul class="nav-second-level">
            @can('fiscalYear_access')
                <li class="{{ request()->is('admin/generalSetting/fiscalYear*') ? 'active' : '' }}">
                    <a href="{{ route('admin.generalSetting.fiscalYear.index') }}">
                        <span> आर्थिक बर्ष थप्नुहोस्</span>
                    </a>
                </li>
            @endcan
                @can('revenueCategory_access')
                    <li class="{{request()->routeIs('admin.generalSetting.revenue-category.*') ? 'active' : ''}}">
                        <a href="{{route('admin.generalSetting.revenue-category.index')}}">
                            <span>राजस्वको वर्ग</span>
                        </a>
                    </li>
                @endcan
                @can('revenue_access')
                    <li class="{{request()->routeIs('admin.generalSetting.revenue.*') ? 'active' : ''}}">
                        <a href="{{route('admin.generalSetting.revenue.index')}}">
                            <span>राजस्वको शिर्षक</span>
                        </a>
                    </li>
                @endcan
        </ul>
    </div>
</li>
<li
    class="{{ request()->is('admin/systemSetting*') || request()->is('admin/systemSetting*') ? 'active' : '' }}">
    <a href="#systemSetting"
       {{ request()->is('admin/systemSetting*') || request()->is('admin/systemSetting*') ? 'aria-expanded=true' : '' }}
       data-bs-toggle="collapse">
        <i class="fa fa-cogs"></i>
        <span>प्रणाली सेटिङ </span>
        <span class="menu-arrow"><i class="fas fa-angle-right"></i></span>
    </a>
    <div class="collapse {{ request()->is('admin/systemSetting*') || request()->is('admin/systemSetting*') ? 'show' : '' }}"
         id="systemSetting">
        <ul class="nav-second-level">
            @can('officeSetting_access')
                <li class="{{ request()->is('admin/systemSetting/officeSetting*') ? 'active' : '' }}">
                    <a href="{{ route('admin.systemSetting.officeSetting.index') }}">
                        <span> कार्यालय सेटिङ </span>
                    </a>
                </li>
            @endcan
            <li class="{{ request()->is('admin/systemSetting/letterHead*') ? 'active' : '' }}">
                <a href="{{ route('admin.systemSetting.letterHead.index') }}">
                    <span> लेटर हेड </span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="{{ request()->is('admin/userManagement/*') ? 'active' : '' }}">
    <a href="#userManagement" {{ request()->is('admin/userManagement/*') ? 'aria-expanded=true  ' : '' }}
    data-bs-toggle="collapse">
        <i class="fa fa-users-cog"></i>
        <span>प्रयोगकर्ता व्यवस्थापन</span>
        <span class="menu-arrow">
            <i class="fas fa-angle-right"></i>
        </span>
    </a>
    <div class="collapse {{ request()->is('admin/userManagement/*') ? 'show' : '' }}" id="userManagement">
        <ul class="nav-second-level">
            @can('user_access')
                <li class="{{ request()->is('admin/userManagement/user*') ? 'active' : '' }}">
                    <a href="{{ route('admin.userManagement.user.index') }}">प्रयोगकर्ता</a>
                </li>
            @endcan
            @can('role_access')
                <li class="{{ request()->is('admin/userManagement/role*') ? 'active' : '' }}">
                    <a href="{{ route('admin.userManagement.role.index') }}">भूमिका</a>
                </li>
            @endcan
        </ul>
    </div>
</li>
