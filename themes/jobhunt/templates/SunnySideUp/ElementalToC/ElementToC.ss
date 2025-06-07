<div class="row">
    <div class="col-5">
        <% if $WithNumbers %>
        <ol class="list-group list-group-flush">
        <% else %>
        <ul class="list-group list-group-flush">
        <% end_if %>
        <% loop $ToC %>
            <% include SunnySideUp\ElementalToC\Includes\ToCItem %>
        <% end_loop %>
        <% if not $WithNumbers %>
        </ul>
        <% else %>
        </ol>
        <% end_if %>
    </div>
</div>
