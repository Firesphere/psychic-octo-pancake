<div class="container bg-info-subtle p-2 mb-2">
    <div class="col-12">This board is currently read-only!</div>
</div>

<div class="row">
    <div class="col col-md-3">
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h3 class="card-title h5 mb-1">
                    Applied
                </h3>
                <small class="mb-0 text-muted">
                    Jobs you've applied for
                </small>
            </div>
            <div class="card-body">
                <div class="tasks" id="Applied">
                    <% loop $CurrentUser.JobApplications.Filter('Status.Status', 'Applied') %>
                        <% include MiniJobCard %>
                    <% end_loop %>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h3 class="card-title h5 mb-1">
                    In progress
                </h3>
                <small class="mb-0 text-muted">
                    Applications that have had a response or have been viewed.<br />
                    This includes applications that had a response <em>after</em> an interview
                </small>
            </div>
            <div class="card-body">
                <div class="tasks" id="Applied">
                    <% loop $CurrentUser.InProgressApplications %>
                        <% include MiniJobCard %>
                    <% end_loop %>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h3 class="card-title h5 mb-1">
                    Interview
                </h3>
                <small class="mb-0 text-muted">
                    Job applications currently in "interview" stage.<br />
                    Note that if your status is "Response" after an interview<br />
                    that those applications will not be in this column.
                </small>
            </div>
            <div class="card-body">
                <div class="tasks" id="Applied">
                    <% loop $CurrentUser.JobApplications.Filter('Status.Status', 'Interview') %>
                        <% include MiniJobCard %>
                    <% end_loop %>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h3 class="card-title h5 mb-1">
                    Closed
                </h3>
                <small class="mb-0 text-muted">
                    Applications that have been closed<br />
                    This means any status as described on your profile
                </small>
            </div>
            <div class="card-body">
                <div class="tasks" id="Applied">
                    <% loop $CurrentUser.JobApplications.Filter('Status.AutoHide', true) %>
                        <% include MiniJobCard %>
                    <% end_loop %>
                </div>
            </div>
        </div>
    </div>
</div>
