<div class="row">
    <% with $Company %>
        <h1 class="d-flex justify-content-between">
            <span>$Name</span>
            <a href="#"
               title="Edit company"
               class="js-formaction"
               data-id="$ID"
               data-itemtype="company-edit"
               data-bs-toggle="modal"
               data-bs-target="#addItemModal"><i class="bi bi-building-gear"></i></a>
        </h1>
        <div class="col">
            <div class="card">
                <div class="card-header bg-$Ethics d-flex justify-content-between">
                    <h2>Details</h2>
                    <div title="Ethics: $EthicsToString" class="h2 text-bg-$Ethics bi
                    <% if $Ethics == 'success' %>bi-hand-thumbs-up-fill<% end_if %>
                        <% if $Ethics == 'info' %>bi-hand-thumbs-up<% end_if %>
                        <% if $Ethics == 'primary' %>bi-question-circle-fill<% end_if %>
                        <% if $Ethics == 'warning' %>bi-hand-thumbs-down<% end_if %>
                        <% if $Ethics == 'danger' %>bi-hand-thumbs-down-fill<% end_if %>"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title">Address</h5>
                            <% if not $Address %>
                                <p class="card-text">No known address</p>
                                <p class="card-text"></p>

                            <% else %>
                                <p class="card-text">$Address</p>
                                <p class="card-text">$Country</p>
                            <% end_if %>
                        </div>
                        <% if $Logo %>
                            <img src="$Logo.Pad(250,250).Link" class="col-2 img-fluid" alt="$Logo.Title"/>
                        <% end_if %>
                    </div>
                </div>
                <% if $Link || $Email || $Phone %>
                    <div class="card-footer text-body-secondary">
                        <% if $Link %>
                            <a href="$Link" target="_blank" class="btn btn-primary" title="Company link (External)">Company
                                website&nbsp;<sup><i class="bi bi-box-arrow-up-right"></i></sup></a>
                        <% end_if %>
                        <% if $Email %>
                            <% if $Link %>&nbsp;|&nbsp;<% end_if %><a href="mailto:$Email">$Email</a>
                        <% end_if %>
                        <% if $Phone %>
                            <a href="tel:$Phone">$Phone</a>
                        <% end_if %>
                    </div>
                <% end_if %>
                <div class="card-footer text-body-tertiary">
                    <a href="#"
                       title="Edit company"
                       class="js-formaction"
                       data-id="$ID"
                       data-itemtype="company-edit"
                       data-bs-toggle="modal"
                       data-bs-target="#addItemModal">Edit company details</a>
                </div>
            </div>
        </div>
        <div class="col">
            <section id="map"></section>
        </div>
        <hr class="m-2 col-12"/>
        <h3 class="d-flex justify-content-between col-12">
            <span>Notes on this company</span>
            <a href="#"
               title="Add company note"
               class="js-formaction small"
               data-application="$ID"
               data-itemtype="companynote-add"
               data-bs-toggle="modal"
               data-bs-target="#addItemModal">Add a note</a>
        </h3>
        <div class="col-12">
            <% if $Notes.Count %>
                <div class="row">
                    <% loop $Notes %>
                        <div class="col-12 col-md-6">
                            <div class="card mb-2">
                                <div class="card-header">
                                    <h5 class="card-title">$Title</h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary d-flex justify-content-between">
                                        <span>$NoteType.Type</span>
                                        <span title="Score: $Score" class="bi
                                            <% if $Score == 5 %>bi-hand-thumbs-up-fill text-success<% end_if %>
                                            <% if $Score == 4 %>bi-hand-thumbs-up text-info<% end_if %>
                                            <% if $Score == 4 %>bi-question-circle-fill text-primary<% end_if %>
                                            <% if $Score == 2 %>bi-hand-thumbs-down text-warning<% end_if %>
                                            <% if $Score == 1 %>bi-hand-thumbs-down-fill text-danger<% end_if %>
                                            <% if $Score == "N/A" %>bi-question-circle-fill text-secondary<% end_if %>">
                                        </span>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">$Note</p>
                                </div>
                                <div class="card-footer">
                                    <h6>Feedback by: <% if $User && not $Anonymous %>
                                        $User.FirstName<% else %>Anonymous<% end_if %></h6>
                                </div>
                            </div>
                        </div>
                    <% end_loop %>
                </div>
            <% else %>
                <div class="card">
                    <div class="card-body"><p class="card-text">No notes for this company.</p></div>
                </div>
            <% end_if %>
        </div>
    <% end_with %>
</div>
