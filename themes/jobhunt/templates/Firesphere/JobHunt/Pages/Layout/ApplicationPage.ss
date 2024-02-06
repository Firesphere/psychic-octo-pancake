<div class="">
    <div class="row">
        <h1 class="col-12">$Title</h1>
    </div>
    <div class="row">
        <% if $Content %>
            <div class="col-12 order-md-first">
                $Content
            </div>
        <% end_if %>
        <div class="col-12">
            <div class="row d-flex justify-content-between">
                <div class="my-2 col-sm-6 col-md-2">
                    <button type="button" class="btn btn-primary js-formaction pt-1"
                            data-itemtype="application"
                            data-bs-toggle="modal"
                            data-bs-target="#addItemModal">
                        Add new application
                    </button>
                </div>
                <div class="my-2 col-sm-6 col-md-6 order-md-last">
                    <% include ListFilters %>
                </div>
                <div class="col-sm-12 col-md-1 offset-md-3 my-2 text-sm-start">
                    <% include Pagination PaginatedMatches=$Applications, Sizing=sm %>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="py-3">
                <% if $CurrentUser.JobApplications.Count %>
                    <% if $CurrentUser.ViewStyle == 'Table' %>
                        <% include ApplicationTable %>
                    <% else %>
                        <div class="row pb-3">
                            <div class="col-sm-3 col-12">
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
                            <div class="col-sm-3 col-12">
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
                        </div>
                        <div id="applicationtable_body">
                            <% include ApplicationCards %>
                        </div>
                    <% end_if %>
                <% else %>
                    <h3>Import</h3>
                    <p>You can import applications from CSV via the button below.</p>
                    <p>Please be aware that the import will not check for duplicate applications, interviews, notes,
                        etc.</p>
                    <p><a href="$SiteConfig.DemoCSV.Link" title="download example csv">Example CSV</a></p>
                    <button type="button" class="btn btn-primary js-formaction"
                            data-itemtype="import"
                            data-bs-toggle="modal"
                            data-bs-target="#addItemModal">
                        Import from CSV
                    </button>
                <% end_if %>
            </div>
        </div>
    </div>
    <% include Pagination PaginatedMatches=$Applications, Sizing=lg %>
</div>
