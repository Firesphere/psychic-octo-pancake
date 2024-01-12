<div class="row">
    <h3>Notes:</h3>
    <% loop $notes %>
        <div class="col-6">
            <div class="card">
                <a class="card-header" data-bs-toggle="collapse" href="#id_$ID" role="button" aria-expanded="false"
                   aria-controls="id_$ID">
                    $Title
                </a>
                <div class="collapse card-body" id="id_$ID">
                    $Note
                </div>
            </div>
        </div>
    <% end_loop %>
</div>
