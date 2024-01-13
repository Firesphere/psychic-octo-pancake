<div class="btn-toolbar" role="toolbar" aria-label="Filter toolbar">
    <h5>Status:&nbsp;</h5>
    <div class="dropdown">
        <div class="btn-group btn-group-sm">
            <a class="btn btn-primary btn-sm<% if $HasFilter %> active<% end_if %>" type="button" href="$Top.Link">
                <% if $HasFilter %>Reset <% end_if %>Filters
            </a>
            <button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
                <% loop $StatusFilters %>
                    <li><a class="dropdown-item<% if $ActiveFilter %> active<% end_if %>"
                           href="$Top.Link?filter[StatusID]=$ID">
                        <span class="text-$ColourStyle">&nbsp;&#9679;&nbsp;</span>&nbsp;$Status</a></li>
                <% end_loop %>
            </ul>
        </div>
        <% if $CurrentUser.HideClosed && not $ShowAll %>
            <a class="btn btn-primary btn-sm<% if $HasFilter %> active<% end_if %>" type="button"
               href="$Top.Link?showall=true">
                Show all items
            </a>
        <% end_if %>
    </div>
</div>
