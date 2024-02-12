<div class="row">
    <% with $Company %>
        <h1 class="col-12">$Name</h1>
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
                    <a href="#">Edit company details</a>
                </div>
            </div>
        </div>
        <div class="col">
            <section id="map"></section>
        </div>
    <% end_with %>
</div>
