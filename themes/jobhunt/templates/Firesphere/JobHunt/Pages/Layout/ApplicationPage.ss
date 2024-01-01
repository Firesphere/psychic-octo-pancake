<div class="py-5 bg-opacity-50">
    <div class="container">
        <div class="row">
            <h1 class="col-12">$Title</h1>
            <div class="col-6">
                $Content
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary js-formaction"
                        data-itemtype="application"
                        data-bs-toggle="modal"
                        data-bs-target="#addItemModal">
                    Add new application
                </button>
            </div>
            <div class="col py-3">
                <h3>Applications</h3>
                <% include ApplicationTable %>
            </div>
        </div>
    </div>
</div>
