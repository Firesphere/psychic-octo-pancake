<table class="table table-responsive table-responsive-sm table-sm">
    <thead>
    <tr>
        <th scope="col" class="border-start col col-lg-3">
            <div class="d-flex justify-content-between">
                <span class="<% if $SortDirection == 'Company.NameASC' || $SortDirection == 'Company.NameDESC' %>
                border-bottom border-primary h5 bold active<% end_if %>">
                    <a href="$Top.Link?sort[Company.Name]=<% if $SortDirection == 'Company.NameASC' %>DESC<% else %>ASC<% end_if %>"><i
                        class="bi bi-sort-alpha-down<% if $SortDirection == 'Company.NameDESC' %>-alt<% end_if %>"></i></a>
                </span>
                <label for="companyfilter">Company</label>
                <a title="Company filter" href="#" class="bi bi-funnel" id="show_companyfilter"></a>
            </div>
            <div class="d-flex d-none" id="companyfilter_group">
                <div class="input-group">
                    <input id="companyfilter" type="text" class="form-control col" placeholder="Quickfilter"
                           aria-placeholder="Quickfilter"/>
                    <a href="#" title="Clear company filters" class="btn btn-outline-secondary" type="button" id="clear_companyfilter"><i
                        class="bi bi-x"></i></a>
                </div>
            </div>
        </th>
        <th scope="col" colspan="3" class="col col-lg-3 border-start">
            <div class="d-flex justify-content-between">
                <span></span>
                <label for="rolefilter">Role</label>
                <a href="#" title="Role name filter" class="bi bi-funnel" id="show_rolefilter"></a>
            </div>
            <div class="d-flex d-none" id="rolefilter_group">
                <div class="input-group">
                    <input id="rolefilter" type="text" class="form-control" placeholder="Quickfilter"
                           aria-placeholder="Quickfilter"/>
                    <a href="#" title="Clear role name filter" class="btn btn-outline-secondary" type="button" id="clear_rolefilter"><i
                        class="bi bi-x"></i></a>
                </div>
            </div>
        </th>
        <th scope="col" class="border-bottom-0 border-start">
            <div class="d-flex justify-content-between ">
            <span class="<% if $SortDirection == 'ApplicationDateASC' || $SortDirection == 'ApplicationDateDESC' %>
                border-bottom border-primary h5 active bold<% end_if %>">
                <a href="$Top.Link?sort[ApplicationDate]=<% if $SortDirection == 'ApplicationDateASC' %>DESC<% else %>ASC<% end_if %>"><i
                    class="bi bi-sort-numeric-down<% if $SortDirection != 'ApplicationDateASC' %>-alt<% end_if %>"></i></a>
            </span>
                <span>Application date</span>
                <span></span>
            </div>
        </th>
        <th scope="col" class="text-center col-1 border-bottom-0 border-start">
            <span>Status</span>
        </th>
        <th scope="col" colspan="2" class="col-1 border-start border-end"></th>
    </tr>
    </thead>
    <tbody class="table-group-divider" id="applicationtable_body">
        <% include ApplicationRow %>
    </tbody>
</table>
