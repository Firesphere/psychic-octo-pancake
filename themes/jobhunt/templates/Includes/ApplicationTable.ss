<table class="table table-responsive table-responsive-sm table-sm">
    <thead>
    <tr>
        <th scope="col">
            <span
                class="<% if $SortDirection == 'Company.NameASC' || $SortDirection == 'Company.NameDESC' %>border-bottom border-primary h5 active<% end_if %>">
                <a href="$Top.Link?sort[Company.Name]=<% if $SortDirection == 'Company.NameASC' %>DESC<% else %>ASC<% end_if %>"><i
                    class="bi bi-sort-alpha-down<% if $SortDirection == 'Company.NameDESC' %>-alt<% end_if %>"></i></a>
            </span>
            Company
        </th>
        <th scope="col" class="col-lg-1">Role</th>
        <th scope="col"></th>
        <th scope="col">
            <span
                class="<% if $SortDirection == 'ApplicationDateASC' || $SortDirection == 'ApplicationDateDESC' %>border-bottom border-primary h5 active<% end_if %>">
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
        <tr class="$EvenOdd table-group-divider">
            <td class="col-lg">
                <div class="justify-content-start">
                    <% with $Company %>
                        <div class="d-flex justify-content-between">
                            <b>
                                <a href="#" class="js-fav pe-2 link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" data-id="$Up.ID" title="Favourite this application">
                                    <i class="bi bi-star<% if $Up.Favourite %>-fill text-warning<% end_if %>"></i>
                                </a>
                                <% if $Link %>
                                    <a href="$Link" class="text-" target="_blank">$Name</a>
                                <% else %>
                                    $Name
                                <% end_if %>
                            </b>
                            <% if $CurrentUser.CanEditCompany %>
                                <a href="#"
                                   title="Edit company"
                                   class="js-formaction"
                                   data-id="$ID"
                                   data-itemtype="company-edit"
                                   data-bs-toggle="modal"
                                   data-bs-target="#addItemModal"><i class="bi bi-building-gear"></i></a>
                            <% end_if %>
                        </div>
                    <% end_with %>
                </div>
            </td>
            <td class="col-lg" colspan="2"><a href="$Link" target="_blank">$Role</a></td>
            <td class="col-lg">$ApplicationDate.Nice()</td>
            <td class="col-lg">
                <div class="badge text-bg-$Status.ColourStyle">$Status.Name</div>
            </td>
            <td class="col-lg">
                <a href="#"
                   title="Edit application"
                   class="js-formaction"
                   data-id="$ID"
                   data-itemtype="application-edit"
                   data-bs-toggle="modal"
                   data-bs-target="#addItemModal"><i class="bi bi-pencil"></i></a>
            </td>
            <td class="col-lg"><a href="$Up.Link('application')/$ID" title="View application"><i
                class="bi bi-eye-fill"></i></a></td>
        </tr>
        <tr class="$OddEven">
            <td rowspan="3"></td>
            <th>Notes</th>
            <td colspan="4">
                <% loop $Notes %>
                    <a href="#"
                       title="Edit note"
                       class="js-formaction text-start link-underline link-underline-opacity-0 link-underline-opacity-75-hover badge text-bg-primary"
                       data-id="$ID"
                       data-itemtype="note-edit"
                       data-bs-toggle="modal"
                       data-bs-target="#addItemModal">Created: $Created.Date()<br/>$Title</a>
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
                       class="js-formaction text-start badge text-bg-$Status.ColourStyle link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                       data-id="$ID"
                       data-itemtype="statusupdate-edit"
                       data-bs-toggle="modal"
                       data-bs-target="#addItemModal">Created: $Created.Date()<br/>$Status.Name: $Title</a>
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
                       class="js-formaction badge text-bg-secondary link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
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
