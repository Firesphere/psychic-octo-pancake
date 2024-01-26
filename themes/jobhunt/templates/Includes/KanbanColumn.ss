<div class="card-header bg-light">
    <div class="card-title h5 mb-1 col-12 d-flex justify-content-between">
        <div class="col d-flex justify-content-between">
            <a data-bs-toggle="collapse" href="#description-$ColumnTitle"
               class="py-1"
               role="button"
               aria-expanded="false"
               aria-controls="description-$ColumnTitle">$ColumnTitle ($ColumnCount)</a>
            <% if $Add %>
                <span class="p-1">
                    <button type="button" class="btn-sm btn btn-primary js-formaction"
                            data-itemtype="application"
                            data-bs-toggle="modal"
                            data-bs-target="#addItemModal">
                        Add new application
                    </button>
                </span>
            <% end_if %>
        </div>
    </div>
    <small class="mb-0 text-muted collapse" id="description-$ColumnTitle">
        $ColumnDescription.RAW
    </small>
</div>
