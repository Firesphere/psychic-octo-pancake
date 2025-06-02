<div class="blog-post">
    <header>
        <h1>$Title</h1>
    </header>
    <p class="blog-published-on">
        $PublishDate.Month $PublishDate.DayOfMonth(true), $PublishDate.Year
        <%-- requires silverstripe-weblog-categories module --%>
        <% if $Categories %>
            &nbsp; | &nbsp;
            <% loop $Categories %>
                <a class="badge rounded-pill bg-<% if $Colour %>$Colour<% else %>primary<% end_if %>"
                   href="$Link">$Title</a><% if not $Last %>,<% end_if %>
            <% end_loop %>
        <% end_if %>
    </p>
    <div class=" bg-light p-3">
        <% if $FeaturedImage %>
            $FeaturedImage.FocusFill(1080,400)
        <% end_if %>

        $Content
        $ElementalArea
    </div>
</div>
