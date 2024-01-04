    <header>
        <nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" rel="nofollow"
                   href="/">$SiteConfig.Title</a><br/>
                <small>$SiteConfig.Tagline</small>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                        data-bs-auto-close="outside" aria-label="Toggle navigation">
                    Menu <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <% if $URLSegment == 'home' %>
                            <% loop $ElementalArea.Elements %>
                                <% if $ShowTitle %>
                                    <li class="nav-item scroll-spy">
                                        <a class="nav-link" rel="nofollow" href="#e$ID"
                                           data-bs-target="#e$ID">$Title</a>
                                    </li>
                                <% end_if %>
                            <% end_loop %>
                        <% end_if %>
                        <% loop $Menu(1) %>
                            <li class="nav-item $FirstLast <% if $Children.Count %>dropdown<% end_if %>">
                                <% if $Title != 'Profile' && $Children.Count %>
                                    <a class="nav-link dropdown-toggle" rel="nofollow" role="button"
                                       data-bs-toggle="dropdown">$MenuTitle.XML</a>
                                    <ul class="dropdown-menu border-0 px-2">
                                        <li>
                                            <a class="dropdown-item <% if $LinkingMode == 'current' %>active<% end_if %>"
                                               href="$Link">$Title.XML</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <% loop $Children.Sort('PublishDate', 'DESC').Limit(10) %>
                                            <li><a
                                                class="dropdown-item <% if $LinkingMode == 'current' %>active<% end_if %>"
                                                rel="nofollow" href="$Link">$MenuTitle.XML</a></li>
                                        <% end_loop %>
                                    </ul>
                                <% else %>
                                    <a class="nav-link $LinkingMode <% if $LinkingMode == 'current' || $LinkingMode == 'section' %>active<% end_if %>"
                                       rel="nofollow" href="$Link">$MenuTitle.XML</a>
                                <% end_if %>
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
