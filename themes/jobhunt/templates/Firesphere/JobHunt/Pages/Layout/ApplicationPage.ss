<div class="py-5 bg-opacity-50">
    <div class="row">
        <h1 class="col-12">$Title</h1>
    </div>
    <div class="row">
        <div class="col-12 order-md-first">
            $Content
        </div>
        <div class="col col-xs-12 col-md-11 d-flex justify-content-between">
            <div class="my-2">
                <button type="button" class="btn btn-primary js-formaction"
                        data-itemtype="application"
                        data-bs-toggle="modal"
                        data-bs-target="#addItemModal">
                    Add new application
                </button>
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
