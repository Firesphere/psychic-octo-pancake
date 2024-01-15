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
        <div class="col col-xs-12 d-flex justify-content-between">
            <div class="my-2">
                <button type="button" class="btn btn-primary js-formaction"
                        data-itemtype="application"
                        data-bs-toggle="modal"
                        data-bs-target="#addItemModal">
                    Add new application
                </button>
<%--                    <button type="button" class="btn btn-primary js-formaction"--%>
<%--                            data-itemtype="import"--%>
<%--                            data-bs-toggle="modal"--%>
<%--                            data-bs-target="#addItemModal">--%>
<%--                        Import from CSV--%>
<%--                    </button>--%>
            </div>
            <div class="my-2">
                <% include ListFilters %>

            </div>
        </div>

        <div class="col-12">
            <div class="py-3">
                <% include ApplicationTable %>
            </div>
        </div>
    </div>
    <% include Pagination PaginatedMatches=$Applications %>
</div>
