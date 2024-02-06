<% loop $Applications %>

<tr class="$EvenOdd table-group-divider">
    <td>
        <div class="justify-content-start">
            <% with $Company %>
                <div class="d-flex justify-content-between">
                    <b>
                        <a href="#"
                           class="js-fav pe-2 link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                           data-id="$Up.ID" title="Favourite this application">
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
    <td colspan="2"><a href="$InternalLink" title="View application">$Role</a></td>
    <td>$ApplicationDate.Nice()</td>
    <td class="text-center">
        <div class="badge text-bg-$Status.ColourStyle">$Status.Name</div>
    </td>
    <td class="text-center">
        <a href="#"
           title="Edit application"
           class="js-formaction"
           data-id="$ID"
           data-itemtype="application-edit"
           data-bs-toggle="modal"
           data-bs-target="#addItemModal"><i class="bi bi-pencil"></i></a>
    </td>
    <td class="col-lg text-center"><a href="$InternalLink" title="View application"><i
        class="bi bi-eye-fill"></i></a></td>
</tr>
<tr class="$OddEven">
    <td rowspan="3">
        <% if $Link %>
            <a href="$Link" target="_blank">Job description</a>
        <% end_if %>
        <% if $PayUpper || $PayLower %><br/>Pay:<% end_if %>
        <% if $PayUpper %>
            <% if $PayLower %>$PayLower - <% end_if %>$PayUpper
        <% end_if %>
        <% if not $PayUpper && $PayLower %>$PayLower<% end_if %>
    </td>
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
    <td class="text-center">
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
    <td class="text-center">
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
    <td class="text-center">
        <a href="#"
           title="Add interview"
           class="js-formaction"
           data-application="$ID"
           data-itemtype="interview-add"
           data-bs-toggle="modal"
           data-bs-target="#addItemModal">
            <i class="bi bi-person-add"></i>
        </a>
    </td>
</tr>
<% end_loop %>