<% with $CurrentUser %>
    <div class="row">
        <% include DashboardCard Title='applications', Type=info, Count=$JobApplications.Count(), Icon='send-check' %>
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
    </div>
<% end_with %>
