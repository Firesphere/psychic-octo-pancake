<% with $CurrentUser %>
    <div class="row">
        <% include DashboardCard Title='applications', Type=info, Count=$ActiveApplications.Count(), Icon='send-check' %>
        <% include DashboardCard Title='ongoing/outstanding', Type=primary, Count=$OpenOutstanding.Count(), Icon='folder2-open' %>
        <% include DashboardCard Title='interviews', Type=success, Count=$Interviews.Count(), Icon='people' %>
        <% include DashboardCard Title='responses', Type=warning, Count=$StatusUpdates.Filter('Status.Status', 'Response').Count(), Icon='envelope-paper' %>
    </div>
    <div class="row">
        <div class="col-12 col-lg-6 mb-4 d-none d-lg-block">
            <div class="card">
                <div class="card-header">Calendar</div>

                <% with $Up.CurrentMonth.First() %>
                    <% include CalendarMonth %>
                <% end_with %>
            </div>
        </div>
        <div class="col-12 col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">Status of applications</div>
                <div class="card-body">
                    <canvas id="doughnut"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Application flow</div>
                <div class="card-body">
                    <canvas data-name="getSankey" id="sankeychart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Moods</div>
                <div class="card-body">
                    <canvas data-name="getMood" id="moodchart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <div class="card">
                <div class="card-header"><i class="bi bi-newspaper"></i>&nbsp;Latest news</div>
                <div class="card-body">
                    <ul class="list-group">
                        <% loop $LatestNews %>
                            <li class="list-group-item d-flex justify-content-between">
                                <a href="$Link">
                                    <% if $FeaturedImage %>
                                        $FeaturedImage.FocusFill(50, 50)
                                    <% else %>
                                        <img src="https://placecats.com/50/50" alt="Placeholder cat" title="Placeholder cat image for $Title" />
                                    <% end_if %>
                                    <span class="ps-1">$Title</span>
                                </a>
                                <span class="small">$PublishDate.Nice</span>
                            </li>
                        <% end_loop %>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="$LatestNews.First.Parent.Link" title="All news"><i class="bi bi-newspaper"></i>&nbsp;All news</a>
                </div>
            </div>
        </div>
    </div>
<% end_with %>
