<div class="card-body">
    <h6>Notes</h6>
    <ul class="list-group list-group-flush">
        <% loop $Notes %>
            <li class="list-group-item border-secondary border-1">
                <div class=" d-flex justify-content-between">
                    <a data-bs-toggle="collapse" href="#Note-$ID" role="button"
                       aria-expanded="false"
                       aria-controls="Note-$ID">
                        $Title ($Created.Date())
                    </a>
                    <a href="$deleteLink"
                       class="pull-right text-warning"
                       title="Delete this note"><i class="bi bi-x-octagon-fill"></i></a>
                </div>
                <div class="collapse card-text" id="Note-$ID">
                    $Note
                    <hr/>
                    <div class="card-link">
                        <a href="#"
                           title="Edit note"
                           class="js-formaction"
                           data-id="$ID"
                           data-itemtype="note-edit"
                           data-bs-toggle="modal"
                           data-bs-target="#addItemModal">Edit</a>
                    </div>
                </div>
            </li>
        <% end_loop %>
    </ul>
</div>
