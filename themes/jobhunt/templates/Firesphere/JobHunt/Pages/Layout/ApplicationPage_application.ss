<div class="">
<% with $JobApplication %>
        <div class="row">
            <h1 class="col-12">$Role at $Company.Name</h1>
            <h3><a href="#"
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
            </h3>
            <div class="col-12 pb-2">
                Application date: $ApplicationDate.Nice()<br/>
                <a href="$Link" target="_blank">Link</a><br/>
            </div>
            <hr class="col-12 pb-1"/>
            <% if $StatusUpdates.Filter('Hidden', false).Count() %>
                <div class="col-12 col-md-4">
                    <h3>Status updates</h3>
                    <% loop $StatusUpdates.Filter('Hidden', false) %>
                        <% include Note Type=statusupdate %>
                    <% end_loop %>
                </div>
            <% end_if %>
            <% if $CoverLetter %>
                <div class="col-12 col-md-4">
                    <h3>Cover letter</h3>
                    $CoverLetter
                </div>
            <% end_if %>
            <% if $Notes.Count %>
                <div class="col-12 col-md-4">
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
                    <div class=" mb-5 col-6">
                        <div class="card">
                            <div class="card-body p-3">
                                <h5 class="card-title">Interview</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">Interview
                                    date/time: $DateTime.Nice()</h6>
                                <div class="card-text row">
                                    <% if $Notes %>
                                        <h4>Notes on this interview</h4>
                                        <% loop $Notes %>
                                            <div class="col-6 mb-2">
                                                <% include Note Type=0 %>
                                            </div>
                                        <% end_loop %>
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
    </div>
<% end_with %>
</div>
