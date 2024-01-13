<div class="btn-toolbar" role="toolbar" aria-label="Filter toolbar">
    <h5>Filtering:&nbsp;&nbsp;</h5>
    <div class="dropdown text-end">
        <div class="btn-group btn-group-sm">
            <% if $CurrentUser.HideClosed %>
                <a class="btn btn-secondary btn-sm<% if $ShowAll %> active<% end_if %>" type="button"
                   href="$Top.Link<% if not $ShowAll %>?showall=true<% end_if %>" title="You have closed applications hidden. Click here to show all your applications.">
                    <% if not $ShowAll %>
                        Also show hidden applications
                    <% else %>
                        Back to standard view
                    <% end_if %>
                </a>
            <% end_if %>
            <a class="btn btn-secondary btn-sm<% if $HasFilter %> active<% end_if %>" type="button" href="$Top.Link">
                <% if $HasFilter %>Reset <% end_if %>Filters
            </a>
            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
                <% loop $StatusFilters.Sort('Status ASC') %>
                    <li><a class="dropdown-item<% if $ActiveFilter %> active<% end_if %>"
                           href="$Top.Link?filter[StatusID]=$ID">
                        <span class="text-$ColourStyle">&nbsp;&#9679;&nbsp;</span>&nbsp;$Status</a></li>
                <% end_loop %>
            </ul>
        </div>
    </div>
</div>
