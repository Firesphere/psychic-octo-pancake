<div class="card mb-2">
    <div class="card-header">
        <h5 class="card-title">$Title</h5>
        <h6 class="card-subtitle mb-2 text-body-secondary">Created: $Created.Nice()</h6>
    </div>
    <div class="card-body">
        <p class="card-text">$Note</p>
    </div>
    <% if $Type != 0 %>
        <div class="card-footer">
            <a href="#"
               title="Edit $Type"
               class="js-formaction card-link"
               data-id="$ID"
               data-itemtype="$Type-edit"
               data-bs-toggle="modal"
               data-bs-target="#addItemModal">Edit this $Type</a>
        </div>
    <% end_if %>
</div>

