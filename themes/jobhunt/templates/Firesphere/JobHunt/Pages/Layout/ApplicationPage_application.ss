<div class="">
    <% with $JobApplication %>
        <div class="row">
            <h1 class="col-12"><span class="m-0 p-0 text-$Status.ColourStyle" title="$Status.Name">&#9679;</span> $Role
                at <a href="$Company.InternalLink">$Company.Name</a></h1>
            <div class="col-6 h4"><% if $PayUpper || $PayLower %>Pay:<% end_if %>
                <% if $PayUpper %>
                    <% if $PayLower %>$PayLower - <% end_if %>$PayUpper
                <% end_if %>
                <% if not $PayUpper && $PayLower %>$PayLower<% end_if %></div>
            <div class="col-6 h4">Statuscode: $Status.Status</div>
            <div class="row">
                <div class="d-flex justify-content-start pb-2">
                    <span class="col-1">
                        <a href="#"
                           title="Edit application"
                           class="js-formaction h3 "
                           data-id="$ID"
                           data-itemtype="application-edit"
                           data-bs-toggle="modal"
                           data-bs-target="#addItemModal">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </span>
                    <span class="col-1">
                        <a href="#"
                           title="Add note"
                           class="js-formaction h3 "
                           data-application="$ID"
                           data-itemtype="note-add"
                           data-bs-toggle="modal"
                           data-bs-target="#addItemModal">
                            <i class="bi bi-file-earmark-plus"></i>
                        </a>
                    </span>
                    <span class="col-1">
                        <a href="#"
                           title="Add status update"
                           class="js-formaction h3 "
                           data-application="$ID"
                           data-itemtype="statusupdate-add"
                           data-bs-toggle="modal"
                           data-bs-target="#addItemModal">
                            <i class="bi bi-plus-circle"></i>
                        </a>
                    </span>
                    <span class="col-1">
                        <a href="#"
                           title="Add interview"
                           class="js-formaction h3 "
                           data-application="$ID"
                           data-itemtype="interview-add"
                           data-bs-toggle="modal"
                           data-bs-target="#addItemModal">
                            <i class="bi bi-person-add"></i>
                        </a>
                    </span>
                    <span class="col text-end">
                        <a href="$Top.Link/delete/application/$ID"
                           class="text-warning h3 "
                           title="Delete this application">
                            <i class="bi bi-x-octagon-fill"></i>
                        </a>
                    </span>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 pb-2">
                Application date: $ApplicationDate.Nice()<br/>
                <a href="$Link" target="_blank">Link to job description</a><br/>
            </div>
            <% if $CoverLetter %>
                <div class="col-sm-6 col-xs-12 pb-2">
                    <a href="#coverletter-$ID"
                       data-bs-toggle="modal"
                       data-bs-target="#coverletter-$ID">Cover letter</a>
                </div>
            <% end_if %>

            <hr class="pb-1"/>
            <% if $StatusUpdates.Filter('Hidden', false).Count() %>
                <div class="col-12 col-md-6">
                    <h3>Status updates</h3>
                    <% loop $StatusUpdates.Filter('Hidden', false) %>
                        <% include Note Type=statusupdate %>
                    <% end_loop %>
                </div>
            <% end_if %>
            <% if $Interviews.Count || $Notes.Count %>
                <div class="col-12 col-md-6">
                    <h3>Interviews:</h3>
                    <% loop $Interviews %>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title">Interview on $DateTime.Nice()</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary"><% if $Duration %>$Duration
                                    minutes<% else %>&nbsp;<% end_if %></h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="card-text">
                                    <% if $Notes %>
                                        <h4><a data-bs-toggle="collapse" href="#details-$ID"
                                               aria-expanded="false"
                                               aria-controls="details-$ID">Notes on this
                                            interview</a>&nbsp;($Notes.Count)</h4>
                                        <div class="collapse row" id="details-$ID">
                                            <% loop $Notes %>
                                                <div class="col-12 mb-2">
                                                    <% include Note Type=0 %>
                                                </div>
                                            <% end_loop %>
                                        </div>
                                    <% else %>
                                        <div class="col">
                                            <p>No notes.</p>
                                        </div>
                                    <% end_if %>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="#"
                                   title="Edit interview"
                                   class="js-formaction h6"
                                   data-id="$ID"
                                   data-itemtype="interview-edit"
                                   data-bs-toggle="modal"
                                   data-bs-target="#addItemModal">Edit this interview</a>
                            </div>
                        </div>
                    <% end_loop %>
                    <% if $Notes.Count %>
                        <h3>Notes:</h3>
                        <% loop $Notes %>
                            <% include Note Type=note %>
                        <% end_loop %>
                    <% end_if %>
                </div>
            <% end_if %>

        </div>
        <% if $CoverLetter %>
            <% include CoverLetterModal %>
        <% end_if %>
    <% end_with %>
</div>
