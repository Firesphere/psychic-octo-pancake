<div class="row">
    <h1 class="col-12">$Title</h1>
</div>
<% if $Content %>
    <div class="row">
        <div class="col-12 order-md-first">
            $Content
        </div>
    </div>
<% end_if %>
<div class="row d-flex justify-content-between">
    <div class="col-sm-6 col-md-4">
        <button type="button" class="btn btn-primary js-formaction pt-1"
                data-itemtype="application"
                data-bs-toggle="modal"
                data-bs-target="#addItemModal">
            <%t Firesphere\JobHunt\Pages\ApplicationPage.NewApplication "Add new application" %>
        </button>
    </div>
    <div class="col-sm-6 col-md-4 order-md-last">
        <% include ListFilters %>
    </div>
    <div class="col-sm-12 col-md-2 text-sm-start">
        <% include Pagination PaginatedMatches=$Applications, Sizing=sm %>
    </div>
</div>

<div class="row">
    <% if $CurrentUser.JobApplications.Count %>
        <div class="col-md-3 col-sm-6 col-12">
            <label for="companyfilter">Company</label>
            <div class="input-group">
                <input id="companyfilter" type="text" class="form-control col"
                       placeholder="Quickfilter"
                       aria-placeholder="Quickfilter"/>
                <a href="#" class="btn btn-outline-secondary" type="button"
                   id="clear_companyfilter"><i
                    class="bi bi-x"></i></a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <label for="rolefilter">Role</label>
            <div class="input-group">
                <input id="rolefilter" type="text" class="form-control col"
                       placeholder="Quickfilter"
                       aria-placeholder="Quickfilter"/>
                <a href="#" class="btn btn-outline-secondary" type="button"
                   id="clear_rolefilter"><i
                    class="bi bi-x"></i></a>
            </div>
        </div>
        <div class="py-1 col-12">
            <% if $CurrentUser.ViewStyle == 'Table' %>
                <% include ApplicationTable %>
            <% else %>
                <div id="applicationtable_body">
                    <% include ApplicationCards %>
                </div>
            <% end_if %>
        </div>
    <% else %>
        <div class="py-1 col-12">
            <h3>No applications!</h3>
            <p><%t Firesphere\JobHunt\Pages\ApplicationPage.StartAdding "Start adding applications" %>.</p>
        </div>
    <% end_if %>
</div>
<% include Pagination PaginatedMatches=$Applications, Sizing=md %>
