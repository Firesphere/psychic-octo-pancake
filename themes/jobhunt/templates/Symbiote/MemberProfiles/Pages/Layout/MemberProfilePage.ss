<div class="py-5 bg-opacity-50">
    <div class="container">
        <div class="row column-gap-5">
            <h1 class="col-12">$Title</h1>
            <div class="col-8">

                <div class="row column-gap-3 mt-3">
                    <% if $Type == 'Register' %>
                        <% include Symbiote/MemberProfiles/Pages/MemberProfilePage_register %>
                    <% else %>
                        <% include Symbiote/MemberProfiles/Pages/MemberProfilePage_profile %>
                    <% end_if %>
                </div>
            </div>
            <div class="col-3">
                <ul class="list-group-flush">
                    <li class="list-group-item">
                        <a class="nav-link $Linkingmode first" href="$Link"><h4>$Title</h4></a>
                        <ul class="list-group">
                            <% loop $Menu(2) %>
                                <li class="list-group-item $FirstLast $EvenOdd">
                                    <a class="nav-link $LinkingMode" rel="nofollow" href="$Link">$MenuTitle</a>
                                </li>
                            <% end_loop %>
                            <% if $CurrentUser %>
                                <li class="list-group-item  list-group-item-dark">&nbsp;</li>
                                <li class="list-group-item $FirstLast $EvenOdd">
                                    <a class="nav-link" rel="nofollow" href="$LogoutURL">Logout</a>
                                </li>
                            <% end_if %>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
