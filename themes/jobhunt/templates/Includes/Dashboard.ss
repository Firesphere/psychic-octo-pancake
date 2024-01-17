<% with $CurrentUser %>
    <div class="row">
        <div class="col-lg-3 col-6 mb-4">
            <div class="card bg-info-subtle">
                <div class="card-header">Total applications</div>
                <div class="card-body d-flex justify-content-between">
                    <h2 class="h2 card-title">$JobApplications.Count()</h2>
                    <h3 class="text-info bi bi-send-check"></h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6 mb-4">
            <div class="card bg-primary-subtle">
                <div class="card-header">Total ongoing/outstanding</div>
                <div class="card-body d-flex justify-content-between">
                    <h2 class="card-title">$OpenOutstanding.Count()</h2>
                    <h3 class="text-primary bi bi-arrow-repeat"></h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6 mb-4">
            <div class="card bg-success-subtle">
                <div class="card-header">Total interviews</div>
                <div class="card-body d-flex justify-content-between">
                    <h2 class="card-title">$Interviews.Count()</h2>
                    <h3 class="text-success bi bi-people"></h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6 mb-4">
            <div class="card bg-warning-subtle">
                <div class="card-header">Total responses</div>
                <div class="card-body d-flex justify-content-between">
                    <h2 class="card-title">$StatusUpdates.Filter('Status.Status', 'Response').Count()</h2>
                    <h3 class="text-warning bi bi-envelope-paper"></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-6 mb-4 d-none d-lg-block">
            <div class="card">
                <div class="card-header">Calendar</div>

                <% with $Up.CurrentMonth.First() %>
                    <% include CalendarItem %>
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
