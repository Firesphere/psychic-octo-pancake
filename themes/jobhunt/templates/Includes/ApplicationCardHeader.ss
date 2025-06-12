<div class="card-header bg-$IsOld-subtle">
    <h4><a href="#"
           class="js-fav pe-1 link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
           data-id="$ID" title="Favourite this application">
        <i class="bi bi-star<% if $Favourite %>-fill text-warning<% end_if %>"></i></a>&nbsp;
        <% with $Status %><span class="m-0 p-0 text-$ColourStyle" title="$Name"><% end_with %>&#9679;</span>&nbsp;<a
            href="$InternalLink" title="View application">$Role</a> at
        <% with $Company %>
            <a href="$InternalLink">$Name</a>
        <% end_with %>
    </h4>
    $TagForm
    <div class="d-flex justify-content-between">
        <small class="pull-left">Application date: $ApplicationDate.Nice()</small>
        <a href="$InternalLink" class="h4 mb-0" title="View application"><i
            class="bi bi-eye-fill"></i></a>
    </div>
    <div class="d-flex justify-content-between">
        <% if $Link %>
            <a href="$Link" class="small" target="_blank">Job description</a>
        <% end_if %>
        <% if $PayUpper || $PayLower %>Pay:<% end_if %>
        <% if $PayUpper %>
            <% if $PayLower %>$PayLower - <% end_if %>$PayUpper
        <% end_if %>
        <% if not $PayUpper && $PayLower %>$PayLower<% end_if %>
    </div>
</div>
