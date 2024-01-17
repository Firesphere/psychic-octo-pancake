<div class="btn-toolbar pt-1 justify-content-end" role="toolbar" aria-label="Filter toolbar">
    <div class="dropdown text-end">
        <div class="btn-group btn-group-sm">
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
            <a class="btn btn-sm btn-secondary <% if $HasFilter %>active<% else %>dropdown-toggle dropdown-toggle-split<% end_if %>"
               type="button" href="$Top.Link"
                <% if not $HasFilter %>
               data-bs-toggle="dropdown" aria-expanded="false"><span class="visually-hidden">Toggle Dropdown</span>Filters&nbsp;&nbsp;&nbsp;
                <% else %>
                    >Reset Filters
                <% end_if %>
            </a>
            <% if $HasFilter %>
                <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
            <% end_if %>
            <ul class="dropdown-menu dropdown-menu-end">
                <% loop $StatusFilters.Sort('Status ASC') %>
                    <li><a class="dropdown-item<% if $ActiveFilter %> active<% end_if %>"
                           href="$Top.Link?$filterLink">
                        <span class="text-$ColourStyle">&nbsp;&#9679;&nbsp;</span>&nbsp;$Name</a></li>
                <% end_loop %>
            </ul>
        </div>
    </div>
</div>
