<div class="row">
    <% if not $CurrentUser %>
    $TokenForm
    $LoginForm
    <% else %>
        $Form
    <% end_if %>
    <div class="col-sm-6 col-md-4">
        $Content
    </div>
    <div class="col-md-4">
        <% if $CurrentUser %>
            <h3>Import</h3>
            <p>Due to technical issues, the CSV import is currently unavailable.</p>
            <% if $CurrentUser.InGroup('administrators') %>
                <p>You can import applications from CSV via the button below.</p>
                <p>Please be aware that the import will not check for duplicate applications, interviews, notes,
                    etc.</p>
                <button type="button" class="btn btn-primary js-formaction"
                        data-itemtype="import"
                        data-bs-toggle="modal"
                        data-bs-target="#addItemModal">
                    Import from CSV
                </button>
                <hr/>
                <h3>Archive</h3>
                <p>Archive all job applications you currently have. For if you are starting a new job hunt.</p>
                <form action="$Link/archive" method="POST">
                    <input type="hidden" value="$SecurityID" name="SecurityID"/>
                    <input type="submit" name="action_archive" class="action btn btn-warning" value="Archive"/>
                </form>
            <% end_if %>
        <% end_if %>
    </div>
</div>
