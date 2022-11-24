<!-- begin:: Aside Menu -->
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
  <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
    <ul class="kt-menu__nav ">
      @if(Sentinel::getUser()->hasAnyAccess(['product.index','unit.index']))
      <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
          <span class="kt-menu__link-icon">
            <i class="fa fa-briefcase"></i>
          </span>
          <span class="kt-menu__link-text">Master</span>
          <i class="kt-menu__ver-arrow la la-angle-right"></i>
        </a>
        <div class="kt-menu__submenu ">
          <span class="kt-menu__arrow"></span>
          <ul class="kt-menu__subnav">
            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
              <span class="kt-menu__link">
                <span class="kt-menu__link-text">Master</span>
              </span>
            </li>
            @if (Sentinel::getUser()->hasAccess(['product.index']))
            <li class="kt-menu__item " aria-haspopup="true">
              <a href="{{route('product.index')}}" class="kt-menu__link ">
                  <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                    <span></span>
                  </i>
                  <span class="kt-menu__link-text">Product</span>
              </a>
            </li>
            @endif
            @if (Sentinel::getUser()->hasAccess(['unit.index']))
            <li class="kt-menu__item " aria-haspopup="true">
              <a href="{{route('unit.index')}}" class="kt-menu__link ">
                  <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                    <span></span>
                  </i>
                  <span class="kt-menu__link-text">Unit</span>
              </a>
            </li>
            @endif
            @if (Sentinel::getUser()->hasAccess(['supplier.index']))
            <li class="kt-menu__item " aria-haspopup="true">
              <a href="{{route('supplier.index')}}" class="kt-menu__link ">
                  <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                    <span></span>
                  </i>
                  <span class="kt-menu__link-text">Supplier</span>
              </a>
            </li>
            @endif
          </ul>
        </div>
      </li>
      @endif
      @if (Sentinel::getUser()->hasAccess(['inventory.index']))
      <li class="kt-menu__item " aria-haspopup="true">
        <a href="{{route('inventory.index')}}" class="kt-menu__link ">
          <span class="kt-menu__link-icon">
            <i class="fa fa-folder"></i>
          </span>
          <span class="kt-menu__link-text">Inventory</span>
        </a>
      </li>
      @endif
      @if (Sentinel::getUser()->hasAccess(['user.index']))
      <li class="kt-menu__item " aria-haspopup="true">
        <a href="{{route('user.index')}}" class="kt-menu__link ">
          <span class="kt-menu__link-icon">
            <i class="fa fa-user"></i>
          </span>
          <span class="kt-menu__link-text">User</span>
        </a>
      </li>
      @endif
    </ul>
  </div>
</div>
<!-- end:: Aside Menu -->
