<div class="btn-toolbar pt-1 justify-content-end" role="toolbar" aria-label="Filter toolbar">
    <div class="dropdown text-end">
        <div class="btn-group btn-group-sm">
            <a class="btn btn-sm btn-secondary <% if $ActiveCompany %>active<% else %>dropdown-toggle dropdown-toggle-split<% end_if %>"
                type="button" href="$Top.Link"
                <% if not $ActiveCompany %>
               data-bs-toggle="dropdown" aria-expanded="false"><span class="visually-hidden">Toggle Dropdown</span>
                   Company&nbsp;&nbsp;&nbsp;
                <% else %>
                title="Reset">$ActiveCompany.Name
                <% end_if %>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <% loop $CompanyList %>
                    <li><a class="dropdown-item<% if $Up.ActiveCompany.ID == $ID  %> active<% end_if %>"
                           href="$Top.Link?company=$ID">
                        $Name</a></li>
                <% end_loop %>
            </ul>
            <% if $CurrentUser.HideClosed %>
                <a class="btn btn-secondary btn-sm<% if $HasShowAll %> active<% end_if %><% if $HasFilter %> disabled<% end_if %>"
                   type="button"
                   href="<% if $HasFilter %>#<% else %>$Top.Link?$ShowAll<% end_if %>"
                   title="You have closed applications hidden. Click here to show all your applications.">
                    <% if not $HasShowAll %>
                        Also show hidden applications
                    <% else %>
                        Back to standard view
                    <% end_if %>
                </a>
            <% end_if %>
            <a class="btn btn-sm btn-secondary <% if $HasFilter || $FavSet %>active<% else %>dropdown-toggle dropdown-toggle-split<% end_if %>"
               type="button" href="$Top.Link"
                <% if not $HasFilter && not $FavSet %>
               data-bs-toggle="dropdown" aria-expanded="false"><span class="visually-hidden">Toggle Dropdown</span>
                   Filters&nbsp;&nbsp;&nbsp;
                <% else %>
                    >Reset Filters
                <% end_if %>
            </a>
            <% if $HasFilter || $FavSet %>
                <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
            <% end_if %>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item <% if $FavSet %>text-bg-warning-outline<% end_if %>" href="$Top.Link?<% if not $FavSet %>fav=true<% else %>$filterLink<% end_if %>">
                    <span class="text-success">&nbsp;<i class=" text-warning bi bi-star<% if $FavSet %>-fill<% end_if %>"></i>&nbsp;</span>&nbsp;Favourites</a></li>
                <% loop $StatusFilters.Sort('Status ASC') %>
                    <li><a class="dropdown-item<% if $ActiveFilter %> active<% end_if %>"
                           href="$Top.Link?$filterLink">
                        <span class="text-$ColourStyle">&nbsp;&#9679;&nbsp;</span>&nbsp;$Name</a></li>
                <% end_loop %>
            </ul>
        </div>
    </div>
</div>
