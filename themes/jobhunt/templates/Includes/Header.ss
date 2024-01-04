<header>
    <nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" rel="nofollow"
               href="<% if $Top.URLSegment == 'home' %>#page-top<% else %>/<% end_if %>">$SiteConfig.Title</a><br/>
            <small>$SiteConfig.Tagline</small>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                    data-bs-auto-close="outside" aria-label="Toggle navigation">
                Menu <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <% loop $Menu(1) %>
                        <li class="nav-item <% if $Children.Count %>dropdown<% end_if %>">
                            <a class="nav-link <% if $LinkingMode == 'current' %>active<% end_if %>"
                               rel="nofollow" href="$Link">$MenuTitle.XML</a>
                        </li>
                    <% end_loop %>
                </ul>
            </div>
        </div>
    </nav>
    <% if $CurrentUser %>
        <% include SecondaryNav %>
    <% end_if %>
</header>
