<div class="">
    <div class="row">
        <% loop $SiteConfig.SiteBanners %>
            <div class="alert alert-$Type alert-dismissible fade show" role="alert">
                <i class="h4 bi
                <% if $Type == 'info' %>
                    bi-info text-bg-$Type-subtle
                <% else_if $Type == 'warning' %>
                    bi-exclamation text-bg-$Type-subtle
                <% else %>
                    bi-exclamation-octagon text-bg-$Type-subtle
                <% end_if %>
"></i>&nbsp;$Content
                <% if $Dismiss %>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <% end_if %>
            </div>
        <% end_loop %>
        <% if not $CurrentUser %>
            <h1 class="col-12">$Title</h1>
            <div class="col-12">
                $Content
            </div>
        <% else %>
            <h1 class="col-12">Welcome back $CurrentUser.FirstName</h1>

            <% include Dashboard %>
        <% end_if %>
    </div>
</div>
