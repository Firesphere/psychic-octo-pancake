<div class="py-5 bg-opacity-50">
    <div class="container">
        <div class="row">
            <h1 class="col-12">$Title</h1>
            <div class="col-8">
                $Content
                <div class="mx-2">&nbsp;</div>
                <button type="button" class="btn btn-primary js-formaction"
                        data-itemtype="application"
                        data-bs-toggle="modal"
                        data-bs-target="#addItemModal">
                    Add new application
                </button>
                <div class="col py-3">
                    <h3>Applications</h3>
                    <% include ApplicationTable %>
                </div>
            </div>
            <% include UserSidebar %>
        </div>
    </div>
</div>
