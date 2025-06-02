<div class="">
    <div class="row">
        <h1 class="col-12">$Title</h1>
        <h3></h3>
        <div class="col-12">
            $Content
        </div>
    </div>
    <div class="row">
        <% loop $Days %>
            <div class="col-xs-12 col-md-6">
                <% include CalendarMonth %>
            </div>
        <% end_loop %>
    </div>
</div>
