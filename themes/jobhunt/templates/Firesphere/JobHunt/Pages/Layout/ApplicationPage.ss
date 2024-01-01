<div class="py-5 bg-opacity-50">
    <div class="container">
        <div class="row">
            <h1 class="col-12">$Title</h1>
            <div class="col-12">
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
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemLabel">Add <span class="item-title"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body" id="formcontainer">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
