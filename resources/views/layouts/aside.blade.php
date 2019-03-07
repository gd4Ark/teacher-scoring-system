<div class="app-aside">
    <ul class="menu" id="menu">
        @foreach ($navList as $item)
           @if (isset($item['subs']))
                <li class="submenu menu-item">
                    <a class="submenu-title menu-item-title" data-toggle="collapse" href="#{{$item['title']}}" data-parent="#menu">
                        <i class="{{ $item['icon']  }}"></i>
                        <span>{{ $item['title']  }}</span>
                    </a>
                    <div id="{{ $item['title'] }}" class="panel-collapse collapse" role="tabpanel">
                        <ul class="menu">
                            @foreach ($item['subs'] as $subItem)
                                <li class="menu-item">
                                    <a class="menu-item-title" href="{{ $subItem['path']  }}">
                                        <i class="{{ $subItem['icon']  }}"></i>
                                        <span>{{ $subItem['title']  }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
           @else
                <li class="menu-item">
                    <a class="menu-item-title" href="{{ $item['path']  }}">
                        <i class="{{ $item['icon']  }}"></i>
                        <span>{{ $item['title']  }}</span>
                    </a>
                </li>
           @endif
        @endforeach
    </ul>
</div>
<script>
    // 实现只能展开一个子菜单
    $('body').on('click','.submenu-title',function(event){
        var $this = $(this);
        var parent = $this.data('parent');
        var actives = parent && $(parent).find('.collapse.show');

        // From bootstrap itself
        if (actives && actives.length) {
            hasData = actives.data('collapse');
            //if (hasData && hasData.transitioning) return;
            actives.collapse('hide');
        }

        var target = $this.attr('data-target') || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, ''); //strip for ie7

        $(target).collapse('toggle');
    })
</script>