<div class="btn-toolbar" role="toolbar" aria-label="Filter toolbar">
    <h5 class="col-12">Filter by status:</h5>
    <div class="btn-group btn-group-sm m-2 small" role="group" aria-label="Statusses">
        <% loop $StatusFilters %>
            <a href="$Top.Link?filter[StatusID]=$ID" type="button"
               class="btn btn-sm btn-$ColourStyle<% if $ActiveFilter %> active<% end_if %>">
                <% if $ActiveFilter %>
                    <strong>$Status</strong>
                <% else %>
                    $Status
                <% end_if %>
            </a>
        <% end_loop %>
    </div>
    <div class="btn-group btn-group-sm m-2" role="group" aria-label="Reset">
        <a href="$Top.Link" type="button" class="btn-group btn-group-sm btn btn-sm btn-light">Reset</a>
    </div>
</div>
