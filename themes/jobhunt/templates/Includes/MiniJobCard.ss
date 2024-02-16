<% if not $ID %>
    <div class="card col mb-3">
        <div class="card-body">
            <div class="card-text">No applications.</div>
        </div>
    </div>
<% else %>
    <div class="card col mb-3" data-id="$ID" id="application-$ID">
        <div class="card-header bg-$IsOld-subtle">
            <h6 class="card-title">
                <a href="#"
                   class="js-fav pe-1 link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                   data-id="$ID" title="Favourite this application">
                    <i class="bi bi-star<% if $Favourite %>-fill text-warning<% end_if %>"></i></a>&nbsp;<% with $Status %>
                <span
                    class="border border-1 m-0 px-1 text-$ColourStyle" title="$Name">&#9679;</span><% end_with %>&nbsp;
                <a href="$InternalLink" class="card-link quickfilter-role" data-appid="$ID">$Role</a>
            </h6>
            <a href="$Company.InternalLink" class="h6 card-subtitle mb-2 text-body-secondary quickfilter"
               data-appid="$ID">$Company.Name</a>
            <span class="card-text small">$ApplicationDate.Nice</span>
        </div>
        <% if $StatusUpdatesVisibleCount || $Interviews.Count()%>
            <div class="card-body">
                <% if $StatusUpdatesVisibleCount %>
                    <div class="p-0 row pb-1">
                        <a class="card-text"
                           data-bs-toggle="collapse" href="#su-$ID"
                           role="button"
                           aria-expanded="false"
                           aria-controls="su-$ID"
                        ><i class="bi bi-arrows-expand"></i>&nbsp;Status updates&nbsp;($StatusUpdatesVisibleCount)</a>
                        <div class="collapse card-body ps-2" id="su-$ID">
                            <% loop $StatusUpdates.Filter('Hidden', false) %>
                                <% if $isFirst %>
                                    <hr class="row"/><% end_if %>
                                <h6>$Title</h6>
                                <small class="text-decoration-underline">$Created.Nice</small>
                                <p class="small">$Note</p>
                                <a href="#"
                                   title="Edit status update"
                                   class="js-formaction small"
                                   data-id="$ID"
                                   data-itemtype="statusupdate-edit"
                                   data-bs-toggle="modal"
                                   data-bs-target="#addItemModal"><i class="bi bi-pencil"></i>&nbsp;Edit</a>
                                <hr class="row mt-1"/>
                            <% end_loop %>
                        </div>
                    </div>
                <% end_if %>
                <% if $Interviews.Count %>
                    <div class="p-0 pb-1 row">
                        <a class="card-text"
                           data-bs-toggle="collapse" href="#iv-$ID"
                           role="button"
                           aria-expanded="false"
                           aria-controls="iv-$ID"
                        ><i class="bi bi-arrows-expand"></i>&nbsp;Interviews&nbsp;($Interviews.Count)</a>
                        <div class="collapse card-body ps-1" id="iv-$ID">
                            <% loop $Interviews %>
                                <a href="#"
                                   title="Edit interview"
                                   class="js-formaction small"
                                   data-id="$ID"
                                   data-itemtype="interview-edit"
                                   data-bs-toggle="modal"
                                   data-bs-target="#addItemModal">
                                    $DateTime.Nice() <% if $Notes.Count %><br/>($Notes.Count notes)<% end_if %></a>
                                <hr class="row mt-1"/>
                            <% end_loop %>
                        </div>
                    </div>
                <% end_if %>
            </div>
        <% end_if %>
        <div class="card-footer d-flex justify-content-between">
            <a href="#"
               title="Edit application"
               class="js-formaction small"
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
<% end_if %>
