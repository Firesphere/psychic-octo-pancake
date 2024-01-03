<div class="py-5 bg-opacity-50">
    <div class="row">
        <h1 class="col-12">$Title</h1>
    </div>
    <div class="row">
        <div class="col-12 order-md-first">
            $Content
            <div class="my-2">&nbsp;</div>
            <button type="button" class="btn btn-primary js-formaction"
                    data-itemtype="application"
                    data-bs-toggle="modal"
                    data-bs-target="#addItemModal">
                Add new application
            </button>
            <div class="py-3">
                <h3>Applications</h3>
                <% include ListFilters %>
                <% include ApplicationTable %>
            </div>
        </div>
    </div>
    <% include Pagination PaginatedMatches=$Applications %>
</div>
