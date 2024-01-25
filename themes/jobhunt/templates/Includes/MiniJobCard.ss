<div class="card col mb-3" data-id="$ID">
    <div class="card-body">
        <h5 class="card-title">
            <a href="#"
               class="js-fav pe-1 link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
               data-id="$ID" title="Favourite this application">
                <i class="bi bi-star<% if $Favourite %>-fill text-warning<% end_if %>"></i></a>&nbsp;<% with $Status %>
            <span
                class="border border-1 m-0 px-1 text-$ColourStyle" title="$Name">&#9679;</span><% end_with %>&nbsp;$Role
        </h5>
        <h6 class="card-subtitle mb-2 text-body-secondary">$Company.Name</h6>
        <p class="card-text">$ApplicationDate.Nice</p>
        <% if $StatusUpdates.Count %>
            <div class="card-body pt-0">
                <a class="card-text"
                   data-bs-toggle="collapse" href="#$ID"
                   role="button"
                   aria-expanded="false"
                   aria-controls="$ID"
                >Status updates&nbsp;<i class="bi bi-arrow-expand"></i></a>
                <div class="collapse card-body pt-1 py-0" id="$ID">
                    <% loop $StatusUpdates %>
                        <h5>$Title</h5>
                        <p class="small">$Note</p>
                    <% end_loop %>
                </div>
            </div>
        <% end_if %>
    <a href="$Link" class="card-link">View application</a>&nbsp;|&nbsp;
    <a href="#"
       title="Edit application"
       class="js-formaction"
       data-id="$ID"
       data-itemtype="application-edit"
       data-bs-toggle="modal"
       data-bs-target="#addItemModal"><i class="bi bi-pencil"></i> Edit application</a>
</div>
</div>
