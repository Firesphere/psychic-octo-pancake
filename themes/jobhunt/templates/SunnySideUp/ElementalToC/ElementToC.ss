<% if $WithNumbers %>
    <ol class="">
<% else %>
    <ul class="">
<% end_if %>
<% loop $ToC %>
    <% include SunnySideUp\ElementalToC\Includes\ToCItem %>
<% end_loop %>
<% if not $WithNumbers %>
    </ul>
<% else %>
    </ol>
<% end_if %>
