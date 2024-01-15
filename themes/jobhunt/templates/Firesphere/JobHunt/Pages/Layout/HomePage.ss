<div class="">
    <div class="row">
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
