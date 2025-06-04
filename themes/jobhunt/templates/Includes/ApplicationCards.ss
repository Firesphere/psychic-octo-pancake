<div class="row">
    <% loop $Applications %>
        <div class="col-sm-12 col-md-4 pb-3 d-flex">
            <div class="card  flex-grow-1">
                <div class="card-header bg-$IsOld-subtle">
                    <div class="d-flex justify-content-between">
                        <h4><a href="#"
                               class="js-fav pe-1 link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                               data-id="$ID" title="Favourite this application">
                            <i class="bi bi-star<% if $Favourite %>-fill text-warning<% end_if %>"></i></a>&nbsp;
                            <% with $Status %><span class="m-0 p-0 text-$ColourStyle" title="$Name"><% end_with %>&#9679;</span>&nbsp;<a
                                href="$InternalLink" title="View application">$Role</a> at
                            <% with $Company %>
                                <a href="$InternalLink">$Name</a>
                            <% end_with %>
                        </h4>

                    </div>
                    <div class="d-flex justify-content-between">
                        <small class="pull-left">Application date: $ApplicationDate.Nice()</small>
                        <a href="$InternalLink" class="h4 mb-0" title="View application"><i
                            class="bi bi-eye-fill"></i></a>
                    </div>
                    <div class="d-flex justify-content-between">
                        <% if $Link %>
                            <a href="$Link" class="small" target="_blank">Job description</a>
                        <% end_if %>
                        <% if $PayUpper || $PayLower %>Pay:<% end_if %>
                        <% if $PayUpper %>
                            <% if $PayLower %>$PayLower - <% end_if %>$PayUpper
                        <% end_if %>
                        <% if not $PayUpper && $PayLower %>$PayLower<% end_if %>
                    </div>
                </div>
                <% if $StatusUpdates.Filter('Hidden', false).Count %>
                    <div class="card-body">
                        <h6>Status updates</h6>
                        <ul class="list-group list-group-flush">
                            <% loop $StatusUpdates.Filter('Hidden', 0) %>
                                <li class="list-group-item border-secondary border-1">
                                    <div class=" d-flex justify-content-between">
                                        <a data-bs-toggle="collapse" href="#Update-$ID"
                                           class="badge text-bg-$Status.Colourstyle"
                                           role="button"
                                           aria-expanded="false"
                                           aria-controls="Update-$ID">
                                            $Title ($Created.Date())
                                        </a>
                                        <a href="$deleteLink"
                                           class="pull-right text-warning"
                                           title="Delete this status"><i class="bi bi-x-octagon-fill"></i></a>
                                    </div>
                                    <div class="collapse card-text" id="Update-$ID">
                                        <p class="card-text">
                                            $Note
                                        </p>
                                        <hr/>
                                        <div class="card-link">
                                            <a href="#"
                                               title="Edit status update"
                                               class="js-formaction"
                                               data-id="$ID"
                                               data-itemtype="statusupdate-edit"
                                               data-bs-toggle="modal"
                                               data-bs-target="#addItemModal">Edit</a>
                                        </div>
                                    </div>

                                </li>
                            <% end_loop %>
                        </ul>
                    </div>
                <% end_if %>
                <% if $Interviews.Count %>
                    <div class="card-body">
                        <h6>Interviews</h6>
                        <ul class="list-group list-group-flush">
                            <% loop $Interviews %>
                                <li class="list-group-item border-secondary border-1">
                                    <div class=" d-flex justify-content-between">

                                        <a data-bs-toggle="collapse" href="#Interview-$ID" role="button"
                                           aria-expanded="false"
                                           aria-controls="Interview-$ID">
                                            $DateTime.Nice
                                        </a>
                                        <a href="$deleteLink"
                                           class="pull-right text-warning"
                                           title="Delete this interview"><i class="bi bi-x-octagon-fill"></i></a>
                                    </div>
                                    <div class="collapse card-text" id="Interview-$ID">
                                        <% if $Notes.Count %>
                                            <hr/>
                                            <% loop $Notes %>
                                                <h6>$Title ($Created.Date())
                                                    <a href="$deleteLink"
                                                       class="pull-right text-warning"
                                                       title="Delete this application"><i
                                                        class="bi bi-x-octagon-fill"></i></a>
                                                </h6>
                                                <p class="card-text">
                                                    $Note
                                                </p>
                                                <hr/>
                                            <% end_loop %>
                                        <% end_if %>
                                        <div class="card-link">
                                            <a href="#"
                                               title="Edit interview"
                                               class="js-formaction"
                                               data-id="$ID"
                                               data-itemtype="interview-edit"
                                               data-bs-toggle="modal"
                                               data-bs-target="#addItemModal">Edit</a>
                                        </div>
                                    </div>
                                </li>
                            <% end_loop %>
                        </ul>
                    </div>
                <% end_if %>
                <% if $Notes.Count %>
                    <div class="card-body">
                        <h6>Notes</h6>
                        <ul class="list-group list-group-flush">
                            <% loop $Notes %>
                                <li class="list-group-item border-secondary border-1">
                                    <div class=" d-flex justify-content-between">
                                        <a data-bs-toggle="collapse" href="#Note-$ID" role="button"
                                           aria-expanded="false"
                                           aria-controls="Note-$ID">
                                            $Title ($Created.Date())
                                        </a>
                                        <a href="$deleteLink"
                                           class="pull-right text-warning"
                                           title="Delete this note"><i class="bi bi-x-octagon-fill"></i></a>
                                    </div>
                                    <div class="collapse card-text" id="Note-$ID">
                                        $Note
                                        <hr/>
                                        <div class="card-link">
                                            <a href="#"
                                               title="Edit note"
                                               class="js-formaction"
                                               data-id="$ID"
                                               data-itemtype="note-edit"
                                               data-bs-toggle="modal"
                                               data-bs-target="#addItemModal">Edit</a>
                                        </div>
                                    </div>
                                </li>
                            <% end_loop %>
                        </ul>
                    </div>
                <% end_if %>
                <div class="card-body d-flex flex-column">
                    <div class="progress mt-auto">
                        <% loop $TimeLine %>
                            <div class="progress-bar shadow-lg progress-bar-striped bg-$Colour border"
                                 title="$Status: Started: $StartDay; Ended: $EndDay"
                                 role="progressbar"
                                 style="width: $Size%"
                                 aria-valuenow="$End"
                                 aria-valuemin="$Start"
                                 aria-valuemax="$End"
                            ></div>
                        <% end_loop %>
                    </div>

                </div>
                <div class="card-footer text-body-secondary d-flex justify-content-around">
                    <a href="#"
                       title="Edit application"
                       class="js-formaction"
                       data-id="$ID"
                       data-itemtype="application-edit"
                       data-bs-toggle="modal"
                       data-bs-target="#addItemModal"><i class="bi bi-pencil"></i></a>&nbsp;|&nbsp;
                    <a href="#"
                       title="Add note"
                       class="js-formaction"
                       data-application="$ID"
                       data-itemtype="note-add"
                       data-bs-toggle="modal"
                       data-bs-target="#addItemModal"><i class="bi bi-file-earmark-plus"></i></a>&nbsp;|&nbsp;
                    <a href="#"
                       title="Add status update"
                       class="js-formaction"
                       data-application="$ID"
                       data-itemtype="statusupdate-add"
                       data-bs-toggle="modal"
                       data-bs-target="#addItemModal"><i class="bi bi-plus-circle"></i></a>&nbsp;|&nbsp;
                    <a href="#"
                       title="Add interview"
                       class="js-formaction"
                       data-application="$ID"
                       data-itemtype="interview-add"
                       data-bs-toggle="modal"
                       data-bs-target="#addItemModal"><i class="bi bi-person-fill-add"></i></a>
                </div>
            </div>
        </div>
    <% end_loop %>
</div>
