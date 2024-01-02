<% with $Results.Facets %>
    <% include StickerSidebar Tags=$Tag %>
<% end_with %>
<div class="py-5 bg-opacity-50">
    <div class="row">
        <h1 class="col-12">$Results.TotalItems results for $Query</h1>
    </div>
    <div class="row">
        <% loop $Results.getPaginatedMatches %>
            <% include StickerCard %>
        <% end_loop %>
        <% if $Results.getPaginatedMatches.MoreThanOnePage %>
            <% with $Results.getPaginatedMatches %>
                <% include Pagination Key='Search' %>
            <% end_with %>
        <% end_if %>
    </div>
</div>
