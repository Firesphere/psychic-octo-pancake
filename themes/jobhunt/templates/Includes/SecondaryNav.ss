<nav class="navbar navbar-expand-md container justify-content-end">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#secondaryNav"
            aria-controls="secondaryNav" aria-expanded="false" aria-label="Toggle secondary navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end px-4 px-lg-5" id="secondaryNav">
        <ul class="navbar-nav mb-2 mb-lg-0">
            <% loop $SecondaryNav %>
                <li class="nav-item $FirstLast $EvenOdd">
                    <a class="nav-link $LinkingMode <% if $IsCurrent %>active<% end_if %>" rel="nofollow" href="$Link">$MenuTitle</a>
                </li>
            <% end_loop %>
            <li class="nav-item">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                   aria-expanded="true">
                    How's the job hunt going?
                </a>
                <ul class="dropdown-menu border-0 show dropdown-menu-end py-0">
                    <li class="">
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
                    </li>
                </ul>
            </li>
            <li class="nav-item $FirstLast $EvenOdd">
                <a class="nav-link" rel="nofollow" href="$LogoutURL">Logout</a>
            </li>
        </ul>
    </div>
</nav>
