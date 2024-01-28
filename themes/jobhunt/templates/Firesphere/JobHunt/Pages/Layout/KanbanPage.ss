<h1>$Title</h1>
<div class="container bg-info-subtle p-2 mb-2 d-block d-md-none">
    <div class="row">
        <div class="col-12 d-block d-md-none">
            <em><b>The Kanban board works better on full desktop/laptop/tablet screens</b></em>
        </div>
    </div>
</div>
<div class="row">
    <div class="mb-2 col-2">
        <button type="button" class="btn-sm btn btn-primary js-formaction"
                data-itemtype="application"
                data-bs-toggle="modal"
                data-bs-target="#addItemModal">
            Add application
        </button>
    </div>
    <% if $Content %>
        <div class="mb-2 col-10">
            <div id="help">
                <a
                    data-bs-toggle="collapse" href="#kanban-help"
                    role="button"
                    aria-expanded="false"
                    aria-controls="description-$ColumnTitle"
                ><h4><i class="bi bi-question-octagon">&nbsp;</i>Kanban Help</h4></a>
                <div id="kanban-help" class="collapse">$Content</div>
            </div>
        </div>
    <% end_if %>
</div>
<div class="row">
    <div class="col-12 col-sm-4 col-md-3 col-lg-2">
        <div class="card mb-3">
            <% include KanbanColumn ColumnTitle='Applied', ColumnCount=$CurrentUser.JobApplications.Filter('Status.Status', 'Applied').Count(), ColumnDescription="Jobs you've applied for" %>
            <div class="card-body">
                <div class="tasks" id="Applied">
                    <% loop $CurrentUser.JobApplications.Filter('Status.Status', 'Applied') %>
                        <% include MiniJobCard %>
                    <% end_loop %>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4 col-md-3 col-lg-2">
        <div class="card mb-3">
            <% include KanbanColumn ColumnTitle="Started", ColumnCount=$CurrentUser.InProgressApplications.Count(), ColumnDescription="Applications that have had a response or have been viewed etc.<br/>
                    This includes applications that had a response <em>after</em> an interview" %>
            <div class="card-body">
                <div class="tasks" id="Progress">
                    <% loop $CurrentUser.InProgressApplications %>
                        <% include MiniJobCard %>
                    <% end_loop %>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4 col-md-3 col-lg-2">
        <div class="card mb-3">
            <% include KanbanColumn ColumnTitle="Interview", ColumnCount=$CurrentUser.getPrePostInterview(false).Count(), ColumnDescription='Job applications currently in "interview" stage.<br/>
                    Note that if your status is "Response" after an interview<br/>
                    that those applications will not be in this column.' %>
            <div class="card-body">
                <div class="tasks" id="Interview">
                    <% loop $CurrentUser.getPrePostInterview(false) %>
                        <% include MiniJobCard %>
                    <% end_loop %>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4 col-md-3 col-lg-2">
        <div class="card mb-3">
            <% include KanbanColumn ColumnTitle="Post-Interview", ColumnCount=$CurrentUser.getPrePostInterview(true).Count(), ColumnDescription='You have had an interview
            and are now waiting on feedback.' %>
            <div class="card-body">
                <div class="tasks" id="PostInterview">
                    <% loop $CurrentUser.getPrePostInterview(true) %>
                        <% include MiniJobCard %>
                    <% end_loop %>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4 col-md-3 col-lg-2">
        <div class="card mb-3">
            <% include KanbanColumn ColumnTitle="Followed-up", ColumnCount=$CurrentUser.getInProgressApplications(true).Count(), ColumnDescription='Applications that you have had at least 1 interview for,
            and have heard back or requested an update.' %>
            <div class="card-body">
                <div class="tasks" id="Follow">
                    <% loop $CurrentUser.getInProgressApplications(true) %>
                        <% include MiniJobCard %>
                    <% end_loop %>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4 col-md-3 col-lg-2">
        <div class="card mb-3">
            <% include KanbanColumn ColumnTitle="Closed", ColumnCount=$CurrentUser.JobApplications.Filter('Status.AutoHide', true).Count(), ColumnDescription="Applications that have been closed<br/>
                    This means any status as described on your profile." %>
            <div class="card-body">
                <div class="tasks" id="Closed">
                    <% loop $CurrentUser.JobApplications.Filter('Status.AutoHide', true) %>
                        <% include MiniJobCard %>
                    <% end_loop %>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="hidden d-none display-none">
    <!--    Ohay, you caught me. These buttons are here to trigger a specific form -->
    <a href="#"
       id="secretsauce"
       class="btn btn-primary js-formaction"
       data-itemtype=""
       data-application=""
       data-bs-toggle="modal"
       data-bs-target="#addItemModal"></a>
</div>
