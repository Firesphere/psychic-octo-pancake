<div class="py-5 bg-opacity-50">
    <div class="row">
        <h1 class="col-12">$Title</h1>
        <div class="col-2">

            <% if $Type == 'Register' %>
                <% include Symbiote/MemberProfiles/Pages/MemberProfilePage_register %>
            <% else %>
                <% include Symbiote/MemberProfiles/Pages/MemberProfilePage_profile %>
            <% end_if %>
        </div>
    </div>
</div>
