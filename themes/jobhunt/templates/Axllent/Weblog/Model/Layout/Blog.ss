<div class="blog-posts">
    <h1>$Title</h1>
    <% if $PaginatedList.Exists %>
        <% loop $PaginatedList %>
            <div class="my-2 blogentry bg-light p-3 col-12 d-flex justify-content-start">
                <% if $FeaturedImage %>
                    <a href="$Link" class="img-fluid img-thumbnail ">$FeaturedImage.FocusFill(315,175)</a>
                <% end_if %>
                <div class="ps-3">
                    <h3><a href="$Link">$Title</a></h3>
                    <p>
                        Published: $PublishDate.Month $PublishDate.DayOfMonth(true), $PublishDate.Year
                    </p>
                    <% if $Summary %>
                        <p>$Summary</p>
                    <% else %>
                        <p>$Content.Summary</p>
                    <% end_if %>
                    <p><a href="$Link">Continue reading &raquo;</a></p>
                </div>
            </div>
        <% end_loop %>
    <% end_if %>

        <% include Pagination PaginatedMatches=$PaginatedList %>
</div>
