<div class="card-body">
    <h6>Interviews</h6>
    <ul class="list-group list-group-flush">
        <% loop $Interviews %>
            <li class="list-group-item border-secondary border-1">
                <div class=" d-flex justify-content-between">

                    <a data-bs-toggle="collapse" href="#Interview-$ID" role="button"
                       aria-expanded="false"
                       aria-controls="Interview-$ID">
                        $DateTime.Nice
                    </a>
                    <a href="$deleteLink"
                       class="pull-right text-warning"
                       title="Delete this interview"><i class="bi bi-x-octagon-fill"></i></a>
                </div>
                <div class="collapse card-text" id="Interview-$ID">
                    <% if $Notes.Count %>
                        <hr/>
                        <% loop $Notes %>
                            <h6>$Title ($Created.Date())
                                <a href="$deleteLink"
                                   class="pull-right text-warning"
                                   title="Delete this application"><i
                                    class="bi bi-x-octagon-fill"></i></a>
                            </h6>
                            <p class="card-text">
                                $Note
                            </p>
                            <hr/>
                        <% end_loop %>
                    <% end_if %>
                    <div class="card-link">
                        <a href="#"
                           title="Edit interview"
                           class="js-formaction"
                           data-id="$ID"
                           data-itemtype="interview-edit"
                           data-bs-toggle="modal"
                           data-bs-target="#addItemModal">Edit</a>
                    </div>
                </div>
            </li>
        <% end_loop %>
    </ul>
</div>
