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
<% if not $IsSharePage %>
    <div class="row d-flex justify-content-between">
        <div class="col-sm-12 col-md-4">
            <button type="button" class="btn btn-primary js-formaction pt-1"
                    data-itemtype="application"
                    data-bs-toggle="modal"
                    data-bs-target="#addItemModal">
                <%t Firesphere\JobHunt\Pages\ApplicationPage.NewApplication "Add new application" %>
            </button>
        </div>
        <div class="d-none d-md-block col-sm-12 col-md-4 order-md-last">
            <% include ListFilters %>
        </div>
        <div class="col-md-2 d-md-block d-none">
            <% include Pagination PaginatedMatches=$Applications, Sizing=sm %>
        </div>
    </div>
<% end_if %>
<div class="row">
    <% if $CurrentUser.JobApplications.Count %>
        <% if not $IsSharePage %>
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
            <% if $CurrentUser.ShareBoard %>
                <div class="mb-2 col-md-3 col-sm-12" title="Click to copy">
                    <%t Firesphere\JobHunt\Pages\ApplicationPage.Share "Share your applications, read-only" %>:<br/>
                    <a href="$ShareLink" class="js-copytext" title="Click to copy"><i
                        class="bi bi-clipboard-pulse js-copytext-icon"></i>
                        Click to copy</a>
                </div>
            <% end_if %>
            <div class="col-md-<% if $CurrentUser.ShareBoard %>3<% else %>6<% end_if %> col-sm-12 col-12 mt-auto">
                <ul class="nav justify-content-end border-bottom my-1">
                    <li class="nav-item <% if $Action != "drafts" %>border border-2 rounded-top border-bottom-0<% end_if %>">
                        <a class="nav-link" aria-current="page" href="$Link">Active</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <% if $Action == "drafts" %>border border-2 rounded-top border-bottom-0<% end_if %>"
                           href="$Link('drafts')">Draft</a>
                    </li>
                </ul>
            </div>
        <% end_if %>
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
