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
                <% if $Logo %>
                    <img src="$Logo.Link" class="card-img-top" alt="Logo for $Name">
                <% end_if %>
                <div class="card-header bg-$Ethics d-flex justify-content-between">
                    <h2>Details</h2>
                    <div title="Ethics: $EthicsToString" class="h2 text-bg-$Ethics bi
                    <% if $Ethics == 'success' %>bi-hand-thumbs-up-fill<% end_if %>
                        <% if $Ethics == 'info' %>bi-hand-thumbs-up<% end_if %>
                        <% if $Ethics == 'primary' %>bi-question-circle-fill<% end_if %>
                        <% if $Ethics == 'danger' %>bi-hand-thumbs-down<% end_if %>
                        <% if $Ethics == 'warning' %>bi-hand-thumbs-down-fill<% end_if %>"></div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Address</h5>
                    <p class="card-text">$Address</p>
                    <p class="card-text">$Conutry</p>
                </div>
                <div class="card-footer text-body-secondary">
                    <% if $Link %>
                        <a href="$Link" target="_blank" class="btn btn-primary" title="Company link (External)">Company
                            website&nbsp;<sup><i class="bi bi-box-arrow-up-right"></i></sup></a>
                    <% end_if %>
                    <% if $Email %>
                        <% if $Link %>&nbsp;|&nbsp;<% end_if %><a href="mailto:$Email">$Email</a>
                    <% end_if %>
                </div>
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
        <h3>Notes on this company</h3>
        <div class="col-12">
            <% loop $Notes %>
                <div class="card mb-2">
                    <div class="card-header">
                        <h5 class="card-title">$Title</h5>
                        <h6>$NoteType.Type</h6>
                        <h6 class="card-subtitle mb-2 text-body-secondary">Created: $Created.Nice()</h6>
                    </div>
                    <div class="card-body">
                        <p class="card-text">$Note</p>
                    </div>
                    <div class="card-footer">
                        <h6>Note by: <% if $User %>Created by: $User.FirstName<% else %>Anonymous<% end_if %></h6>
                    </div>
                </div>
            <% end_loop %>
        </div>
    <% end_with %>
</div>
