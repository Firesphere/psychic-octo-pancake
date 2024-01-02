<div class="py-5 bg-opacity-50">
    <div class="container">
        <div class="row column-gap-5">
            <h1 class="col-12">$Title</h1>
            <div class="col-8">

                    <% if $Type == 'Register' %>
                        <% include Symbiote/MemberProfiles/Pages/MemberProfilePage_register %>
                    <% else %>
                        <% include Symbiote/MemberProfiles/Pages/MemberProfilePage_profile %>
                    <% end_if %>
            </div>
            <% include UserSidebar %>
        </div>
    </div>
</div>
