<div class="card-header bg-light">
    <div class="card-title h5 mb-1 col-12 d-flex justify-content-between">
        <div class="col d-flex justify-content-between">
            <a data-bs-toggle="collapse" href="#description-$ColumnTitle"
               class="py-1"
               role="button"
               aria-expanded="false"
               aria-controls="description-$ColumnTitle">$ColumnTitle
                (<% if $ColumnCount.First.ID %>$ColumnCount.Count()<% else %>0<% end_if %>)</a>
        </div>
    </div>
    <small class="mb-0 text-muted collapse" id="description-$ColumnTitle">
        $ColumnDescription.RAW
    </small>
</div>
