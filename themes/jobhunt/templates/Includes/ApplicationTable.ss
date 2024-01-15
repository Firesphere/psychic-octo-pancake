<table class="table table-responsive">
    <thead>
    <tr>
        <th scope="col">
            <span class="<% if $SortDirection == 'Company.NameASC' || $SortDirection == 'Company.NameDESC' %>border-bottom border-primary h5 active<% end_if %>">
                <a href="$Top.Link?sort[Company.Name]=<% if $SortDirection == 'Company.NameASC' %>DESC<% else %>ASC<% end_if %>"><i
                    class="bi bi-sort-alpha-down<% if $SortDirection == 'Company.NameDESC' %>-alt<% end_if %>"></i></a>
            </span>
            Company
        </th>
        <th scope="col"></th>
        <th scope="col">Role</th>
        <th scope="col">
            <span class="<% if $SortDirection == 'ApplicationDateASC' || $SortDirection == 'ApplicationDateDESC' %>border-bottom border-primary h5 active<% end_if %>">
                <a href="$Top.Link?sort[ApplicationDate]=<% if $SortDirection == 'ApplicationDateASC' %>DESC<% else %>ASC<% end_if %>"><i
                    class="bi bi-sort-numeric-<% if $SortDirection == 'ApplicationDateASC' %>up<% else %>down<% end_if %>"></i></a>
            </span>
            Application date
        </th>
        <th scope="col">
            Status
        </th>
        <th scope="col"></th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody class="table-group-divider">
    <% loop $Applications %>
        <tr class="$OddEven">
            <td rowspan="4"><b>
                <% if $Company.Link %>
                    <a href="$Company.Link" target="_blank">$Company.Name</a>
                <% else %>
                    $Company.Name
                <% end_if %>
            </b></td>
            <th scope="row"></th>
            <td><a href="$Link" target="_blank">$Role</a></td>
            <td>$ApplicationDate.Nice()</td>
            <td>
                <div class="badge text-bg-$Status.ColourStyle">$Status.Status</div>
            </td>
            <td>
                <a href="#"
                   title="Edit application"
                   class="js-formaction"
                   data-id="$ID"
                   data-itemtype="application-edit"
                   data-bs-toggle="modal"
                   data-bs-target="#addItemModal"><i class="bi bi-pencil"></i></a>
            </td>
            <td><a href="$Up.Link('application')/$ID" title="View application"><i class="bi bi-eye-fill"></i></a></td>
        </tr>
        <tr class="$OddEven">
            <th>Notes</th>
            <td colspan="4">
                <% loop $Notes %>
                    <a href="#"
                       title="Edit note"
                       class="js-formaction badge text-bg-primary"
                       data-id="$ID"
                       data-itemtype="note-edit"
                       data-bs-toggle="modal"
                       data-bs-target="#addItemModal">$Title</a>
                <% end_loop %>
            </td>
            <td>
                <a href="#"
                   title="Add note"
                   class="js-formaction"
                   data-application="$ID"
                   data-itemtype="note-add"
                   data-bs-toggle="modal"
                   data-bs-target="#addItemModal"><i class="bi bi-file-earmark-plus"></i></a><br/>
            </td>
        </tr>
        <tr class="$OddEven">
            <th scope="row">Updates</th>
            <td colspan="4">
                <% loop $StatusUpdates.Filter('Hidden', 0) %>
                    <a href="#"
                       title="Edit Status update"
                       class="js-formaction h6 badge text-bg-$Status.ColourStyle"
                       data-id="$ID"
                       data-itemtype="statusupdate-edit"
                       data-bs-toggle="modal"
                       data-bs-target="#addItemModal">$Status.Status: $Title</a>
                <% end_loop %>
            </td>
            <td>
                <a href="#"
                   title="Add status update"
                   class="js-formaction"
                   data-application="$ID"
                   data-itemtype="statusupdate-add"
                   data-bs-toggle="modal"
                   data-bs-target="#addItemModal"><i class="bi bi-plus-circle"></i></a>
            </td>
        </tr>
        <tr>
            <th scope="row">Interviews</th>
            <td colspan="4">
                <% loop $Interviews %>
                    <a href="#"
                       title="Edit interview"
                       class="js-formaction h6 badge text-bg-secondary"
                       data-id="$ID"
                       data-itemtype="interview-edit"
                       data-bs-toggle="modal"
                       data-bs-target="#addItemModal">$DateTime.Nice()</a>
                <% end_loop %>
            </td>
            <td>
                <a href="#"
                   title="Add interview"
                   class="js-formaction"
                   data-application="$ID"
                   data-itemtype="interview-add"
                   data-bs-toggle="modal"
                   data-bs-target="#addItemModal"><i class="bi bi-person-add"></i></a>
            </td>
        </tr>
    <% end_loop %>
    </tbody>
</table>
