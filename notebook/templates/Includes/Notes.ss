<div class="content">
    $NotebookForm
    <% loop $CurrentUser.NotebookNotes %>
        <div id="note-$ID">
            <h3 id="note-$ID-title">$Title</h3>
            <a href="$DeleteLink">delete</a>
            <h5>Created $Created.Nice()</h5>
            <div class="note-$ID-content">$Content</div>
            <a href="/#$ID" class="js-notebook-edit">edit</a>
        </div>
    <% end_loop %>
</div>
