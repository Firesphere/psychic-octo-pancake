<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNotes" aria-labelledby="offcanvasNotes">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNotes">Your notes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <button id="notebookFormToggle" class="btn btn-light btn-sm mb-2"
                type="button" data-bs-toggle="collapse" data-bs-target="#NotebookForm_NotebookForm"
                aria-expanded="false" aria-controls="NotebookForm_NotebookForm">
            Add note
        </button>
        $NotebookForm
        <% loop $CurrentUser.NotebookNotes %>
            <div class="card mb-2" id="note-$ID">
                <div class="card-header">
                    <a class="btn-close end-0 pe-3 position-absolute" aria-label="delete" href="$DeleteLink"></a>
                    <h5 class="card-title"><a href="$Link" id="note-$ID-title">$Title</a></h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">Created: $Created.Nice()</h6>
                </div>
                <div class="card-body">
                    <div class="card-text" id="note-$ID-content">$Content</div>
                    <a href="/#$ID" class="card-link js-notebook-edit">Edit</a>
                </div>
            </div>
        <% end_loop %>
    </div>
</div>
