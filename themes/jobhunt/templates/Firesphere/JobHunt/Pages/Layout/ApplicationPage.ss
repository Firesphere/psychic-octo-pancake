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
                <div class="my-2 col-sm-6 col-md-4">
                    <button type="button" class="btn btn-primary js-formaction pt-1"
                            data-itemtype="application"
                            data-bs-toggle="modal"
                            data-bs-target="#addItemModal">
                        Add new application
                    </button>
                </div>
                <div class="my-2 col-sm-6 col-md-4 order-md-last">
                    <% include ListFilters %>
                </div>
                <div class="col-sm-12 col-md-4 my-2 text-sm-start">
                    <% include Pagination PaginatedMatches=$Applications, Sizing=sm %>
                </div>
            </div>
        </div>

        <div class="col-12">

            <div class="py-3">
                <% if $CurrentUser.ViewStyle != 'Card' %>
                    <% include ApplicationTable %>
                <% else %>
                    <% include ApplicationCards %>
                <% end_if %>
            </div>
        </div>
    </div>
    <% include Pagination PaginatedMatches=$Applications, Sizing=lg %>
</div>
