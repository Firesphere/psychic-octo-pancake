<h1>$Title</h1>
<div class="container bg-info-subtle p-2 mb-2 d-block d-md-none">
    <div class="row">
        <div class="col-12 d-block d-md-none"><em><b>The Kanban board works better on full desktop/laptop/tablet
            screens</b></em></div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-sm-6 col-md-3" id="collapse-kanboard-1">
        <div class="card mb-3">
            <div class="card-header bg-light">
                <div class="card-title h5 mb-1 col-12 d-flex justify-content-between">
                    <div class="col d-flex justify-content-between">
                        <a data-bs-toggle="collapse" href="#description-1"
                           class="py-1"
                           role="button"
                           aria-expanded="false"
                           aria-controls="description-1">Applied</a>
                        <span class="p-1">
                        <button type="button" class="btn-sm btn btn-primary js-formaction"
                                data-itemtype="application"
                                data-bs-toggle="modal"
                                data-bs-target="#addItemModal">
                            Add new application
                        </button>
                    </span>
                    </div>
                </div>

                <small class="mb-0 text-muted collapse" id="description-1">
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
    <div class="col-12 col-sm-6 col-md-3">
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h3 class="card-title h5 mb-1">
                    <a data-bs-toggle="collapse" href="#description-2"
                       role="button"
                       aria-expanded="false"
                       aria-controls="description-3">Ongoing</a>
                </h3>
                <small class="mb-0 text-muted collapse" id="description-2">
                    Applications that have had a response or have been viewed etc.<br/>
                    This includes applications that had a response <em>after</em> an interview
                </small>
            </div>
            <div class="card-body">
                <div class="tasks" id="Progress">
                    <% loop $CurrentUser.InProgressApplications %>
                        <% include MiniJobCard %>
                    <% end_loop %>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h3 class="card-title h5 mb-1">
                    <a data-bs-toggle="collapse" href="#description-3"
                       role="button"
                       aria-expanded="false"
                       aria-controls="description-3">Interview</a>
                </h3>
                <small class="mb-0 text-muted collapse" id="description-3">
                    Job applications currently in "interview" stage.<br/>
                    Note that if your status is "Response" after an interview<br/>
                    that those applications will not be in this column.
                </small>
            </div>
            <div class="card-body">
                <div class="tasks" id="Interview">
                    <% loop $CurrentUser.JobApplications.Filter('Status.Status', 'Interview') %>
                        <% include MiniJobCard %>
                    <% end_loop %>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h3 class="card-title h5 mb-1">
                    <a data-bs-toggle="collapse" href="#description-4"
                       role="button"
                       aria-expanded="false"
                       aria-controls="description-4">Closed</a>
                </h3>
                <small class="mb-0 text-muted collapse" id="description-4">
                    Applications that have been closed<br/>
                    This means any status as described on your profile
                </small>
            </div>
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
<%--    Ohay, you caught me. These buttons are here to trigger a specific form --%>
    <a href="#"
       id="secretsauce"
       class="btn btn-primary js-formaction"
       data-itemtype=""
       data-bs-toggle="modal"
       data-bs-target="#addItemModal">&nbsp;</a>
</div>