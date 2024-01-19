<span class="day align-middle
    <% if $Empty %> empty<% end_if %>
    <% if $Today %> today<% end_if %>
    <% if $Interviews.Count %> interviews<% end_if %>
">
    <% if not $Empty %>
        <time class="time" data-bs-toggle="modal" data-bs-target="#interview_{$Day}">
            $Day<% if $Interviews.Count %><sup>$Interviews.Count</sup><% end_if %>
        </time>
        <% if $Interviews.Count %>
            <% include CalendarModal %>
        <% end_if %>
    <% end_if %>
</span>
