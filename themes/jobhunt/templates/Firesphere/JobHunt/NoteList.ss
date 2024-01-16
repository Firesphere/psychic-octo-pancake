<div class='row'>
    <div class='col'>$ForTemplate</div>
    <div class='col'>
        <h3>Notes:</h3>
        <% loop $notes %>
            <div class="col-12 col-lg-6 mb-2">
                <div class="card">
                    <a class="card-header" data-bs-toggle="collapse" href="#id_$ID" role="button"
                       aria-expanded="false"
                       aria-controls="id_$ID">
                        $Title
                    </a>
                    <div class="collapse card-body" id="id_$ID">
                        <p>$Note</p>
                        <a href="#"
                           title="Edit interview note"
                           class="js-formaction card-link"
                           data-id="$ID"
                           data-itemtype="interviewnote-edit">Edit</a>
                    </div>
                </div>
            </div>
        <% end_loop %>
    </div>
</div>
