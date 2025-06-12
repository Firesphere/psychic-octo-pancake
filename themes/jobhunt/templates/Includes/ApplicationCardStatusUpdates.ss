<div class="card-body">
    <h6>Status updates</h6>
    <ul class="list-group list-group-flush">
        <% loop $StatusUpdates.Filter('Hidden', 0) %>
            <li class="list-group-item border-secondary border-1">
                <div class=" d-flex justify-content-between">
                    <a data-bs-toggle="collapse" href="#Update-$ID"
                       class="badge text-bg-$Status.Colourstyle"
                       role="button"
                       aria-expanded="false"
                       aria-controls="Update-$ID">
                        $Title ($Created.Date())
                    </a>
                    <a href="$deleteLink"
                       class="pull-right text-warning"
                       title="Delete this status"><i class="bi bi-x-octagon-fill"></i></a>
                </div>
                <div class="collapse card-text" id="Update-$ID">
                    <p class="card-text">
                        $Note
                    </p>
                    <hr/>
                    <div class="card-link">
                        <a href="#"
                           title="Edit status update"
                           class="js-formaction"
                           data-id="$ID"
                           data-itemtype="statusupdate-edit"
                           data-bs-toggle="modal"
                           data-bs-target="#addItemModal">Edit</a>
                    </div>
                </div>

            </li>
        <% end_loop %>
    </ul>
</div>
