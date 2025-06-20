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
<% if $CurrentUser.ShareBoard %>
    <div class="row">
        <div class="my-1 col-12 text-end" title="Click to copy">
            <%t Firesphere\JobHunt\Pages\ApplicationPage.Share "Share your applications, read-only" %>: <a href="$ShareLink" class="js-copytext" title="Click to copy"><i
                class="bi bi-clipboard-pulse js-copytext-icon"></i>
                Click to copy</a>
        </div>
    </div>
<% end_if %>

<div class="row">
    <% if $CurrentUser.JobApplications.Count %>
        <% if not $IsSharePage %>
            <% if $CurrentUser.ViewStyle != "Table" %>
                <div class="col-md-3 col-sm-6 col-12 mb-1">
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
                <div class="col-md-3 col-sm-6 col-12 mb-1">
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
            <% else %>
                <div class="col-md-6 d-none d-md-block">&nbsp;</div>
            <% end_if %>
            <div class="col-md-6 col-sm-12 col-12 mt-auto">
                <ul class="nav justify-content-end">
                    <li class="nav-item py-1 <% if $Action != "drafts" && $ClassName.ShortName == "ApplicationPage" %>border border-2 rounded-top border-bottom-0<% end_if %>">
                        <a class="nav-link" aria-current="page" href="$ApplicationsLink">Active</a>
                    </li>
                    <li class="nav-item py-1 <% if $Action == "drafts" %>border border-2 rounded-top border-bottom-0<% end_if %>">
                        <a class="nav-link"
                           href="$getApplicationsLink('drafts')">Draft</a>
                    </li>
                    <li class="nav-item py-1 <% if $ClassName.ShortName == 'ArchivePage' %>border border-2 rounded-top border-bottom-0<% end_if %>">
                        <a class="nav-link"
                           href="$ArchivedLink">Archived</a>
                    </li>
                </ul>
            </div>
        <% end_if %>
        <div class="mb-1 pt-2 col-12 border-top">
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
