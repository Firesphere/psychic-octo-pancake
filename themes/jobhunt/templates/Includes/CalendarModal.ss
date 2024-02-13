<div id="interview_$Day" class="interviews modal modal-lg">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Interviews</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" role="tablist">
                    <% loop $Interviews %>
                        <li class="nav-item" role="presentation">
                            <div class="nav-link <% if $IsFirst %>active<% end_if %>"
                                 id="interview-summary-$ID" data-bs-toggle="tab"
                                 data-bs-target="#interview-$ID"
                                 type="button" role="tab" aria-controls="home-tab-pane"
                                 aria-selected="true">
                                <h5 class="card-title">$Application.Company.Name</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Interview at $DateTime.Nice()</h6>
                            </div>
                        </li>
                    <% end_loop %>
                </ul>
                <div class="tab-content text-start border-1">
                    <% loop $Interviews %>
                        <div
                            class="tab-pane fade show <% if $IsFirst %>active<% end_if %>"
                            id="interview-$ID" role="tabpanel"
                            aria-labelledby="interview-summary-$ID" tabindex="0">
                            <div class="card border-top-0 rounded-top-0">
                                <% if $Notes %>
                                    <h5 class="ps-2 mb-0">Notes:</h5>
                                    <div class="card-body">
                                        <% loop $Notes %>
                                            <div
                                                class="note p-4 <% if $Odd %>text-bg-light<% else %>text-bg-secondary<% end_if %>">
                                                <p class="card-text">$Note</p>
                                                <small>$Created.Nice()</small>
                                            </div>
                                        <% end_loop %>
                                    </div>
                                <% end_if %>
                                <% if $Application.Link %>
                                    <a href="$Application.Link" class="card-link p-2">$Application.Role</a>
                                <% end_if %>
                            </div>
                        </div>
                    <% end_loop %>
                </div>
            </div>
        </div>
    </div>
</div>
