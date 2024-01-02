<div class="col-3">
    <ul class="list-group-flush">
        <li class="list-group-item">
            <% if $Parent %>
                <% with $Parent %>
                    <a class="nav-link $Linkingmode first" href="$Link"><h4>$Title</h4></a>
                <% end_with %>
            <% else %>
                <a class="nav-link $Linkingmode first" href="$Link"><h4>$Title</h4></a>
            <% end_if %>
            <% if $CurrentUser %>
                <ul class="list-group">
                    <% loop $Menu(2) %>
                        <li class="list-group-item $FirstLast $EvenOdd">
                            <a class="nav-link $LinkingMode" rel="nofollow" href="$Link">$MenuTitle</a>
                        </li>
                    <% end_loop %>
                    <li class="list-group-item list-group-item-primary">
                        <span class="h6">How's the job hunt going?</span>
                        <div class="row">
                            <table class="table table-borderless align-middle js-dayscore"
                                   <% if $CurrentUser.hasMood %>data-dayscore="$CurrentUser.hasMood"<% end_if %>>
                                <tr>
                                    <td class="text-bg-danger text-center">
                                        <a href="#" class="nav-link js-moodtracker" rel="nofollow"
                                           data-score="1"><span class="h3">😖</span></a>
                                    </td>
                                    <td class="bg-danger-subtle text-center">
                                        <a href="#" class="nav-link js-moodtracker" rel="nofollow"
                                           data-score="2"><span class="h3">☹️</span></a>
                                    </td>
                                    <td class="text-bg-info text-center">
                                        <a href="#" class="nav-link js-moodtracker" rel="nofollow"
                                           data-score="3"><span class="h3">😐</span></a>
                                    </td>
                                    <td class="bg-success-subtle text-center">
                                        <a href="#" class="nav-link js-moodtracker" rel="nofollow"
                                           data-score="4"><span class="h3">🙂</span></a>
                                    </td>
                                    <td class="text-bg-success text-center">
                                        <a href="#" class="nav-link js-moodtracker" rel="nofollow"
                                           data-score="5"><span class="h3">😃</span></a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </li>
                    <li class="list-group-item  list-group-item-dark">&nbsp;</li>
                    <li class="list-group-item $FirstLast $EvenOdd">
                        <a class="nav-link" rel="nofollow" href="$LogoutURL">Logout</a>
                    </li>
                </ul>
            <% end_if %>
        </li>
    </ul>
</div>
