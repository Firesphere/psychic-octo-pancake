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
    <div class="mb-2 col-4">
        <label for="filter" class="visually-hidden">Filter</label>
        <div class="input-group">
            <input id="filter" type="text" class="form-control col"
                   placeholder="Quickfilter"
                   aria-placeholder="Quickfilter"/>
            <a href="#" class="btn btn-outline-secondary" type="button"
               id="clear_filter"><i
                class="bi bi-x"></i></a>
        </div>
    </div>
    <% if $Content %>
        <div class="mb-2 col-6">
            <div id="help">
                <a href="#kanban-help"
                   data-bs-toggle="collapse"
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
            <% include KanbanColumn ColumnTitle='Applied', ColumnCount=$CurrentUser.JobApplications.Filter('Status.Status', 'Applied'), ColumnDescription="Jobs you've applied for" %>
            <div class="card-body">
                <div class="tasks" id="Applied">
                    <% loop $CurrentUser.AppliedJobApplications %>
                        <% include MiniJobCard %>
                    <% end_loop %>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4 col-md-3 col-lg-2">
        <div class="card mb-3">
            <% include KanbanColumn ColumnTitle="Started", ColumnCount=$CurrentUser.InProgressApplications, ColumnDescription="Applications that have had a response or have been viewed etc.<br/>
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
            <% include KanbanColumn ColumnTitle="Interview", ColumnCount=$CurrentUser.getPrePostInterview(false), ColumnDescription='Job applications currently in "interview" stage.<br/>
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
            <% include KanbanColumn ColumnTitle="Post-Interview", ColumnCount=$CurrentUser.getPrePostInterview(true), ColumnDescription='You have had an interview
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
            <% include KanbanColumn ColumnTitle="Followed-up", ColumnCount=$CurrentUser.getInProgressApplications(true), ColumnDescription='Applications that you have had at least 1 interview for,
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
            <% include KanbanColumn ColumnTitle="Closed", ColumnCount=$CurrentUser.JobApplications.Filter('Status.AutoHide', true), ColumnDescription="Applications that have been closed<br/>
                    This means any status as described on your profile." %>
            <div class="card-body">
                <div class="tasks" id="Closed">
                    <% loop $CurrentUser.ClosedJobApplications %>
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
