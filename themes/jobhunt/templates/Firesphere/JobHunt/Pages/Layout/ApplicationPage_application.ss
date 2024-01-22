<div class="">
    <% with $JobApplication %>
        <div class="row">
            <h1 class="col-12">$Role at $Company.Name</h1>
            <div class="row">
                <div class="d-flex justify-content-start pb-2">
                    <span class="col-1"><a href="#"
                                           title="Edit application"
                                           class="js-formaction h3 "
                                           data-id="$ID"
                                           data-itemtype="application-edit"
                                           data-bs-toggle="modal"
                                           data-bs-target="#addItemModal"><i class="bi bi-pencil"></i></a>
                    </span>
                    <span class="col-1"><a href="#"
                                           title="Add note"
                                           class="js-formaction h3 "
                                           data-application="$ID"
                                           data-itemtype="note-add"
                                           data-bs-toggle="modal"
                                           data-bs-target="#addItemModal"><i
                        class="bi bi-file-earmark-plus"></i></a></span>
                    <span class="col-1"><a href="#"
                                           title="Add status update"
                                           class="js-formaction h3 "
                                           data-application="$ID"
                                           data-itemtype="statusupdate-add"
                                           data-bs-toggle="modal"
                                           data-bs-target="#addItemModal"><i class="bi bi-plus-circle"></i></a></span>
                    <span class="col-1"><a href="#"
                                           title="Add interview"
                                           class="js-formaction h3 "
                                           data-application="$ID"
                                           data-itemtype="interview-add"
                                           data-bs-toggle="modal"
                                           data-bs-target="#addItemModal"><i
                        class="bi bi-person-add"></i></a></span>
                    <span class="col text-end"><a href="$Top.Link/delete/application/$ID"
                                                  class="text-warning h3 "
                                                  title="Delete this application"><i
                        class="bi bi-x-octagon-fill"></i></a>
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
            <% if $Notes.Count %>
                <div class="col-12 col-md-6">
                    <h3>Notes:</h3>
                    <% loop $Notes %>
                        <% include Note Type=note %>
                    <% end_loop %>
                </div>
            <% end_if %>
        </div>
        <% if $Interviews.Count %>
            <div class="row d-flex justify-content-between">
                <h3 class="col-12">Interviews:</h3>
                <% loop $Interviews %>
                    <div class=" b-5 col-12">
                        <div class="card">
                            <div class="card-body p-3">
                                <h5 class="card-title">
                                    Interview</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">Interview
                                    date/time: $DateTime.Nice()</h6>
                                <div class="card-text">
                                    <% if $Notes %>
                                        <h4><a data-bs-toggle="collapse" href="#details-$ID"
                                               aria-expanded="false"
                                               aria-controls="details-$ID">Notes on this interview</a></h4>
                                        <div class="collapse row" id="details-$ID">
                                            <% loop $Notes %>
                                                <div class="col-6 mb-2">
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
                    </div>
                <% end_loop %>
            </div>
        <% end_if %>
        <% if $CoverLetter %>
            <% include CoverLetterModal %>
        <% end_if %>
    <% end_with %>
</div>
